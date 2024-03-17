<?php

namespace App\Http\Controllers;

use App\Services\UserService;

class UserController extends BaseController
{
    public function __construct(UserService $service)
    {
        parent::__construct($service);
    }
}
