<?php

namespace App\Repositories;

use App\Models\PartyMenuProducts;

class PartyMenuProductRepository extends MainRepository
{

    public function __construct(PartyMenuProducts $model)
    {
        $this->model = $model;
        $this->relationship = [
            'product'
        ];
    }
}
