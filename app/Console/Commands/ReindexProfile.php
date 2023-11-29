<?php

namespace App\Console\Commands;

use App\Models\Profile;
use App\Modules\V1\Search\Repositories\Profiles\ProfileSearchRepositoryInterface;
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

    public function __construct(private ProfileSearchRepositoryInterface $profileSearchRepository)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Indexing all profiles. This might take a while...');

        if ($this->profileSearchRepository->checkIndexExists()) {
            $this->profileSearchRepository->deleteIndex();
        }

        $this->profileSearchRepository->createIndex();

        $this->profileSearchRepository->putMappings(config('elasticsearch.parameters.profiles.mappings'));

        foreach (Profile::cursor() as $profile) {
            $this->profileSearchRepository->saveIndex($profile->toSearchArray());

            $this->output->write('.');
        }

        $this->info('Done!');
    }
}
