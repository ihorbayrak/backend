<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\V1\ResponseController;
use App\Modules\V1\Auth\DTO\LoginCredentials;
use App\Modules\V1\Auth\DTO\RegisterCredentials;
use App\Modules\V1\Auth\Requests\LoginUserRequest;
use App\Modules\V1\Auth\Requests\RegisterUserRequest;
use App\Modules\V1\Auth\Requests\VerificationTokenRequest;
use App\Modules\V1\Auth\Services\AuthService;
use App\Modules\V1\User\Resources\UserResource;

class AuthController extends ResponseController
{
    public function __construct(private AuthService $authService)
    {
    }

    public function register(RegisterUserRequest $request)
    {
        $dto = new RegisterCredentials(
            name: $request->get('name'),
            email: $request->get('email'),
            password: $request->get('password'),
            ip: $request->ip()
        );

        $authDto = $this->authService->register($dto);

        return $this->responseWithToken(new UserResource($authDto->user), $authDto->token);
    }

    public function login(LoginUserRequest $request)
    {
        $dto = new LoginCredentials(
            email: $request->get('email'),
            password: $request->get('password'),
            ip: $request->ip()
        );

        $authDto = $this->authService->login($dto);

        return $this->responseWithToken(new UserResource($authDto->user), $authDto->token);
    }

    public function verify(VerificationTokenRequest $request)
    {
        $this->authService->verify($request->get('token'));

        return $this->responseOk([
            'message' => 'Email was successfully verified'
        ]);
    }

    public function refresh()
    {
        $token = $this->authService->refresh();

        return $this->responseOk(
            ['token' => $token]
        );
    }

    public function logout()
    {
        $this->authService->logout();

        return response()->noContent();
    }
}
