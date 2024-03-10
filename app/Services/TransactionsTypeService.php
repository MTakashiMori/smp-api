<?php

namespace App\Services;

use App\Repositories\TransactionsTypeRepository;

class TransactionsTypeService extends MainService
{

    public function __construct(TransactionsTypeRepository $repository)
    {
        $this->repository = $repository;
    }

}
