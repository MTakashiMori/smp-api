<?php

namespace App\Repositories;

use App\Models\PartyMenu;

class PartyMenuRepository extends MainRepository
{

    public function __construct(PartyMenu $model)
    {
        $this->model = $model;
        $this->relationship = ['party'];
    }
}
