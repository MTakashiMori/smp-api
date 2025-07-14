<?php

namespace App\Services;

use App\Repositories\PartyMenuGroupRepository;

class PartyMenuGroupService extends MainService
{

    public function __construct(PartyMenuGroupRepository $repository)
    {
        $this->repository = $repository;
    }

}
