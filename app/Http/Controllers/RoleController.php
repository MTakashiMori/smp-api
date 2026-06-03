<?php

namespace App\Http\Controllers;

use App\Constants\ResponseMessages;
use App\Models\Permission;
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
            $data = $this->service->store($request->all());
            $this->response->message = ResponseMessages::CREATED;
        } catch (Exception $e) {
            $this->response->message = ResponseMessages::ERROR;
            $this->response->data = $e->getMessage();
            $this->response->code = $e->getCode() ?: 500;

            DB::rollback();
            return response()->json([
                'message' => $this->response->message,
                'data' => $this->response->data
            ], 500);
        }

        DB::commit();
        return response()->json([
            'message' => $this->response->message,
            'data' => $data
        ], $this->response->code);
    }

    public function permissions(): JsonResponse
    {
        return response()->json([
            'message' => ResponseMessages::SUCCESS,
            'data' => Permission::orderBy('description')->get(),
        ], 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $role = $this->service->update($request->all(), $id);
            $this->response->message = ResponseMessages::UPDATED;
        } catch (Exception $e) {
            $this->response->message = ResponseMessages::ERROR;
            $this->response->data = $e->getMessage();
            $this->response->code = $e->getCode() ?: 500;

            DB::rollback();
            return response()->json([
                'message' => $this->response->message,
                'data' => $this->response->data
            ], $this->response->code);
        }

        DB::commit();
        return response()->json([
            'message' => $this->response->message,
            'data' => $role
        ], $this->response->code);
    }

    public function getUserWithRoles(Request $request): JsonResponse
    {
        try {
            /** @var RoleService $service */
            $service = $this->service;
            $data = $service->getUsersWithRole($request->all());
            $this->response->message = ResponseMessages::SUCCESS;
        } catch (Exception $e) {
            $this->response->message = ResponseMessages::ERROR;
            $this->response->data = $e->getMessage();
            $this->response->code = $e->getCode() ?: 500;

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
            /** @var RoleService $service */
            $service = $this->service;
            $service->attachUsersToRole($request->all());
            $data = null;
            $this->response->message = ResponseMessages::SUCCESS;
        } catch (Exception $e) {
            $this->response->message = ResponseMessages::ERROR;
            $this->response->data = $e->getMessage();
            $this->response->code = $e->getCode() ?: 500;

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
