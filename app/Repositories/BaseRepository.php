<?php

namespace App\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BaseRepository
{
    private $model;

    /**
     * @param $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    public function getAllData($params = []): Collection
    {
        return DB::table($this->model->getTable())
            ->where($params)
            ->get()
            ->orderBy('created_at', 'desc');
    }

}
