<?php

namespace App\Modules\V1\Comment\Resources;

use App\Modules\V1\Image\Services\ImageService;
use App\Modules\V1\User\Resources\ProfileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'repliesCount' => $this->resource->replies()->count(),
            'likesCount' => $this->resource->profilesLiked()->count(),
            'liked' => $user === null ? false : $this->resource->likedBy($user->id),
            'profile' => new ProfileResource($this->resource->profile),
            'replies' => $this->whenLoaded('replies', function () {
                return CommentResource::collection($this->resource->replies->load('replies'));
            })
        ];
    }
}
