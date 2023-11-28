<?php

namespace App\Modules\V1\User\Resources;

use Illuminate\Http\Request;

class ProfileInfoResource extends ProfileResource
{
    public function toArray(Request $request): array
    {
        $user = $request->user();

        return array_merge(parent::toArray($request), [
            'bio' => $this->resource->bio,
            'isFollowing' => $this->when(
                $user !== null && $user->profile->id !== $this->resource->id,
                fn() => $user->profile->isFollowing($this->resource->id)
            ),
            'followers' => $this->resource->followers()->count(),
            'following' => $this->resource->follows()->count()
        ]);
    }
}
