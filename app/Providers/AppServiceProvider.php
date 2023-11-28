<?php

namespace App\Providers;

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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
