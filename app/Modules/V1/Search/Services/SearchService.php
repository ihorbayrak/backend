<?php

namespace App\Modules\V1\Search\Services;

use App\Modules\V1\Post\Resources\PostResource;
use App\Modules\V1\Search\DTO\SearchFilters;
use App\Modules\V1\Search\DTO\SearchParams;
use App\Modules\V1\Search\Repositories\Posts\PostSearchRepositoryInterface;
use App\Modules\V1\Search\Repositories\Profiles\ProfileSearchRepositoryInterface;
use App\Modules\V1\User\Resources\ProfileResource;

class SearchService
{
    private const FILTER_ON = 'on';
    private const FILTER_LATEST = 'latest';
    private const FILTER_PROFILE = 'profile';

    public function __construct(
        private PostSearchRepositoryInterface $postSearchRepository,
        private ProfileSearchRepositoryInterface $profileSearchRepository
    ) {
    }

    public function search(SearchParams $dto)
    {
        $filters = new SearchFilters(
            latest: strtolower($dto->filter) === static::FILTER_LATEST,
            profile: strtolower($dto->filter) === static::FILTER_PROFILE,
            location: strtolower($dto->followsFilter) === static::FILTER_ON,
            followings: strtolower($dto->locationFilter) === static::FILTER_ON
        );

        if ($filters->latest) {
            return $this->searchPosts($dto->query, $filters);
        }

        if ($filters->profile) {
            return $this->searchProfiles($dto->query, $filters);
        }

        return $this->searchPosts($dto->query, $filters);
    }

    private function searchProfiles(string $query, SearchFilters $filters)
    {
        $profiles = $this->profileSearchRepository->search($query, $filters);

        return ProfileResource::collection($profiles);
    }

    private function searchPosts(string $query, SearchFilters $filters)
    {
        $posts = $this->postSearchRepository->search($query, $filters);

        return PostResource::collection($posts);
    }
}
