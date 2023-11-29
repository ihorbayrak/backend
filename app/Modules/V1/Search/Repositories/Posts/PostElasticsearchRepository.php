<?php

namespace App\Modules\V1\Search\Repositories\Posts;

use App\Models\Post;
use App\Models\Profile;
use App\Modules\V1\Search\DTO\SearchFilters;
use App\Modules\V1\Search\Services\Elasticsearch\ElasticsearchRepository;
use App\Modules\V1\User\Services\UserService;

class PostElasticsearchRepository extends ElasticsearchRepository implements PostSearchRepositoryInterface
{
    public function __construct(private Post $post)
    {
        parent::__construct($this->post);
    }

    public function search($query, SearchFilters $filters)
    {
        $result = [
            'query' => [
                'bool' => [
                    'must' => [
                        'match' => [
                            'body' => $query,
                        ],
                    ]
                ]
            ],
            'sort' => [
                'activity' => ['order' => 'desc']
            ]
        ];

        if ($filters->followings) {
            $this->filterbyFollows($result, $this->getCurrentProfile());
        }

        if ($filters->location) {
            $this->filterByLocation($result, $this->getCurrentProfile());
        }

        if ($filters->latest) {
            $this->sortByLatest($result);
        }

        return $this->searchOnElasticsearch($result);
    }

    private function filterbyFollows(array &$result, Profile $authProfile)
    {
        $result['query']['bool']['filter']['terms'] = [
            'profile_id' => $authProfile->follows->pluck('id')
        ];
    }

    private function filterByLocation(array &$result, Profile $authProfile)
    {
        $range = config('elasticsearch.parameters.search_range');
        $unit = config('elasticsearch.parameters.search_unit');

        $result['query']['bool']['filter']['geo_distance'] = [
            'distance' => $range.$unit,
            'location' => $authProfile->location
        ];
    }

    private function sortByLatest(&$result)
    {
        $result['sort'] = [
            'created_at' => ['order' => 'desc']
        ];
    }

    private function getCurrentProfile(UserService $userService) {
        return $userService->currentUser()->profile;
    }
}
