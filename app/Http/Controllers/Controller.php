<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public int $perPage = 15;

    public function error($message = "Data is invalid", $code = 400)
    {
        return $this->apiResponse(true, $message, null, null, $code);
    }

    public function success($message = "Success", $data = null)
    {
        return $this->apiResponse(false, $message, $data, null);
    }

    public function successWithData($data)
    {
        if ($data instanceof AnonymousResourceCollection) {
            return $data->additional([
                'error' => false,
                'message' => 'Success',
            ]);
        }

        return $this->apiResponse(false, 'Success', $data, null, 200);
    }

    public function apiResponse($error = false, $message = "", $data = null, $errors = null, $code = 200)
    {
        $response = [];

        $response['error'] = $error;
        $response['message'] = $message;
        $response['data'] = $data;

        $response['errors'] = $errors;

        return response()->json($response, $code);
    }
}
