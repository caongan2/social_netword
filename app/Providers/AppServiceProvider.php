<?php

namespace App\Providers;

use App\Http\Repositories\Impl\PostRepositoryImpl;
use App\Http\Repositories\Impl\UserRepositoryImpl;
use App\Http\Repositories\PostRepository;
use App\Http\Repositories\UserRepository;

use App\Http\Services\Impl\UserServiceImpl;
use App\Http\Services\UserService;

use App\Http\Services\Impl\PostServiceImpl;
use App\Http\Services\PostService;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton(
            UserRepository::class,
            UserRepositoryImpl::class,
        );

        $this->app->singleton(
            PostRepository::class,
            PostRepositoryImpl::class
        );

        $this->app->singleton(
            PostService::class,
            PostServiceImpl::class
        );

        $this->app->singleton(
            UserService::class,
            UserServiceImpl::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
