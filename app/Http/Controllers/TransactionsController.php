<?php

namespace App\Http\Controllers;

use App\Constants\ResponseMessages;

use App\Http\Requests\Transactions\TransactionReportRequest;
use App\Http\Requests\Transactions\TransactionRequest;
use App\Services\TransactionsService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class TransactionsController extends MainController
{
    /**
     * @param TransactionsService $service
     */
    public function __construct(TransactionsService $service)
    {
        $this->service = $service;
        $this->response = (object)[
            'data' => null,
            'message' => ResponseMessages::SUCCESS,
            'code' => 200
        ];
    }

    /**
     * @param TransactionReportRequest $request
     * @return JsonResponse
     */
    public function getTransactionReport(TransactionReportRequest $request)
    {
        $this->response->messsage = ResponseMessages::SUCCESS;
        $this->response->data = $this->transactionsService()->getTransactionReport($request->all());

        return response()->json([
            'message' => $this->response->message,
            'data' => $this->response->data
        ], $this->response->code);
    }

    /**
     * @param TransactionRequest $request
     * @return JsonResponse
     */
    public function store(TransactionRequest $request): JsonResponse
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
            ],  500);
        }

        DB::commit();
        return response()->json([
            'message' => $this->response->message,
            'data' => $data
        ], $this->response->code);
    }

    /**
     * @param TransactionRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(TransactionRequest $request, $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $data = $this->service->update($request->all(), $id);
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
            'data' => $data
        ], $this->response->code);
    }

    public function approve($id): JsonResponse
    {
        return $this->changeStatus($id, 'approve');
    }

    public function reject($id): JsonResponse
    {
        return $this->changeStatus($id, 'reject');
    }

    private function changeStatus($id, string $method): JsonResponse
    {
        DB::beginTransaction();
        try {
            $data = $this->transactionsService()->{$method}($id);
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
            'data' => $data
        ], $this->response->code);
    }

    private function transactionsService(): TransactionsService
    {
        return $this->service;
    }

}
