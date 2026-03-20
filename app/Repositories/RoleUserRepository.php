<?php

namespace App\Repositories;

use App\Models\RoleUser;

class RoleUserRepository extends MainRepository
{

    public function __construct(RoleUser $model)
    {
        $this->model = $model;
        $this->relationship = [];
    }
}
