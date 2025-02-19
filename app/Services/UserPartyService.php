<?php

namespace App\Services;

use App\Repositories\UsersPartyRepository;

class UserPartyService extends MainService
{

    public function __construct(UsersPartyRepository $repository)
    {
        $this->repository = $repository;
    }

}
