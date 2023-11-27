<?php

namespace App\Modules\V1\User\Repositories;

use App\Modules\V1\User\DTO\UpdateUserFields;

interface UserRepositoryInterface
{
    public function findById($userId);

    public function findByEmail($email);

    public function findByEmailToken($emailToken);

    public function update(UpdateUserFields $data);

    public function deactivate($userId);

    public function restore($userId);
}
