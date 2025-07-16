<?php

namespace App\Repositories;

use App\Models\Party;

class PartyRepository extends MainRepository
{

    public function __construct(Party $model)
    {
        $this->model = $model;
        $this->relationship = [
            'address',
            'partyMenu',
            'users'
        ];
    }
}
