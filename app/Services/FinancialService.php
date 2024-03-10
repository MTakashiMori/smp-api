<?php

namespace App\Services;

use App\Repositories\FinancialRepository;

class FinancialService extends MainService
{

    public function __construct(FinancialRepository $repository)
    {
        $this->repository = $repository;
    }

}
