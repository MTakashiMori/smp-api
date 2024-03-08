<?php

namespace App\Http\Controllers;

use App\Constants\ResponseMessages;
use App\Services\MainService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use stdClass;

class MainController extends Controller
{

    /**
     * @var MainService
     */
    protected MainService $service;

    public stdClass $response;

    /**
     * @param MainService $service
     */
    public function __construct(MainService $service)
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
    public function index(Request $request)
    {
        $this->response->messsage = ResponseMessages::SUCCESS;
        $this->response->data = $this->service->index($request->all());

        return response()->json([
            'message' => $this->response->message,
            'data' => $this->response->data
        ], $this->response->code);
    }

//    /**
//     * @param $request
//     * @return JsonResponse
//     */
//    public function store($request)
//    {
//        $response = $this->response;
//
//        $response['data'] = $this->service->store($request->all());
//
//        return response()->json([
//            'message' => $response['message'],
//            'data' => $response['data']
//        ], $response['code']);
//    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $this->response->messsage = ResponseMessages::SUCCESS;
        $this->response->data = $this->service->show($id);

        return response()->json([
            'message' => $this->response->message,
            'data' => $this->response->data
        ], $this->response->code);
    }

//    /**
//     * @param $id
//     * @param $request
//     * @return JsonResponse
//     */
//    public function update($id, $request)
//    {
//        $response = $this->response;
//
//        $response['data'] = $this->service->update($id, $request->all());
//
//        return response()->json([
//            'message' => $response['message'],
//            'data' => $response['data']
//        ], $response['code']);
//    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $this->response->messsage = ResponseMessages::SUCCESS;
        $this->response->data = $this->service->destroy($id);

        return response()->json([
            'message' => $this->response->message,
            'data' => $this->response->data
        ], $this->response->code);
    }

}
