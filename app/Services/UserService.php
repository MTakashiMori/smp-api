<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService extends MainService
{
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

}
