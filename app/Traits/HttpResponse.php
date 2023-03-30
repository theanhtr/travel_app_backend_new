<?php 

namespace App\Traits;

trait HttpResponses {
    public function success($data, $message = null, $code = 200) {
        return response() -> json([
            'status' => 'Request was successful.',
            'message' => $message,
            'data' => $data
        ], $code);
    }
    public function error($data, $message = null, $code = 404) {
        return response() -> json([
            'status' => 'Error has occured...',
            'message' => $message,
            'data' => $data
        ], $code);
    }
}