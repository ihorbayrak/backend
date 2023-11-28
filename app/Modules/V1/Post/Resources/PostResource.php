<?php

namespace App\Modules\V1\Post\Resources;

use App\Modules\V1\Image\Services\ImageService;
use App\Modules\V1\User\Resources\ProfileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $user = $request->user();

        return [
            'id' => $this->resource->id,
            'body' => $this->resource->body,
            'image' => ImageService::get($this->resource->image),
            'createdAt' => $this->resource->created_at,
            'updatedAt' => $this->resource->updated_at,
            'liked' => $user === null ? false : $this->resource->likedBy($user->id),
            'reposted' => $user === null ? false : $this->resource->repostedBy($user->id),
            'likesCount' => $this->resource->profilesLiked()->count(),
            'repostsCount' => $this->resource->profilesReposted()->count(),
            'commentsCount' => $this->resource->comments()->count(),
            'profile' => new ProfileResource($this->resource->profile),
            'profilesLiked' => ProfileResource::collection($this->whenLoaded('profilesLiked')),
            'profilesReposted' => ProfileResource::collection($this->whenLoaded('profilesReposted')),
        ];
    }
}
