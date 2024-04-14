<?php

namespace App\Http\Controllers;

use App\Constants\ResponseMessages;

use App\Http\Requests\Transactions\TransactionReportRequest;
use App\Services\TransactionsService;
use Illuminate\Http\JsonResponse;

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
        $this->response->data = $this->service->getTransactionReport($request->all());

        return response()->json([
            'message' => $this->response->message,
            'data' => $this->response->data
        ], $this->response->code);
    }

//    /**
//     * @param PartyRequest $request
//     * @return JsonResponse
//     */
//    public function store(PartyRequest $request): JsonResponse
//    {
//        DB::beginTransaction();
//        try {
//            $cave = $this->service->store($request->all());
//            $this->response->message = ResponseMessages::CREATED;
//        } catch (Exception $e) {
//            $this->response->message = ResponseMessages::ERROR;
//            $this->response->data = $e->getMessage();
//            $this->response->code = $e->getCode();
//
//            DB::rollback();
//            return response()->json([
//                'message' => $this->response->message,
//                'data' => $this->response->data
//            ], $this->response->code);
//        }
//
//        DB::commit();
//        return response()->json([
//            'message' => $this->response->message,
//            'data' => $cave
//        ], $this->response->code);
//    }
//
//    /**
//     * @param PartyRequest $request
//     * @param $id
//     * @return JsonResponse
//     */
//    public function update(PartyRequest $request, $id): JsonResponse
//    {
//        DB::beginTransaction();
//        try {
//            $cave = $this->service->update($request->all(), $id);
//            $this->response->message = ResponseMessages::UPDATED;
//        } catch (Exception $e) {
//            $this->response->message = ResponseMessages::ERROR;
//            $this->response->data = $e->getMessage();
//            $this->response->code = $e->getCode();
//
//            DB::rollback();
//            return response()->json([
//                'message' => $this->response->message,
//                'data' => $this->response->data
//            ], $this->response->code);
//        }
//
//        DB::commit();
//        return response()->json([
//            'message' => $this->response->message,
//            'data' => $cave
//        ], $this->response->code);
//    }

}
