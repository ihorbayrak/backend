<?php

namespace App\Modules\V1\User\Services;

use App\Modules\V1\Auth\Exceptions\WrongPasswordException;
use App\Modules\V1\Auth\Services\HashService;
use App\Modules\V1\User\DTO\ChangePassword;
use App\Modules\V1\User\DTO\UpdateUserFields;
use App\Modules\V1\User\Repositories\UserRepositoryInterface;

class UserService
{
    public function __construct(private UserRepositoryInterface $userRepository, private HashService $hashService)
    {
    }

    public function update(UpdateUserFields $dto)
    {
        return $this->userRepository->update($dto);
    }

    public function changePassword(ChangePassword $dto)
    {
        $user = $this->userRepository->findById($dto->id);

        if ($this->hashService->isNotEquals($dto->oldPassword, $user->password)) {
            throw new WrongPasswordException();
        }

        $user->update([
            'password' => $this->hashService->makeHash($dto->newPassword)
        ]);

        return $user;
    }

    public function delete($userId)
    {
        return $this->userRepository->deactivate($userId);
    }


    public function restore($userId)
    {
        return $this->userRepository->restore($userId);
    }
}
