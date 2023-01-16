<?php

namespace App\Libs\Crud;

use Illuminate\Support\Collection;

class Table extends Collection {

    public $items = [];

    public $tableDefault = [
        'visible' => true,
        'label' => null,
        'field' => null,
        'type' => null,
        'inline_editable' => true,
        'filter_label' => null,
        'width' => null,
        'order' => 1,
        'fortmat' => null,
        'filter' => [
            'visible' => false,
            'default' => null,
            'width' => 4,
        ]
    ];

    public function add($array) {
        $this->items[] = (object)array_merge($this->tableDefault, $array);
        return $this;
    }

    public function hasHidden() {
        return $this->where('visible', false)->count() > 0;
    }

    public function getHidden() {
        return $this->where('visible', false)->all();
    }


}