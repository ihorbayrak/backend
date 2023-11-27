<?php

namespace App\Modules\V1\User\Repositories;

use App\Models\User;
use App\Modules\V1\User\DTO\UpdateUserFields;
use App\Modules\V1\User\Exceptions\UserNotFoundException;

class UserRepository implements UserRepositoryInterface
{
    public function findById($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    public function findByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public function findByEmailToken($emailToken)
    {
        return User::where('email_token', $emailToken)->first();
    }

    public function update(UpdateUserFields $data)
    {
        $user = $this->findById($data->id);

        $user->update([
            'name' => $data->name ?? $user->name,
            'email' => $data->email ?? $user->email
        ]);

        return $user;
    }

    public function deactivate($userId)
    {
        $user = $this->findById($userId);

        return $user->delete();
    }

    public function restore($userId)
    {
        $user = $this->findById($userId);

        return $user->restore();
    }
}
