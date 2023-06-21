<?php

namespace App\Http\Controllers;

use App\Constants\ResponseMessages;
use App\Services\MainService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 *
 */
class MainController extends Controller
{

    /**
     * @var MainService
     */
    private $service;

    /**
     * @var array
     */
    private array $response = [
        'data' => null,
        'message' => ResponseMessages::SUCCESS,
        'code' => 200
    ];

    /**
     * @param MainService $service
     */
    public function __construct(MainService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $response = $this->response;

        $response['data'] = $this->service->index($request->all());

        return response()->json([
            'message' => $response['message'],
            'data' => $response['data']
        ], $response['code']);
    }

    /**
     * @param $request
     * @return JsonResponse
     */
    public function store($request)
    {
        $response = $this->response;

        $response['data'] = $this->service->store($request->all());

        return response()->json([
            'message' => $response['message'],
            'data' => $response['data']
        ], $response['code']);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $response = $this->response;

        $response['data'] = $this->service->index($id);

        return response()->json([
            'message' => $response['message'],
            'data' => $response['data']
        ], $response['code']);
    }

    /**
     * @param $id
     * @param $request
     * @return JsonResponse
     */
    public function update($id, $request)
    {
        $response = $this->response;

        $response['data'] = $this->service->update($id, $request->all());

        return response()->json([
            'message' => $response['message'],
            'data' => $response['data']
        ], $response['code']);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $response = $this->response;

        $response['data'] = $this->service->destroy($id);

        return response()->json([
            'message' => $response['message'],
            'data' => $response['data']
        ], $response['code']);
    }

}
