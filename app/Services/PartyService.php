<?php

namespace App\Services;

use App\Repositories\PartyRepository;

class PartyService extends MainService
{

    public function __construct(PartyRepository $repository)
    {
        $this->repository = $repository;
    }

}
