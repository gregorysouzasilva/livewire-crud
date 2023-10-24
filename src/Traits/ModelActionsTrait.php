<?php

namespace Gregorysouzasilva\LivewireCrud\Traits;

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
            $this->onShowForm(true);
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
        $this->toastr( 
            type: 'success',
            title: 'Success',
            message: $this->modelId ? 'Record updated.' : 'Record created.'
        );

        if (method_exists($this, 'afterStore')) {
            return $this->afterStore();
        }

        if (empty($this->useModal)) {
            $this->onShowForm(false);
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
            $this->onShowForm(true);
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
            $this->onShowForm(true);
        } else {
            $this->openModalPopover('create');
        }
    }

    public function deleteConfirm($id) {
        $this->confirm( 
            type: 'warning',
            title: 'Are you sure?',
            message: 'you are about to delete this record',
            method: 'onDelete',
            id: $id,
            modelClass: $this->modelClass ?? '',
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
       $this->confirm(
              type: 'warning',
              title: 'Are you sure you want to complete?',
              message: 'Complete action will block ' . $id . ' from further editing for this person.',
              method: 'onPageComplete',
              id: $id,
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
        $this->confirm(
            type: 'warning',
            title: 'Are you sure you want to reopen?',
            message: 'Reopen will unlock ' . $id . ' for client users editing for this person.',
            method: 'onPageReopen',
            id: $id,
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

    public function prepareModelJsonFields() {
        // check if each rule is defined in the model
        foreach ($this->rules as $key => $rule) {
            // explode key to check if it is a nested rule
            $arr = explode('.', $key);
            if (count($arr) > 2) {
                $modelName = $arr[0];
                if (!isset($this->$modelName[$arr[1]])) {
                    $this->$modelName[$arr[1]] = [];
                }
                if (!isset($this->$modelName[$arr[1]][$arr[2]])) {
                    $this->$modelName[$arr[1]] = array_merge((array)$this->$modelName[$arr[1]], [$arr[2] => null]);
                }
            }
        }
    }
}
