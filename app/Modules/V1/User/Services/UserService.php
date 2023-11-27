<?php

namespace App\Modules\V1\User\Services;

use App\Modules\V1\User\DTO\ChangePassword;
use App\Modules\V1\User\DTO\UpdateUserFields;
use App\Modules\V1\User\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function update(UpdateUserFields $dto)
    {
        return $this->userRepository->update($dto);
    }

    public function changePassword(ChangePassword $dto)
    {
        $user = $this->userRepository->findById($dto->id);

        $user->update([
            'password' => Hash::make($dto->newPassword)
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
