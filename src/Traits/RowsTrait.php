<?php

namespace Gregorysouzasilva\LivewireCrud\Traits;

trait RowsTrait
{

    public function reorganizeItems($items, $sortField = 'order')
    {
        $newItems = [];
        foreach ($items as $item) {
            $newItems[$item[$sortField]] = $item;
        }
        ksort($newItems);
        $newItems = array_values($newItems);
        return $newItems;
    }
}