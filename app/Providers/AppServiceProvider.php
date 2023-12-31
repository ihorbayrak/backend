<?php

namespace App\Providers;

use App\Modules\V1\Comment\Repositories\CommentRepository;
use App\Modules\V1\Comment\Repositories\CommentRepositoryInterface;
use App\Modules\V1\Geolocation\Services\GeolocationServiceInterface;
use App\Modules\V1\Geolocation\Services\IpApiService;
use App\Modules\V1\Image\Handlers\ImageHandlerInterface;
use App\Modules\V1\Image\Handlers\InterventionImageHandler;
use App\Modules\V1\Post\Repositories\PostRepository;
use App\Modules\V1\Post\Repositories\PostRepositoryInterface;
use App\Modules\V1\Search\Repositories\Elasticsearch\ElasticsearchRepository;
use App\Modules\V1\Search\Repositories\SearchRepositoryInterface;
use App\Modules\V1\User\Repositories\ProfileRepository;
use App\Modules\V1\User\Repositories\ProfileRepositoryInterface;
use App\Modules\V1\User\Repositories\UserRepository;
use App\Modules\V1\User\Repositories\UserRepositoryInterface;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ImageHandlerInterface::class, InterventionImageHandler::class);
        $this->app->bind(GeolocationServiceInterface::class, IpApiService::class);

        $this->bindRepositories();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();
    }

    private function bindRepositories()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ProfileRepositoryInterface::class, ProfileRepository::class);
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);

        $this->app->bind(SearchRepositoryInterface::class, function () {
            $client = ClientBuilder::create()
                ->setHosts(config('elasticsearch.client.hosts'))
                ->build();

            return new ElasticsearchRepository($client);
        });
    }
}
