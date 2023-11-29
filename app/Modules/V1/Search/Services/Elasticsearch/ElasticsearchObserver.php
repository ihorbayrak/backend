<?php

namespace App\Modules\V1\Search\Services\Elasticsearch;

class ElasticsearchObserver
{
    public function created($model): void
    {
        (new ElasticsearchRepository($model))->saveIndex($model->toSearchArray());
    }

    public function updated($model): void
    {
        (new ElasticsearchRepository($model))->saveIndex($model->toSearchArray());
    }

    public function deleted($model): void
    {
        (new ElasticsearchRepository($model))->deleteIndex();
    }

    public function restored($model): void
    {
        (new ElasticsearchRepository($model))->saveIndex($model->toSearchArray());
    }

    public function forceDeleted($model): void
    {
        (new ElasticsearchRepository($model))->deleteIndex();
    }
}
