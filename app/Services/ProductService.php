<?php

namespace App\Services;

use App\Repositories\ProductRepository;

class ProductService extends MainService
{

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

}
