<?php

namespace Gregorysouzasilva\LivewireCrud\Traits;

use Carbon\Carbon;
use File;
use Illuminate\Support\Facades\Storage;

trait ModelActionsTrait {

    protected $separator;

    public $rules = [
        'client' => 'nullable',
    ];

    public function create()
    {
        //$this->clearForm();
        $this->model = new $this->modelClass;
        if (method_exists($this, 'loadDefaultCreateData')) {
            $this->loadDefaultCreateData();
        }
        if (empty($this->useModal)) {
            $this->showForm(true);
        } else {
            $this->openModalPopover('create');
        }
        $this->action = 'create';
    }

    public function store()
    {
        $this->validate();

         // upload file just for one file and field.
         foreach ($this->files ?? [] as $field => $bucket) {
            if (!empty($this->{$field}) && is_array($this->{$field})) {
                $this->{$field}[0] = $this->{$field}[0]->store($bucket, $bucket);
                $this->model->{$field} = $this->{$field}[0];
            } elseif(!empty($this->{$field})) {
                $this->{$field} = $this->{$field}->store($bucket, $bucket);
                $this->model->{$field} = $this->{$field};
            }
        }
        
        $this->model->save();
        $this->dispatch('alert', 
            type: 'success',  
            message: $this->modelId ? 'Record updated.' : 'Record created.'
        );

        if (method_exists($this, 'afterStore')) {
            return $this->afterStore();
        }

        if (empty($this->useModal)) {
            $this->showForm(false);
        } else {
            $this->closeModalPopover();
        }
        //$this->clearForm();
        $this->model = new $this->modelClass;
    }

    public function edit($id) {
        //$this->clearForm();
        $this->model = $this->modelClass::when(!empty($this->client->id), function ($query) {
            $query->where('client_id', $this->client->id);
        })->findOrFail($id);
        if (method_exists($this, 'loadDefaultEdit')) {
            $this->loadDefaultEdit();
        }
        $this->modelId = $this->model->getKey();
        $this->routeParams['uuid'] = $this->model->uuid;
        if (empty($this->useModal)) {
            $this->showForm(true);
        } else {
            $this->openModalPopover('create');
        }
        $this->action = $this->modelId;
    }

    public function duplicate($id) {
        //$this->clearForm();
        $model = $this->modelClass::when($this->client, function ($query) {
            $query->where('client_id', $this->client->id);
        })->findOrFail($id)->toArray();

        unset($model['id']);
        unset($model['uuid']);
        $this->model = $this->modelClass::create($model);
        $this->modelId = $this->model->getKey();
        if (empty($this->useModal)) {
            $this->showForm(true);
        } else {
            $this->openModalPopover('create');
        }
    }

    public function deleteConfirm($id) {
        $this->dispatch('swal:confirm', 
            type: 'warning',
            title: 'Are you sure?',
            text: 'you are about to delete this record',
            data: [
                'method' => 'onDelete',
                 'id' => $id,
                 'modelClass' => $this->modelClass ?? '',
            ]
        );
    }
    
    public function onDelete($array)
    {
        $id = $array['id'];
        $this->model = $this->modelClass::when(!empty($this->client), function ($query) {
            $query->where('client_id', $this->client->id);
        })->findOrFail($id);
        
        if (method_exists($this->model, 'hasFile') && $this->model->hasFile()) {
            // Delete file from storage
            $storage = explode('/', $this->model->file);
            $resp = Storage::disk($storage[0])->delete($this->model->file);
        }
        $this->model->delete();
        
        //$this->clearForm();
    }

    public function confirmComplete($id) {
        $this->dispatch('swal:confirm', [
           'type' => 'warning',
           'title' => 'Are you sure you want to complete?',
           'text' => 'Complete action will block ' . $id . ' from further editing for this person.',
           'data' => [
               'method' => 'onPageComplete',
                'id' => $id,
           ]
       ]);

       $this->dispatch('swal:confirm',
              type: 'warning',
              title: 'Are you sure you want to complete?',
              text: 'Complete action will block ' . $id . ' from further editing for this person.',
              data: [
                'method' => 'onPageComplete',
                 'id' => $id,
              ]
         );
   }

   public function onPageComplete($data) {
        $subType = $data['id'];
        $this->contact->statesRelation()->create([
            'stateble_type' => 'Member',
            'sub_type' => $subType,
            'user_id' => auth()->user()->id,
            'status' => 'completed',
        ]);
   }
    public function onPageDismiss($subType) {
        $this->contact->statesRelation()->create([
            'stateble_type' => 'Member',
            'sub_type' => $subType,
            'user_id' => auth()->user()->id,
            'status' => 'dismissed',
        ]);
    }

   public function confirmReopen($id) {
        $this->dispatch('swal:confirm',
            type: 'warning',
            title: 'Are you sure you want to reopen?',
            text: 'Reopen will unlock ' . $id . ' for client users editing for this person.',
            data: [
                'method' => 'onPageReopen',
                'id' => $id,
            ]
        );
}

public function onPageReopen($data) {
    $subType = $data['id'];
    $this->contact->statesRelation()->create([
        'stateble_type' => 'Member',
        'sub_type' => $subType,
        'user_id' => auth()->user()->id,
        'status' => 'open',
    ]);
}

    // Run model actions
    public function actionConfirm($method, $id, $confirmation = null) {
       // if no confirmation is needed, just run the method
         if (empty($confirmation)) {
              $this->actionRunModel([$method, $id]);
              return;
         }
            $this->dispatch('swal:confirmModel', [
                'type' => 'warning',
                'title' => 'Are you sure?',
                'text' => $confirmation,
                'id' => $id,
                'method' => $method,
                'modelClass' => $this->modelClass ?? '',
            ]);
    }

    public function actionRunModel($array) {
        if (!empty($array[2]) && $array[2] != $this->modelClass) {
            return;
        }
        $method = $array[0];
        $id = $array[1];
        $model = $this->modelClass::findOrFail($id);
        if (method_exists($model, $method)) {
            $model->{$method}($id);
            if (empty($model->errorMessage)) {
                $this->dispatch('alert',
                    type: 'success',  
                    message: substr($method, 2) . ' done!',   
                );
            } else {
                $this->dispatch('alert',
                    type: 'error',  
                    title: 'Error',
                    message: $model->errorMessage ?? 'Action not executed.',);
            }
        } else {
            throw new \Exception('Method not found.');
        }
    }

    public function actionRun($array) {
        if (!empty($array['modelClass']) && $array['modelClass'] != $this->modelClass) {
            return;
        }
        if (method_exists($this, $array['method'])) {
            $this->{$array['method']}($array);
            if (empty($model->errorMessage)) {
                $this->dispatch('alert',
                    type: 'success',  
                    message: substr($method, 2) . ' done!',   
                );
            } else {
                $this->dispatch('alert',
                    type: 'error',  
                    title: 'Error',
                    message: $model->errorMessage ?? 'Action not executed.',);
            }
        } else {
            throw new \Exception('Method not found.');
        }
    }
}