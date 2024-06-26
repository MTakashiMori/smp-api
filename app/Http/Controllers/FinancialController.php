<?php

namespace App\Http\Controllers;

use App\Constants\ResponseMessages;
use App\Services\FinancialService;

class FinancialController extends MainController
{
    /**
     * @param FinancialService $service
     */
    public function __construct(FinancialService $service)
    {
        $this->service = $service;
        $this->response = (object)[
            'data' => null,
            'message' => ResponseMessages::SUCCESS,
            'code' => 200
        ];
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
