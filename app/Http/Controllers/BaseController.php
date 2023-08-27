<?php

namespace App\Http\Controllers;

use App\Constants\MessagesConstants;
use App\Models\BaseResponse;

class BaseController extends Controller
{

    public $service;

    public $response;

    /**
     * @param $service
     */
    public function __construct($service)
    {
        $this->service = $service;
        $this->response = new BaseResponse();
    }

    public function index()
    {
        try {
            $this->response->setMessage(MessagesConstants::SUCCESS);
            $this->response->setData($this->service->getAllData());
            $this->response->setCode(200);
        } catch (\Exception $e) {
            $this->response->setMessage(MessagesConstants::ERROR);
            $this->response->setData($e->getMessage());
            $this->response->setCode(500);
        }

        return response()->json([
            'data' => $this->response->getData(),
            'message' => $this->response->getMessage()
        ], $this->response->getCode());
    }

    public function store()
    {

    }
    public function update()
    {

    }
    public function destroy()
    {

    }

}
