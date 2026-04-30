<?php

namespace Gregorysouzasilva\LivewireCrud\Traits;

use Illuminate\Support\Facades\Storage;

trait ModelActionsTrait
{

    protected $separator;

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
        if (method_exists($this, 'beforeValidate')) {
            $this->beforeValidate();
        }

        $this->validate();

         // upload file just for one file and field.
        $path = env('APP_TENANT') ? env('APP_TENANT') . '/' : '';
        foreach ($this->files ?? [] as $field => $bucket) {
            if (!empty($this->{$field}) && is_array($this->{$field})) {
                $this->{$field}[0] = $this->{$field}[0]->store($path . $bucket, $bucket);
                $this->model->{$field} = $this->{$field}[0];
            } elseif(!empty($this->{$field})) {
                $this->{$field} = $this->{$field}->store($path . $bucket, $bucket);
                $this->model->{$field} = $this->{$field};
            }
        }

        if (method_exists($this, 'beforeStore')) {
            $this->beforeStore();
        }

        if (!$this->model->save()) {
            $this->toastr(
                type: 'error',
                title: 'Error',
                message: 'There was an error saving the record.'
            );
            return;
        }

        if (method_exists($this, 'afterSave')) {
            if (!$this->afterSave()) {
                $this->toastr(
                    type: 'error',
                    title: 'Error',
                    message: 'There was an error saving the record.'
                );
                return;
            }
        }

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
            !empty($this->client->id) && !in_array('client_id', $this->ignoreFilters), function ($query) {
                $query->where('client_id', $this->client->id);
            }
        )->when(
            !empty($this->client_contact->id) && !in_array('client_contact_id', $this->ignoreFilters), function ($query) {
                $query->where('client_contact_id', $this->client_contact->id);
            }
        )->when(
            !empty($this->service->id) && !in_array('service_id', $this->ignoreFilters), function ($query) {
                $query->where('service_id', $this->service->id);
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
            !empty($this->client->id) && !in_array('client_id', $this->ignoreFilters), function ($query) {
                $query->where('client_id', $this->client->id);
            }
        )->when(
            !empty($this->client_contact->id) && !in_array('client_contact_id', $this->ignoreFilters), function ($query) {
                $query->where('client_contact_id', $this->client_contact->id);
            }
        )->when(
            !empty($this->service->id) && !in_array('service_id', $this->ignoreFilters), function ($query) {
                $query->where('service_id', $this->service->id);
            }
        )->findOrFail($id)->toArray();

        unset($model['id']);
        unset($model['uuid']);
        $this->model = $this->modelClass::create($model);

        $this->canAction('duplicate');

        if (method_exists($this, 'loadDefaultEdit')) {
            $this->loadDefaultEdit();
        }

        $this->modelId = $this->model->getKey();
        if (empty($this->useModal)) {
            $this->onShowForm(true);
        } else {
            $this->openModalPopover('create');
        }
    }
    
    public function onDelete($id)
    {
        $this->model = $this->modelClass::when(
            !empty($this->client->id) && !in_array('client_id', $this->ignoreFilters), function ($query) {
                $query->where('client_id', $this->client->id);
            }
        )->when(
            !empty($this->client_contact->id) && !in_array('client_contact_id', $this->ignoreFilters), function ($query) {
                $query->where('client_contact_id', $this->client_contact->id);
            }
        )->when(
            !empty($this->service->id) && !in_array('service_id', $this->ignoreFilters), function ($query) {
                $query->where('service_id', $this->service->id);
            }
        )->findOrFail($id);

        $this->canAction('delete');
        
        if (method_exists($this->model, 'hasFile') && $this->model->hasFile() && !empty($this->files)) {
            // Delete file from storage
            foreach ($this->files ?? [] as $field => $bucket) {
                if (empty($this->model->{$field})) {
                    continue;
                }
                $storage = explode('/', $this->model->{$field});
                $resp = Storage::disk($storage[0])->delete($this->model->{$field});
            }
        }
        $this->model->delete();
        
        //$this->clearForm();
    }

    public function onPageComplete()
    {
        $this->canAction('complete');

        $this->contact->statesRelation()->create(
            [
            'stateble_type' => 'Member',
            'sub_type' => class_basename($this->model),
            'user_id' => auth()->user()->id,
            'status' => 'completed',
            ]
        );

        $this->contact->refresh();
    }
    public function onPageDismiss()
    {
        if (!hasRole('consultant')) {
            abort(403, 'Unauthorized action.');
        }

        $this->contact->statesRelation()->create(
            [
            'stateble_type' => 'Member',
            'sub_type' => class_basename($this->model),
            'user_id' => auth()->user()->id,
            'status' => 'dismissed',
            ]
        );

        $this->contact->refresh();
    }

    public function onPageReopen()
    {
        if (!hasRole('consultant')) {
            abort(403, 'Unauthorized action.');
        }

        $this->contact->statesRelation()->create(
            [
            'stateble_type' => 'Member',
            'sub_type' => class_basename($this->model),
            'user_id' => auth()->user()->id,
            'status' => 'open',
            ]
        );

        $this->contact->refresh();
    }
}
