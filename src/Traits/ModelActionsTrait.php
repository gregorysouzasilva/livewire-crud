<?php

namespace Gregorysouzasilva\LivewireCrud\Traits;

use Carbon\Carbon;
use File;
use Gregorysouzasilva\LivewireCrud\Crud;
use Illuminate\Support\Facades\Storage;

trait ModelActionsTrait {

    protected $separator;

    public $rules = [
        'client' => 'nullable',
    ];

    public function create()
    {
        $this->model = new $this->modelClass;
        $this->canAction('create');

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
        $this->dispatchBrowserEvent('alert', [
            'type' => 'success',  
            'message' => $this->modelId ? 'Record updated.' : 'Record created.',
        ]);

        if (method_exists($this, 'afterStore')) {
            return $this->afterStore();
        }

        if (empty($this->useModal)) {
            $this->showForm(false);
        } else {
            $this->closeModalPopover();
        }
        $this->model = new $this->modelClass;
    }

    public function edit($id) {
        $this->model = $this->modelClass::when(!empty($this->client->id), function ($query) {
            $query->where('client_id', $this->client->id);
        })->findOrFail($id);
        
        $this->canAction('edit');

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
        $model = $this->modelClass::when($this->client, function ($query) {
            $query->where('client_id', $this->client->id);
        })->findOrFail($id)->toArray();

        unset($model['id']);
        unset($model['uuid']);
        $this->model = $this->modelClass::create($model);

        $this->can('duplicate');

        $this->modelId = $this->model->getKey();
        if (empty($this->useModal)) {
            $this->showForm(true);
        } else {
            $this->openModalPopover('create');
        }
    }

    public function deleteConfirm($id) {
         $this->dispatchBrowserEvent('swal:confirm', [
            'type' => 'warning',
            'title' => 'Are you sure?',
            'text' => 'you are about to delete this record',
            'data' => [
                'method' => 'onDelete',
                 'id' => $id,
                 'modelClass' => $this->modelClass ?? '',
            ]
        ]);
    }
    
    public function onDelete($array)
    {
        $id = $array['id'];
        $this->model = $this->modelClass::when(!empty($this->client), function ($query) {
            $query->where('client_id', $this->client->id);
        })->findOrFail($id);

        $this->canAction('delete');
        
        if (method_exists($this->model, 'hasFile') && $this->model->hasFile()) {
            // Delete file from storage
            $storage = explode('/', $this->model->file);
            $resp = Storage::disk($storage[0])->delete($this->model->file);
        }
        $this->model->delete();
        
        //$this->clearForm();
    }

    public function confirmComplete($id) {
        $this->dispatchBrowserEvent('swal:confirm', [
           'type' => 'warning',
           'title' => 'Are you sure you want to complete?',
           'text' => 'Complete action will block ' . $id . ' from further editing for this person.',
           'data' => [
               'method' => 'onPageComplete',
                'id' => $id,
           ]
       ]);
   }

   public function onPageComplete($data) {
        $subType = $data['id'];

        $this->canAction('complete');

        $this->contact->statesRelation()->create([
            'stateble_type' => 'Member',
            'sub_type' => $subType,
            'user_id' => auth()->user()->id,
            'status' => 'completed',
        ]);
   }
    public function onPageDismiss($subType) {
        if (!hasRole('consultant')) {
            abort(403, 'Unauthorized action.');
        }

        $this->contact->statesRelation()->create([
            'stateble_type' => 'Member',
            'sub_type' => $subType,
            'user_id' => auth()->user()->id,
            'status' => 'dismissed',
        ]);
    }

   public function confirmReopen($id) {
        $this->dispatchBrowserEvent('swal:confirm', [
            'type' => 'warning',
            'title' => 'Are you sure you want to reopen?',
            'text' => 'Reopen will unlock ' . $id . ' for client users editing for this person.',
            'data' => [
                'method' => 'onPageReopen',
                'id' => $id,
            ]
        ]);
    }

    public function onPageReopen($data) {
        if (!hasRole('consultant')) {
            abort(403, 'Unauthorized action.');
        }

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
            // otherwise, show the confirmation modal
            $this->dispatchBrowserEvent('swal:confirmModel', [
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
            $this->canAction($method, $model);
            $model->{$method}($id);
            if (empty($model->errorMessage)) {
                $this->dispatchBrowserEvent('alert', [
                    'type' => 'success',  
                    'message' => substr($method, 2) . ' done!',   
                ]);
            } else {
                $this->dispatchBrowserEvent('swal:modal', [
                    'type' => 'error',
                    'title' => 'Error',
                    'text' => $model->errorMessage ?? 'Action not executed.',
                ]);
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
            if (empty($this->errorMessage)) {
                $this->dispatchBrowserEvent('alert', [
                    'type' => 'success',  
                    'message' => substr($array['method'], 2) . ' done!',   
                ]);
            } else {
                $this->dispatchBrowserEvent('swal:modal', [
                    'type' => 'error',
                    'title' => 'Error',
                    'text' => $this->errorMessage ?? 'Action not executed.',
                ]);
            }
        } else {
            throw new \Exception('Method not found.');
        }
    }

    public function canAction($action, $model = null) {
        if (!$model) {
            $model = $this->model;
        } 
        // for now just model actions are supported
        if ($model->evalTags($this->pageInfo['permissions'][$action] ?? false)) {
            return true;
        }
        // check if it's action from buttons and if role is set check it
        $button = collect($this->pageInfo['table']['buttons'] ?? [])->firstWhere('action', $action);
        if ($button && $model->evalTags($button['show'] ?? false) && hasRole($button['role'] ?? '')) {
            return true;
        }
        abort(403, 'Unauthorized action.');
    }
}