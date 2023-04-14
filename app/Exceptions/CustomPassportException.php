<?php

namespace App\Exceptions;

use Exception;
use League\OAuth2\Server\Exception\OAuthServerException;
use Illuminate\Http\JsonResponse;

class CustomPassportException extends Exception
{
    public function render($request)
    {
        if ($this instanceof OAuthServerException) {
            return response()->json([
                'error' => [
                    'code' => $this->getCode(),
                    'message' => $this->getMessage(),
                    'hint' => $this->getHint(),
                ]
            ], $this->httpStatusCode);
        }

        return parent::render($request);
    }
}
