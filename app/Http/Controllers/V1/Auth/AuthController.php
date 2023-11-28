<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\Controller;
use App\Modules\V1\Auth\DTO\LoginCredentials;
use App\Modules\V1\Auth\DTO\RegisterCredentials;
use App\Modules\V1\Auth\Requests\LoginUserRequest;
use App\Modules\V1\Auth\Requests\RegisterUserRequest;
use App\Modules\V1\Auth\Services\AuthService;
use App\Modules\V1\User\Resources\UserResource;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }

    public function register(RegisterUserRequest $request)
    {
        $dto = new RegisterCredentials(
            name: $request->get('name'),
            email: $request->get('email'),
            password: $request->get('password')
        );

        $authDto = $this->authService->register($dto);

        return response()->json([
            'user' => new UserResource($authDto->user),
            'token' => $authDto->token
        ]);
    }

    public function login(LoginUserRequest $request)
    {
        $dto = new LoginCredentials(
            email: $request->get('email'),
            password: $request->get('password')
        );

        $authDto = $this->authService->login($dto);

        return response()->json([
            'user' => new UserResource($authDto->user),
            'token' => $authDto->token
        ]);
    }

    public function refresh()
    {
        $token = $this->authService->refresh();

        return response()->json(['token' => $token]);
    }

    public function logout()
    {
        $this->authService->logout();

        return response()->noContent();
    }
}
