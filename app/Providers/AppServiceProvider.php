<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(\App\Services\PostRegistrar::class);
        $this->app->bind(\App\Services\UpdateRegistrar::class);
        $this->app->bind(\App\Contracts\PostContract::class, \App\Models\Post::class);
        $this->app->bind(\App\Contracts\UpdateContract::class, \App\Models\Update::class);
        $this->app->bind(\App\Contracts\FeedUserContract::class, \App\Models\FeedUser::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
