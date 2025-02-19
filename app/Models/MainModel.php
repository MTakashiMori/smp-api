<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class MainModel extends Model
{

    public array $relationshipFields = [];

    public static function booted() {
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    /**
     * Scope a query to only include popular users.
     */
    public function scopeWhereModelLike(Builder $query, $data): void
    {
        foreach ($data as $column => $item) {

            if(in_array($column, $this->relationshipFields)) {
                [$relation, $relationColumn] = explode('.', $column, 2);

                $query->whereHas($relation, function ($q) use ($relationColumn, $item) {
                    $this->applyFilter($q, $relationColumn, $item);
                });

                continue;
            }

            $this->applyFilter($query, $column, $item);

//            if(is_int($item) || $column == 'id') {
//                $this->whereInteger($query, $column, $item);
//            }
//
//            if(is_array($item)) {
//                $query->orWhereIn($column, $item);
//            }
//
//            if(is_string($item)) {
//                $query->orWhere($column, 'LIKE', ('%' . $item .'%'));
//            }

        }
    }

    private function applyFilter(Builder $query, string $column, mixed $item): Builder
    {
        if (is_int($item) || $column === 'id') {
            $query->orWhere($column, $item);
        } elseif (is_array($item)) {
            $query->orWhereIn($column, $item);
        } elseif (is_string($item)) {
            $query->orWhere($column, 'LIKE', ('%' . $item . '%'));
        }
        return $query;
    }

}
