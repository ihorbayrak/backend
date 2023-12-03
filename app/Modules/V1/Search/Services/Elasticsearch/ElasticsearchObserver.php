<?php

namespace App\Modules\V1\Search\Services\Elasticsearch;

use App\Models\User;
use App\Modules\V1\Search\Repositories\SearchRepositoryInterface;

class ElasticsearchObserver
{
    public function __construct(private SearchRepositoryInterface $searchRepository)
    {
    }

    public function created($model): void
    {
        if (!($model instanceof User)) {
            $this->searchRepository->for($model::class)->saveIndex($model->toSearchArray());
        }
    }

    public function updated($model): void
    {
        if (!($model instanceof User)) {
            $this->searchRepository->for($model::class)->saveIndex($model->toSearchArray());
        }

        if (($model instanceof User) && $model->isDirty('name')) {
            $this->searchRepository->for($model::class)->saveIndex($model->toSearchArray());
        }
    }

    public function deleted($model): void
    {
        $this->searchRepository->for($model::class)->deleteIndex();
    }

    public function restored($model): void
    {
        $this->searchRepository->for($model::class)->saveIndex($model->toSearchArray());
    }

    public function forceDeleted($model): void
    {
        $this->searchRepository->for($model::class)->deleteIndex();
    }
}
