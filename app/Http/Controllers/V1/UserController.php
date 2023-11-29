<?php

namespace App\Http\Controllers\V1;

use App\Modules\V1\User\DTO\ChangePassword;
use App\Modules\V1\User\DTO\UpdateUserFields;
use App\Modules\V1\User\Requests\ChangeUserPasswordRequest;
use App\Modules\V1\User\Requests\RestoreRequest;
use App\Modules\V1\User\Requests\UpdateUserRequest;
use App\Modules\V1\User\Resources\UserResource;
use App\Modules\V1\User\Services\UserService;

class UserController extends ResponseController
{
    public function __construct(private UserService $userService)
    {
    }

    public function show()
    {
        return $this->responseOk(
            ['user' => new UserResource($this->userService->currentUser())]
        );
    }

    public function update(UpdateUserRequest $request)
    {
        $dto = new UpdateUserFields(
            id: $this->userService->currentUser()->id,
            name: $request->get('name'),
            email: $request->get('email'),
        );

        $user = $this->userService->update($dto);

        return $this->responseOk(
            ['user' => new UserResource($user)]
        );
    }

    public function changePassword(ChangeUserPasswordRequest $request)
    {
        $dto = new ChangePassword(
            id: $this->userService->currentUser()->id,
            newPassword: $request->input('new_password'),
            oldPassword: $request->input('old_password')
        );

        $user = $this->userService->changePassword($dto);

        return $this->responseOk([
            'user_id' => $user->id,
            'message' => 'Password was successfully changed'
        ]);
    }

    public function destroy()
    {
        $this->userService->delete($this->userService->currentUser()->id);

        return response()->noContent();
    }

    public function restoreRequest($userId)
    {
        $this->userService->restoreRequest($userId);

        return $this->responseCreated([
            'message' => 'Code was sent'
        ]);
    }

    public function restore(RestoreRequest $request, $userId)
    {
        $user = $this->userService->restore($userId, $request->get('code'));

        return $this->responseOk([
            'user_id' => $user->id,
            'message' => 'User was successfully restored'
        ]);
    }
}
