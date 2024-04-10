<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class MainModel extends Model
{
    /**
     * Scope a query to only include popular users.
     */
    public function scopeWhereModelLike(Builder $query, $data): void
    {
        foreach ($data as $column => $item) {

            if(is_int($item)) {
                $query->where($column, '=', $item);
            }

            if(is_array($item)) {
                $query->whereIn($column, $item);
            }

            if(is_string($item)) {
                $query->where($column, 'LIKE', ('%' . $item .'%'));
            }

        }
    }

}
