<?php

namespace Gregorysouzasilva\LivewireCrud\Traits;

use App\Models\Client;

trait LoadData {

    protected function loadData($limit = 50) {

        $this->collection = $this->modelClass::select($this->model->getTable() . '.*');

        // if request route has client_id, filter by client_id
        if (!empty($this->client->id)) {
            $this->collection = $this->collection->where('client_id', $this->client->id);
        }

        // if request has contact_id, filter by contact_id
        if (!empty($this->contact->id)) {
            $this->collection = $this->collection->where('client_contact_id', $this->contact->id);
        }

        // if request has service id, filter by service_id
        if (!empty($this->service->id)) {
            $this->collection = $this->collection->where('service_id', $this->service->id);
        }

        //Sort
        if (!empty($this->sortField)) {
            $this->collection = $this->collection->orderBy($this->sortField, $this->sortDirection);
        }

        //Search by word
        if (!empty($this->search) && !empty($this->pageInfo['table']['search_fields'])) {
            $search = trim($this->search);
            $this->collection = $this->collection->filterByWord($search, $this->pageInfo['table']['search_fields']);
        }
         
        //Filter by field
        foreach ($this->filters ?? [] as $fieldName => $filter) {
            if (is_array($filter) && is_string($fieldName)) {
                // get index of the first element of filter
                foreach($filter as $key => $value) {
                    $NewfieldName = $fieldName . '.' . $key;
                    if (!empty($value)) {
                        if (is_array($value)) {
                            $value = array_filter($value);
                            if(count($value) > 0) {
                                $this->collection = $this->collection->whereIn($NewfieldName, $value);
                            }
                        } else {
                            $this->collection = $this->collection->where($NewfieldName, $value);
                        }
                    }
                }
            } else {
                if ($filter != '') {
                    if (is_array($filter)) {
                        $this->collection = $this->collection->whereIn($fieldName, $filter);
                    } else {
                        $this->collection = $this->collection->where($fieldName, $filter);
                    }
                }
            }
        }

        //Additional filter from Model, if method exists
        if (method_exists($this->model, 'scopeFilters')) {
            $this->collection = $this->collection->filters();
        }

        //Additional filters from Component, if method exists
        if (method_exists($this, 'addFilters')) {
            $this->collection = $this->addFilters($this->collection);
        }

         //Additional fields from Model, if method exists
         if (method_exists($this->model, 'scopeAddFields')) {
            $this->collection = $this->collection->addFields();
        }
        $this->collection = $this->collection->paginate($limit);
        //dd($this->collection);
    }

    public function sortBy($field)
    {
        $this->sortField = $field;
        $this->sortDirection = $this->sortDirection == 'desc' ? 'asc' : 'desc';
    }
    
}