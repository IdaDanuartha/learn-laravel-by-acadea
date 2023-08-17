<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class GeneralJsonException extends Exception
{
    protected $code = 422;

    public function report(): void
    {
        // dump("123456");
    }

    public function render(): JsonResponse
    {
        return new JsonResponse([
            "errors" => [
                "message" => $this->message,
                "code" => $this->code 
            ]
        ], $this->code);
    }
}
