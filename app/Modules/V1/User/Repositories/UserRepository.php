<?php

namespace App\Modules\V1\User\Repositories;

use App\Models\User;
use App\Modules\V1\User\DTO\UpdateUserFields;
use App\Modules\V1\User\Exceptions\DeactivatingFailedException;
use App\Modules\V1\User\Exceptions\RestoringFailedException;
use App\Modules\V1\User\Exceptions\UserNotFoundException;
use App\Modules\V1\Auth\DTO\RegisterCredentials;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

    public function findDeleted($userId)
    {
        $user = User::withTrashed()->find($userId);

        if (!$user) {
            throw new UserNotFoundException();
        }

        return $user;
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

    public function create(RegisterCredentials $data)
    {
        return User::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => $data->password
        ]);
    }

    public function deactivate($userId)
    {
        $user = $this->findById($userId);

        try {
            DB::beginTransaction();

            $user->delete();
            $user->profile->delete();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            throw new DeactivatingFailedException();
        }
    }

    public function restore($userId)
    {
        $user = $this->findDeleted($userId);

        try {
            DB::beginTransaction();

            $user->restore();
            $user->profile()->withTrashed()->restore();

            DB::commit();

            return $user;
        } catch (\Throwable $e) {
            DB::rollBack();

            throw new RestoringFailedException();
        }
    }

    public function deleteExpiredAccount()
    {
        User::withTrashed()
            ->whereNotNull('deleted_at')
            ->get()
            ->each(function (User $user) {
                if (Carbon::now()->diffInDays($user->deleted_at) >= config('auth.days_to_activate_account')) {
                    $user->forceDelete();
                };
            });
    }
}
