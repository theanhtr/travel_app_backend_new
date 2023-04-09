<?php 

namespace App\Traits;

trait HttpResponse {
    public function success($message = "", $data = "", $statusCode = 200) {
        return response() -> json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    public function failure($message = "", $data = "", $statusCode = 400) {
        return response() -> json([
            'success' => false,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }
}