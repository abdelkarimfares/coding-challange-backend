<?php

namespace App\Providers;

use App\Repositories\Api\GroupRepositoryInterface;
use App\Repositories\Api\UserRepositoryInterface;
use App\Repositories\GroupRepository;
use App\Repositories\UserRepository;
use App\Services\Api\GroupServiceInterface;
use App\Services\Api\UserServiceInterface;
use App\Services\GroupService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        $this->app->bind(GroupServiceInterface::class, GroupService::class);
        $this->app->bind(GroupRepositoryInterface::class, GroupRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
