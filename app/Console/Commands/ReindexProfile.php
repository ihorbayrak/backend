<?php

namespace App\Console\Commands;

use App\Models\Profile;
use App\Modules\V1\Search\Repositories\SearchRepositoryInterface;
use Illuminate\Console\Command;

class ReindexProfile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elasticsearch:reindex-profile';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexes all profiles to Elasticsearch';

    public function __construct(private SearchRepositoryInterface $searchRepository)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Indexing all profiles. This might take a while...');

        $repository = $this->searchRepository->for(Profile::class);

        if ($repository->checkIndexExists()) {
            $repository->deleteIndex();
        }

        $repository->createIndex();

        $repository->putMappings(config('elasticsearch.parameters.profiles.mappings'));

        foreach (Profile::cursor() as $profile) {
            $repository->saveIndex($profile->toSearchArray());

            $this->output->write('.');
        }

        $this->info('Done!');
    }
}
