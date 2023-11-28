<?php

namespace App\Modules\V1\Post\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PostsCollection extends ResourceCollection
{
    public $collects = PostResource::class;

    public function toArray(Request $request): array
    {
        $paginator = $this->resource->toArray();

        return [
            'meta' => [
                'page' => $paginator['current_page'],
                'totalPages' => $paginator['last_page'],
                'totalPosts' => $paginator['total'],
                'count' => $paginator['per_page'],
                'links' => [
                    "next" => $paginator['next_page_url'],
                    "prev" => $paginator['prev_page_url']
                ]
            ],
            'posts' => $this->collection
        ];
    }
}
