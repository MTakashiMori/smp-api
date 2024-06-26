<?php

namespace App\Http\Controllers;

use App\Constants\ResponseMessages;
use App\Http\Requests\Financial\FinancialCategoriesRequest;
use App\Services\FinancialCategoriesService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class FinancialCategoriesController extends MainController
{

    /**
     * @param FinancialCategoriesService $service
     */
    public function __construct(FinancialCategoriesService $service)
    {
        $this->service = $service;
        $this->response = (object)[
            'data' => null,
            'message' => ResponseMessages::SUCCESS,
            'code' => 200
        ];
    }

    /**
     * @param FinancialCategoriesRequest $request
     * @return JsonResponse
     */
    public function store(FinancialCategoriesRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $data = $this->service->store($request->all());
            $this->response->message = ResponseMessages::CREATED;
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
            'data' => $data
        ], $this->response->code);
    }

    /**
     * @param FinancialCategoriesRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(FinancialCategoriesRequest $request, $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $cave = $this->service->update($request->all(), $id);
            $this->response->message = ResponseMessages::UPDATED;
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
