<?php

namespace App\Repositories;

use App\Models\PartyMenuGroup;

class PartyMenuGroupRepository extends MainRepository
{

    public function __construct(PartyMenuGroup $model)
    {
        $this->model = $model;
        $this->relationship = [];
    }
}
