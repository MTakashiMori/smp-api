<?php

namespace App\Services;

use App\Repositories\TransactionsRepository;

class TransactionsService extends MainService
{

    public function __construct(TransactionsRepository $repository)
    {
        $this->repository = $repository;
    }

}
