<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Modules\V1\User\DTO\ChangePassword;
use App\Modules\V1\User\DTO\UpdateUserFields;
use App\Modules\V1\User\Requests\ChangeUserPasswordRequest;
use App\Modules\V1\User\Requests\UpdateUserRequest;
use App\Modules\V1\User\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    public function update(UpdateUserRequest $request)
    {
        $dto = new UpdateUserFields(
            id: $request->user()->id,
            name: $request->get('name'),
            email: $request->get('email'),
        );

        $user = $this->userService->update($dto);

        return $user;
    }

    public function changePassword(ChangeUserPasswordRequest $request)
    {
        $dto = new ChangePassword(
            id: $request->user()->id,
            newPassword: $request->input('new_password'),
            oldPassword: $request->input('old_password')
        );

        $user = $this->userService->changePassword($dto);

        return response()->json([
            'user_id' => $user->id,
            'message' => 'Password was successfully changed'
        ]);
    }

    public function destroy(Request $request)
    {
        $this->userService->delete($request->user()->id);

        return response()->noContent();
    }

    public function restore($userId)
    {
        $user = $this->userService->restore($userId);

        return response()->json([
            'user_id' => $user->id,
            'message' => 'User was successfully restored'
        ]);
    }
}
