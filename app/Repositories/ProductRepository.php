<?php

namespace App\Repositories;

use App\Models\Products;

class ProductRepository extends MainRepository
{

    public function __construct(Products $model)
    {
        $this->model = $model;
        $this->relationship = [];
    }
}
