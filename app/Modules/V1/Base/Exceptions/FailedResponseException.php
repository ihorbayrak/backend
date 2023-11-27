<?php

namespace App\Modules\V1\Base\Exceptions;

use Exception;
use Illuminate\Contracts\Support\Responsable;

class FailedResponseException extends Exception implements Responsable
{
    public function __construct(protected ?array $errors = null)
    {
        parent::__construct();
    }

    public function toResponse($request)
    {
        $response = [
            'success' => false,
            'status' => $this->code,
            'message' => $this->message
        ];

        if (!empty($this->errors)) {
            $response = array_merge($response, $this->errors);
        }

        return response()->json($response, $this->code);
    }
}
