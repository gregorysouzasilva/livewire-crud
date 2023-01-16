<?php

namespace Gregorysouzasilva\LivewireCrud\Traits;

use Illuminate\Pagination\LengthAwarePaginator as Paginator;

trait ScopesTrait {

    public function scopeJoinRelation($query, $relation, $alias = '') {
        $relation = ($this->{$relation}());
        $qualifiedforeign = $relation->getQualifiedForeignKeyName();
        $table = $relation->getRelated()->getTable();
        $key = $relation->getRelated()->getKeyName();
        $qualified = "{$table}.{$key}";
        if (!empty($alias)) {
            $alias = $alias;
            $qualified = str_replace($table, $alias, $qualified);
        } else {
            $alias = $table;
        }

        return $query->leftjoin("$table as $alias", $qualifiedforeign, '=', $qualified);
    }

    public function scopePaginateForHaving($query, $perPage) {
        // Needs to use when using having
        $total = $query->get()->count();
        $perPage = empty($perPage) ? $query->count() : $perPage;
        $query = $query->forPage(request('page', 1), $perPage)->get();

        $query = new Paginator(
            $query,
            $total,
            $perPage,
            request('page', 1),
            ['path' => Paginator::resolveCurrentPath()]
        );
        return $query;
    }

    public function scopeFilterByWord($query, $search, $fields, $extraQuery = '') {
        $queryString = '';
        $bindings = [];
        foreach ($fields as $idx => $field) {
            if ($idx > 0) {
                $queryString .= ' or ';
            }
            $queryString .= "$field like ?";
            $bindings[] = "%$search%";
        }
        $query->havingRaw("($queryString $extraQuery)", $bindings);
    }

    public function scopeInRandomOrder($query) {
        $query->orderByRaw('RAND()');
    }


}