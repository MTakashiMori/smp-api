<?php

namespace App\Repositories;

use App\Models\UserParty;

class UsersPartyRepository extends MainRepository
{
    public function __construct(UserParty $model)
    {
        $this->model = $model;
    }

    public function store($data)
    {
        return $this->model::create($data);
    }
}
