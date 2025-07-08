<?php

namespace App\Http\Controllers;

use App\Constants\ResponseMessages;
use App\Http\Requests\Party\PartyRequest;
use App\Http\Requests\Party\PartyRequestAssignUsersToParty;
use App\Http\Requests\Party\PartyRequestGetPartiesByUser;
use App\Services\PartyService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PartyController extends MainController
{

    /**
     * @param PartyService $service
     */
    public function __construct(PartyService $service)
    {
        $this->service = $service;
        $this->response = (object)[
            'data' => null,
            'message' => ResponseMessages::SUCCESS,
            'code' => 200
        ];
    }

    /**
     * @param PartyRequest $request
     * @return JsonResponse
     */
    public function store(PartyRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $cave = $this->service->store($request->all());
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
            'data' => $cave
        ], $this->response->code);
    }

    /**
     * @param PartyRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(PartyRequest $request, $id): JsonResponse
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

    public function assignUsers(PartyRequestAssignUsersToParty $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $this->service->assignUsersToParty($request->all());
            $this->response->message = ResponseMessages::CREATED;

        } catch (Exception $e) {
            $this->response->message = ResponseMessages::ERROR;
            $this->response->data = $e->getMessage();
            $this->response->code = $e->getCode();

            DB::rollback();
            return response()->json([
                'message' => $this->response->message,
                'data' => $this->response->data
            ],  $this->response->code);
        }

        DB::commit();

        return response()->json([
            'message' => $this->response->message,
            'data' => null
        ], $this->response->code);
    }

    public function getPartiesByUser(PartyRequestGetPartiesByUser $request): JsonResponse
    {
        try {
            $cave = $this->service->getRelatedPartiesByUserId($request->all());
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
            'data' => $cave
        ], $this->response->code);
    }

}
