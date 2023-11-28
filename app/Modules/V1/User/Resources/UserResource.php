<?php

namespace App\Modules\V1\User\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name ?? $this->resource->user->name, // If resource = Profile than we get user's name through Profile,
            'email' => $this->resource->email ?? $this->resource->user->email, // If resource = Profile than we get email through Profile
        ];
    }
}
