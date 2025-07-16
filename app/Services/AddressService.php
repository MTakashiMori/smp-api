<?php

namespace App\Services;

use App\Repositories\AddressRepository;

class AddressService extends MainService
{

    public function __construct(AddressRepository $repository)
    {
        $this->repository = $repository;
    }

}
