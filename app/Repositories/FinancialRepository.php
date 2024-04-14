<?php

namespace App\Repositories;

use App\Models\Financial;

class FinancialRepository extends MainRepository
{

    public function __construct(Financial $model)
    {
        $this->model = $model;
        $this->relationship = [
            'party'
        ];
    }
}
