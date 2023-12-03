<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Modules\V1\Search\Repositories\SearchRepositoryInterface;
use Illuminate\Console\Command;

class ReindexPost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elasticsearch:reindex-post';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexes all posts to Elasticsearch';

    public function __construct(private SearchRepositoryInterface $searchRepository)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Indexing all posts. This might take a while...');

        $repository = $this->searchRepository->for(Post::class);

        if ($repository->checkIndexExists()) {
            $repository->deleteIndex();
        }

        $repository->createIndex();

        $repository->putMappings(config('elasticsearch.parameters.posts.mappings'));

        foreach (Post::cursor() as $post) {
            $repository->saveIndex($post->toSearchArray());

            $this->output->write('.');
        }

        $this->info('Done!');
    }
}
