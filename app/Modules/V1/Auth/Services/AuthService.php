<?php

namespace App\Modules\V1\Auth\Services;

use App\Modules\V1\Auth\DTO\AuthUser;
use App\Modules\V1\Auth\DTO\LoginCredentials;
use App\Modules\V1\Auth\DTO\RegisterCredentials;
use App\Modules\V1\Auth\Exceptions\UserAlreadyExistsException;
use App\Modules\V1\Auth\Exceptions\WrongEmailException;
use App\Modules\V1\Auth\Exceptions\WrongPasswordException;
use App\Modules\V1\User\Jobs\ProcessLocationJob;
use App\Modules\V1\User\Repositories\UserRepositoryInterface;
use App\Modules\V1\User\Services\ProfileService;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private HashService $hashService,
        private VerificationService $verificationService,
        private ProfileService $profileService
    ) {
    }

    public function register(RegisterCredentials $dto)
    {
        $userExists = $this->userRepository->findByEmail($dto->email);

        if ($userExists) {
            throw new UserAlreadyExistsException();
        }

        $user = $this->userRepository->create(
            new RegisterCredentials(
                name: $dto->name,
                email: $dto->email,
                password: $this->hashService->makeHash($dto->password)
            )
        );

        $this->verificationService->sendEmail($user);

        $token = Auth::login($user);

        $this->profileService->generateProfile($user);

        if ($dto->ip) {
            ProcessLocationJob::dispatch($user, $dto->ip);
        }

        return new AuthUser(user: $user, token: $token);
    }

    public function login(LoginCredentials $dto)
    {
        $user = $this->userRepository->findByEmail($dto->email);

        if (!$user) {
            throw new WrongEmailException();
        }

        if ($this->hashService->isNotEquals($dto->password, $user->password)) {
            throw new WrongPasswordException();
        }

        $token = Auth::attempt([
            'email' => $dto->email,
            'password' => $dto->password
        ]);

        if ($dto->ip) {
            ProcessLocationJob::dispatch($user, $dto->ip);
        }

        return new AuthUser(user: $user, token: $token);
    }

    public function verify(string $emailToken)
    {
        $user = $this->userRepository->findByEmailToken($emailToken);

        $this->verificationService->verifyUser($user);

        return $user;
    }

    public function logout()
    {
        return Auth::logout();
    }

    public function refresh()
    {
        return Auth::refresh();
    }
}
