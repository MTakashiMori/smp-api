<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository extends MainRepository
{

    public function __construct(Product $model)
    {
        $this->model = $model;
    }
}
