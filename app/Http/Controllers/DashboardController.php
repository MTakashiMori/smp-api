<?php

namespace App\Http\Controllers;

use App\Constants\ResponseMessages;

class DashboardController extends MainController
{

    public function __construct($service)
    {
        $this->service = $service;
        $this->response = (object) [
            'data' => null,
            'message' => ResponseMessages::SUCCESS,
            'code' => 200
        ];
    }

    public function getSuperAdminDashboard()
    {

    }

    public function getAdminDashboard()
    {

    }
    public function getSalesDashboard()
    {

    }

}
