<?php

namespace App\Repositories;

use App\Models\Transactions;

class TransactionsRepository extends MainRepository
{

    public function __construct(Transactions $model)
    {
        $this->model = $model;
    }
}
