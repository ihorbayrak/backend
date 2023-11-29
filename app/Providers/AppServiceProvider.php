<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\Profile;
use App\Modules\V1\Comment\Repositories\CommentRepository;
use App\Modules\V1\Comment\Repositories\CommentRepositoryInterface;
use App\Modules\V1\Image\Handlers\ImageHandlerInterface;
use App\Modules\V1\Image\Handlers\InterventionImageHandler;
use App\Modules\V1\Post\Repositories\PostRepository;
use App\Modules\V1\Post\Repositories\PostRepositoryInterface;
use App\Modules\V1\Search\Repositories\Posts\PostElasticsearchRepository;
use App\Modules\V1\Search\Repositories\Posts\PostSearchRepositoryInterface;
use App\Modules\V1\Search\Repositories\Profiles\ProfileElasticsearchRepository;
use App\Modules\V1\Search\Repositories\Profiles\ProfileSearchRepositoryInterface;
use App\Modules\V1\User\Repositories\ProfileRepository;
use App\Modules\V1\User\Repositories\ProfileRepositoryInterface;
use App\Modules\V1\User\Repositories\UserRepository;
use App\Modules\V1\User\Repositories\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ProfileRepositoryInterface::class, ProfileRepository::class);
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);

        $this->app->bind(ImageHandlerInterface::class, InterventionImageHandler::class);

        $this->app->bind(ProfileSearchRepositoryInterface::class, function () {
            return new ProfileElasticsearchRepository(new Profile());
        });

        $this->app->bind(PostSearchRepositoryInterface::class, function () {
            return new PostElasticsearchRepository(new Post());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
