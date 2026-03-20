<?php

namespace App\Http\Controllers;

use App\Constants\ResponseMessages;
use App\Services\RoleService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends MainController
{
    public function __construct(RoleService $service)
    {
        $this->service = $service;
        $this->response = (object)[
            'data' => null,
            'message' => ResponseMessages::SUCCESS,
            'code' => 200
        ];
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $cave = $this->service->store($request->all());
            $this->response->message = ResponseMessages::CREATED;
        } catch (Exception $e) {
            dd($e);
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

    public function getUserWithRoles(Request $request): JsonResponse
    {
        try {
            $data = $this->service->getUsersWithRole($request->all());
            $this->response->message = ResponseMessages::SUCCESS;
        } catch (Exception $e) {
            $this->response->message = ResponseMessages::ERROR;
            $this->response->data = $e->getMessage();
            $this->response->code = $e->getCode();

            return response()->json([
                'message' => $this->response->message,
                'data' => $this->response->data
            ], $this->response->code);
        }

        return response()->json([
            'message' => $this->response->message,
            'data' => $data
        ], $this->response->code);
    }

    public function attachUsersToRole(Request $request): JsonResponse
    {
        try {
            $data = $this->service->attachUsersToRole($request->all());
            $this->response->message = ResponseMessages::SUCCESS;
        } catch (Exception $e) {
            $this->response->message = ResponseMessages::ERROR;
            $this->response->data = $e->getMessage();
            $this->response->code = $e->getCode();

            return response()->json([
                'message' => $this->response->message,
                'data' => $this->response->data
            ], $this->response->code);
        }

        return response()->json([
            'message' => $this->response->message,
            'data' => $data
        ], $this->response->code);
    }
}
