<?php

namespace App\Providers;

use App\Services\Tag\TagService;
use App\Services\Task\TaskService;
use App\Services\User\TokenAuthService;
use App\Services\User\UserTag;
use App\Services\User\UserTask;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(TokenAuthService::class, function ($app) {
            return new TokenAuthService();
        });
        $this->app->singleton(TaskService::class, function ($app) {
            return new TaskService();
        });
        $this->app->singleton(UserTask::class, function ($app) {
            return new UserTask();
        });
        $this->app->singleton(TagService::class, function ($app) {
            return new TagService();
        });
        $this->app->singleton(UserTag::class, function ($app) {
            return new UserTag();
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
