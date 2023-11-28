<?php

namespace App\Modules\V1\Base\Exceptions;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Response;

class ValidationException extends Exception implements Responsable
{
    public function __construct(protected array $errors)
    {
        parent::__construct();
    }

    public function toResponse($request)
    {
        return response()->json([
            'success' => false,
            'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
            'message' => 'Validation failed',
            'errors' => $this->errors
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
