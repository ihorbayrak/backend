<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Modules\V1\Search\Repositories\Posts\PostSearchRepositoryInterface;
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

    public function __construct(private PostSearchRepositoryInterface $postSearchRepository)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Indexing all posts. This might take a while...');

        if ($this->postSearchRepository->checkIndexExists()) {
            $this->postSearchRepository->deleteIndex();
        }

        $this->postSearchRepository->createIndex();

        $this->postSearchRepository->putMappings(config('elasticsearch.parameters.posts.mappings'));

        foreach (Post::cursor() as $post) {
            $this->postSearchRepository->saveIndex($post->toSearchArray());

            $this->output->write('.');
        }

        $this->info('Done!');
    }
}
