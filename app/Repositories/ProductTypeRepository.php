<?php

namespace App\Repositories;

use App\Models\ProductType;

class ProductTypeRepository extends MainRepository
{

    public function __construct(ProductType $model)
    {
        $this->model = $model;
    }
}
