<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Markdown;

class MarkdownServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Markdown::class, function ($app) {
            return Markdown::instance();
        });
    }
}