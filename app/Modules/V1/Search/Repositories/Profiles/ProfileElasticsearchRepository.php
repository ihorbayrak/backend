<?php

namespace App\Modules\V1\Search\Repositories\Profiles;

use App\Models\Profile;
use App\Modules\V1\Search\DTO\SearchFilters;
use App\Modules\V1\Search\Services\Elasticsearch\ElasticsearchRepository;
use App\Modules\V1\User\Services\UserService;

class ProfileElasticsearchRepository extends ElasticsearchRepository implements ProfileSearchRepositoryInterface
{
    public function __construct(private Profile $profile)
    {
        parent::__construct($this->profile);
    }

    public function search($query, SearchFilters $filters)
    {
        $result = [
            'query' => [
                'bool' => [
                    'must' => [
                        'multi_match' => [
                            "query" => $query,
                            "fields" => ["username^3", "name^2", "bio"],
                            'fuzziness' => 'AUTO'
                        ]
                    ]
                ]
            ]
        ];

        if ($filters->followings) {
            $this->filterbyFollows($result, $this->getCurrentProfile());
        }

        if ($filters->location) {
            $this->filterByLocation($result, $this->getCurrentProfile());
        }

        return $this->searchOnElasticsearch($result);
    }

    private function filterbyFollows(array &$result, Profile $authProfile)
    {
        $result['query']['bool']['filter']['terms'] = [
            'id' => $authProfile->follows->pluck('id')
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

    private function getCurrentProfile(UserService $userService)
    {
        return $userService->currentUser()->profile;
    }
}
