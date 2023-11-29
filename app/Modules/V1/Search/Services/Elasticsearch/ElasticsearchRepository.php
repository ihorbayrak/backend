<?php

namespace App\Modules\V1\Search\Services\Elasticsearch;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use InvalidArgumentException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class ElasticsearchRepository
{
    protected const MAX_RESULTS = 5000;
    protected Client $elasticsearch;

    public function __construct(protected Model $model)
    {
        $this->elasticsearch = ClientBuilder::create()
            ->setHosts(config('elasticsearch.client.hosts'))
            ->build();
    }

    protected function searchOnElasticsearch(array $data)
    {
        $items = $this->elasticsearch->search([
            'index' => $this->model->getSearchIndex(),
            'type' => $this->model->getSearchType(),
            'body' => [
                'size' => static::MAX_RESULTS,
                ...$data
            ],
        ]);

        return $this->buildResult($items->asArray());
    }

    public function createIndex(): void
    {
        $index = $this->model->getSearchIndex();

        $this->elasticsearch->indices()->create(['index' => $index]);

        $mappings = config('elasticsearch.parameters')[$index]['mappings'];

        if (isset($mappings)) {
            $this->putMappings($mappings);
        }
    }

    public function putMappings(array $mappings): void
    {
        if (!$this->checkIndexExists()) {
            $this->createIndex();
        }

        foreach ($mappings as $mapping) {
            if (!isset($mapping['field'])) {
                throw new InvalidArgumentException(
                    'The \'field\' field is required.'
                );
            }

            if (!isset($mapping['type'])) {
                throw new InvalidArgumentException(
                    'The \'type\' field is required.'
                );
            }
        }

        $properties = [];

        foreach ($mappings as $mapping) {
            $properties[$mapping['field']] = [
                'type' => $mapping['type'],
            ];

            if (isset($mapping['keyword']) && $mapping['keyword'] === true) {
                $properties[$mapping['field']] = [
                    'type' => $mapping['type'],
                    'fields' => [
                        'keyword' => [
                            'type' => 'keyword'
                        ]
                    ]
                ];
            }
        }

        $this->elasticsearch->indices()->putMapping([
            'index' => $this->model->getSearchIndex(),
            'body' => [
                'properties' => $properties,
            ],
        ]);
    }

    public function saveIndex(array $body): void
    {
        if (!$this->checkIndexExists()) {
            $this->createIndex();
        }

        $this->elasticsearch->index([
            'index' => $this->model->getSearchIndex(),
            'type' => $this->model->getSearchType(),
            'id' => $this->model->getKey(),
            'body' => $body
        ]);
    }

    public function checkIndexExists(): bool
    {
        if (
            $this->elasticsearch->indices()->exists(['index' => $this->model->getSearchIndex()])->getStatusCode(
            ) === 404
        ) {
            return false;
        }

        return true;
    }

    public function deleteIndex(): void
    {
        $this->elasticsearch->indices()->delete(['index' => $this->model->getSearchIndex()]);
    }

    protected function buildResult(array $items)
    {
        $ids = Arr::map($items['hits']['hits'], fn($item) => $item['_source']['id']);

        return $this->model::findMany($ids)->sortBy(fn($item) => array_search($item->id, $ids));
    }
}
