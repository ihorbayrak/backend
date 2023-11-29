<?php

namespace App\Http\Controllers\V1;

use App\Modules\V1\Search\DTO\SearchParams;
use App\Modules\V1\Search\Requests\SearchRequest;
use App\Modules\V1\Search\Services\SearchService;

class SearchController extends ResponseController
{
    public function __construct(private SearchService $searchService)
    {
    }

    public function __invoke(SearchRequest $request)
    {
        $data = $this->searchService->search(
            new SearchParams(
                query: $request->get('q'),
                filter: $request->get('f'),
                followsFilter: $request->get('pf'),
                locationFilter: $request->get('lf')
            )
        );

        return $this->responseOk([
            'data' => $data
        ]);
    }
}
