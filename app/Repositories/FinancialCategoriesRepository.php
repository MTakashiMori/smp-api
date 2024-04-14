<?php

namespace App\Repositories;

use App\Models\FinancialCategories;

class FinancialCategoriesRepository extends MainRepository
{

    public function __construct(FinancialCategories $model)
    {
        $this->model = $model;
        $this->relationship = [];
    }
}
