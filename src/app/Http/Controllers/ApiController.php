<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response  as FacadeResponse;

class ApiController extends Controller
{
    protected $statusCode = 200;


    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function respondCreated($message)
    {
        return $this->setStatusCode(FacadeResponse::HTTP_CREATED)->respondWithError($message);
    }

    public function respondNotFound($message = 'Not Found!')
    {
        return $this->setStatusCode(FacadeResponse::HTTP_NOT_FOUND)->respondWithError($message);
    }

    public function respondInternalError($message = 'Internal Error!')
    {
        return $this->setStatusCode(FacadeResponse::HTTP_INTERNAL_SERVER_ERROR)->respondWithError($message);
    }

    public function respondUnauthorizedError($message = 'Unauthorized!')
    {
        return $this->setStatusCode(FacadeResponse::HTTP_UNAUTHORIZED)->respondWithError($message);
    }

    public function customPagination($data)
    {
        // 
    }

    public function respond($data, $headers = [])
    {
        return \Response::json($data, $this->getStatusCode(), $headers);
    }

    public function respondWithError($message)
    {
        return $this->respond([
            'error' => [
                'message' => $message,
                'status_code' => $this->getStatusCode(),
            ],
        ]);
    }
}
