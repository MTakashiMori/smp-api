<?php

namespace App\Repositories;

use App\Models\Address;

class AddressRepository extends MainRepository
{

    public function __construct(Address $model)
    {
        $this->model = $model;
        $this->relationship = [];
    }
}
