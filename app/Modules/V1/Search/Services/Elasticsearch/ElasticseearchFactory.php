<?php

namespace App\Modules\V1\Search\Services\Elasticsearch;

use App\Models\Post;
use App\Models\Profile;
use App\Modules\V1\Search\Repositories\Elasticsearch\PostElasticsearchRepository;
use App\Modules\V1\Search\Repositories\Elasticsearch\ProfileElasticsearchRepository;
use InvalidArgumentException;

class ElasticseearchFactory
{
    public static function make($model)
    {
        $bindings = [
            Profile::class => ProfileElasticsearchRepository::class,
            Post::class => PostElasticsearchRepository::class
        ];

        if (array_key_exists($model, $bindings)) {
            return resolve($bindings[$model]);
        }

        throw new InvalidArgumentException(sprintf('Given model %s is invalid', $model));
    }
}
