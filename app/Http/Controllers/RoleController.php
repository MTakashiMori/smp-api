<?php

namespace App\Http\Controllers;

use App\Services\RoleService;

class RoleController extends BaseController
{

    public function __construct(RoleService $service)
    {
        parent::__construct($service);
    }
}
