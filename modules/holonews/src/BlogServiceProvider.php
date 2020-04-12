<?php
namespace Modules\Holonews;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\Holonews\Middleware\Authenticate;
use Modules\Holonews\Models\Author;

class BlogServiceProvider extends ServiceProvider
{
    private $namespace = "Modules\Holonews\Controllers";

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config.php', 'holonews'
        );
    }

    public function boot()
    {
        $this->mapApiRoutes();
        $this->registerRoutes();
        $this->registerAuthGuard();
        $this->registerPublishing();

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadViewsFrom(
            __DIR__.'/../resources/views', 'holonews'
        );

        $this->commands([
            Console\CreateAuthor::class,
        ]);
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    private function registerRoutes()
    {
        $path = config('holonews.path');
        $middlewareGroup = config('holonews.middleware_group');

        Route::namespace('Modules\Holonews\Controllers')
            ->middleware($middlewareGroup)
            ->as('holonews.')
            ->prefix($path)
            ->group(function () {
                Route::get('/login', 'LoginController@showLoginForm')->name('auth.login');
                Route::post('/login', 'LoginController@login')->name('auth.attempt');

                Route::get('/password/forgot', 'ForgotPasswordController@showResetRequestForm')->name('password.forgot');
                Route::post('/password/forgot', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
                Route::get('/password/reset/{token}', 'ForgotPasswordController@showNewPassword')->name('password.reset');
            });

        Route::namespace('Modules\Holonews\Controllers')
            ->middleware([$middlewareGroup, Authenticate::class])
            ->as('holonews.')
            ->prefix($path)
            ->group(function () {
                $this->loadRoutesFrom(__DIR__.'/../routes.php');
            });
    }

    /**
     * Register the package's authentication guard.
     *
     * @return void
     */
    private function registerAuthGuard()
    {
        $this->app['config']->set('auth.providers.holonews', [
            'driver' => 'eloquent',
            'model' => Author::class,
        ]);

        $this->app['config']->set('auth.guards.holonews', [
            'driver' => 'session',
            'provider' => 'holonews',
        ]);
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    private function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../public' => public_path('vendor/holonews'),
            ], 'holonews-assets');

            $this->publishes([
                __DIR__.'/../config.php' => config_path('holonews.php'),
            ], 'holonews-config');
        }
    }

    /**
     * Add api routes in provider using standard 'api' middleware
     *
     * @return void
     */
    private function mapApiRoutes()
    {
        Route::namespace($this->namespace . "\Api")
            ->middleware("api")
            ->prefix("api")
            ->group(function () {
                require __DIR__. '/../api.php';
            });
    }
}
