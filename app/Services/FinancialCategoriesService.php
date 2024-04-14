<?php

namespace App\Services;

use App\Repositories\FinancialCategoriesRepository;

class FinancialCategoriesService extends MainService
{

    public function __construct(FinancialCategoriesRepository $repository)
    {
        $this->repository = $repository;
    }

}
