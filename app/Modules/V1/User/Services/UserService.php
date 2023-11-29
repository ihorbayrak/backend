<?php

namespace App\Modules\V1\User\Services;

use App\Modules\V1\Auth\Exceptions\WrongPasswordException;
use App\Modules\V1\Auth\Services\HashService;
use App\Modules\V1\Auth\Services\RestorationService;
use App\Modules\V1\User\DTO\ChangePassword;
use App\Modules\V1\User\DTO\UpdateUserFields;
use App\Modules\V1\User\Exceptions\RestoreNotAllowedException;
use App\Modules\V1\User\Exceptions\WrongRestorationCode;
use App\Modules\V1\User\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class UserService
{
    private const RESTORATION_KEY = 'restoration_code';
    private const RESTORATION_CODE_TTL = 600; // 10 min

    public function __construct(
        private UserRepositoryInterface $userRepository,
        private HashService $hashService,
        private RestorationService $restorationService
    ) {
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

    public function restoreRequest($userId)
    {
        $user = $this->userRepository->findDeleted($userId);

        $this->isRestorationAllowed($user);

        $code = $this->restorationService->sendCode($user);

        return $this->restorationService->store($this->restorationKey($user->id), $code, static::RESTORATION_CODE_TTL);
    }

    public function restore($userId, $providedCode)
    {
        $user = $this->userRepository->findDeleted($userId);

        $this->isRestorationAllowed($user);

        $userCode = $this->restorationService->get($this->restorationKey($user->id));

        if ($this->restorationService->match($userCode, $providedCode)) {
            $this->restorationService->delete($this->restorationKey($user->id));

            return $this->userRepository->restore($userId);
        }

        throw new WrongRestorationCode();
    }

    public function currentUser()
    {
        return Auth::user();
    }

    public function currentUserId()
    {
        return Auth::id();
    }

    private function restorationKey($userId)
    {
        return $userId.'|'.static::RESTORATION_KEY;
    }

    private function isRestorationAllowed($user)
    {
        if ($user->deleted_at === null) {
            throw new RestoreNotAllowedException();
        }
    }
}
