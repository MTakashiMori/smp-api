<?php

namespace App\Services;

use App\Repositories\ProductTypeRepository;

class ProductTypeService extends MainService
{

    public function __construct(ProductTypeRepository $repository)
    {
        $this->repository = $repository;
    }

}
