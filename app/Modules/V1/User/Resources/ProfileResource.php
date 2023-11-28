<?php

namespace App\Modules\V1\User\Resources;

use Illuminate\Http\Request;

class ProfileResource extends UserResource
{
    public function toArray(Request $request): array
    {
        return array_merge(parent::toArray($request), [
            'username' => $this->resource->username,
            'avatar' => $this->resource->avatar
        ]);
    }
}
