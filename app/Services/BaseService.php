<?php

namespace App\Services;

use App\Repositories\BaseRepository;

class BaseService
{

    private $repository;

    /**
     * @param $repository
     */
    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    public function getAllData(): \Illuminate\Support\Collection
    {
        return $this->repository->getAllData();
    }

}
