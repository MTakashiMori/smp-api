<?php

namespace App\Http\Controllers;

use App\Constants\ResponseMessages;
use App\Services\DashboardService;
use Exception;
use Illuminate\Support\Facades\DB;

class DashboardController extends MainController
{

    public function __construct(DashboardService $service)
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
        DB::beginTransaction();
        try {
            $cave = $this->service->getSuperAdminDashboard();
            $this->response->message = ResponseMessages::SUCCESS;
        } catch (Exception $e) {
            $this->response->message = ResponseMessages::ERROR;
            $this->response->data = $e->getMessage();
            $this->response->code = $e->getCode();

            DB::rollback();
            return response()->json([
                'message' => $this->response->message,
                'data' => $this->response->data
            ], $this->response->code);
        }

        DB::commit();
        return response()->json([
            'message' => $this->response->message,
            'data' => $cave
        ], $this->response->code);
    }

    public function getAdminDashboard()
    {
        DB::beginTransaction();
        try {
            $cave = $this->service->getAdminDashboard();
            $this->response->message = ResponseMessages::SUCCESS;
        } catch (Exception $e) {
            $this->response->message = ResponseMessages::ERROR;
            $this->response->data = $e->getMessage();
            $this->response->code = $e->getCode();

            DB::rollback();
            return response()->json([
                'message' => $this->response->message,
                'data' => $this->response->data
            ], $this->response->code);
        }

        DB::commit();
        return response()->json([
            'message' => $this->response->message,
            'data' => $cave
        ], $this->response->code);
    }
    public function getSalesDashboard()
    {
        DB::beginTransaction();
        try {
            $cave = $this->service->getSalesDashboard();
            $this->response->message = ResponseMessages::SUCCESS;
        } catch (Exception $e) {
            $this->response->message = ResponseMessages::ERROR;
            $this->response->data = $e->getMessage();
            $this->response->code = $e->getCode();

            DB::rollback();
            return response()->json([
                'message' => $this->response->message,
                'data' => $this->response->data
            ], $this->response->code);
        }

        DB::commit();
        return response()->json([
            'message' => $this->response->message,
            'data' => $cave
        ], $this->response->code);
    }

}
