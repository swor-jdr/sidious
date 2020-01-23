<?php
namespace Modules\Transition;

use Illuminate\Support\ServiceProvider;

class TransitionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__."/../views", "module::transition");
        $this->loadMigrationsFrom(__DIR__."/../database/migrations");
    }
}
