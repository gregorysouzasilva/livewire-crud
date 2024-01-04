<?php

namespace Gregorysouzasilva\LivewireCrud\Traits;

use Illuminate\Support\Facades\Storage;

trait ModelActionsTrait
{

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
        $this->model = new $this->modelClass;
    }

    public function edit($id)
    {
        $this->model = $this->modelClass::when(
            !empty($this->client->id), function ($query) {
                $query->where('client_id', $this->client->id);
            }
        )->findOrFail($id);
        
        $this->canAction('edit');

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

    public function duplicate($id)
    {
        $model = $this->modelClass::when(
            $this->client, function ($query) {
                $query->where('client_id', $this->client->id);
            }
        )->findOrFail($id)->toArray();

        unset($model['id']);
        unset($model['uuid']);
        $this->model = $this->modelClass::create($model);

        $this->canAction('duplicate');

        $this->modelId = $this->model->getKey();
        if (empty($this->useModal)) {
            $this->onShowForm(true);
        } else {
            $this->openModalPopover('create');
        }
    }
    
    public function onDelete($array)
    {
        $id = $array['id'];
        $this->model = $this->modelClass::when(
            !empty($this->client), function ($query) {
                $query->where('client_id', $this->client->id);
            }
        )->findOrFail($id);

        $this->canAction('delete');
        
        if (method_exists($this->model, 'hasFile') && $this->model->hasFile()) {
            // Delete file from storage
            $storage = explode('/', $this->model->file);
            $resp = Storage::disk($storage[0])->delete($this->model->file);
        }
        $this->model->delete();
        
        //$this->clearForm();
    }

    public function onPageComplete($data)
    {
        $subType = $data['id'];

        $this->canAction('complete');

        $this->contact->statesRelation()->create(
            [
            'stateble_type' => 'Member',
            'sub_type' => $subType,
            'user_id' => auth()->user()->id,
            'status' => 'completed',
            ]
        );
    }
    public function onPageDismiss($subType)
    {
        if (!hasRole('consultant')) {
            abort(403, 'Unauthorized action.');
        }

        $this->contact->statesRelation()->create(
            [
            'stateble_type' => 'Member',
            'sub_type' => $subType,
            'user_id' => auth()->user()->id,
            'status' => 'dismissed',
            ]
        );
    }

    public function onPageReopen($data)
    {
        if (!hasRole('consultant')) {
            abort(403, 'Unauthorized action.');
        }

        $subType = $data['id'];
        $this->contact->statesRelation()->create(
            [
            'stateble_type' => 'Member',
            'sub_type' => $subType,
            'user_id' => auth()->user()->id,
            'status' => 'open',
            ]
        );
    }
    
}
