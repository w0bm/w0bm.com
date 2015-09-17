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
        /** @var \Illuminate\View\Compilers\BladeCompiler $compiler  */
        Blade::directive('simplemd', function($text) {

            return "<?php echo App\\Models\\Comment::simplemd(e({$text})): ?>";
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
