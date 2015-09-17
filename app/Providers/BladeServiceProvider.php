<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Blade;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        /* @simplemd($var) */
        Blade::extend(function($view, $compiler) {
            $pattern = $compiler->createOpenMatcher('simplemd');

            return preg_replace($pattern, '$1<?php echo App\Models\Comment::simplemd(e($2)): ?>', $view);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
