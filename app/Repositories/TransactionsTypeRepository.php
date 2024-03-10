<?php

namespace App\Repositories;

use App\Models\TransactionsType;

class TransactionsTypeRepository extends MainRepository
{

    public function __construct(TransactionsType $model)
    {
        $this->model = $model;
    }
}
