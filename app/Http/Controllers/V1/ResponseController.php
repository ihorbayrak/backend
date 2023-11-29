<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class ResponseController extends Controller
{
    public function responseOk(array $data)
    {
        return response()->json([
            'success' => true,
            'status' => Response::HTTP_OK,
            ...$data
        ], Response::HTTP_OK);
    }

    public function responseCreated(array $data)
    {
        return response()->json([
            'success' => true,
            'status' => Response::HTTP_CREATED,
            ...$data
        ], Response::HTTP_CREATED);
    }

    public function responseWithToken($user, $token)
    {
        return response()->json([
            'success' => true,
            'status' => Response::HTTP_CREATED,
            'user' => $user,
            'token' => $token
        ], Response::HTTP_CREATED);
    }
}
