<?php
namespace Modules\Holonews;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class BlogServiceProvider extends ServiceProvider
{
    private $namespace = "Modules\Holonews\Controllers";

    public function register()
    {

    }

    public function boot()
    {
        $this->mapApiRoutes();
    }

    /**
     * Add api routes in provider using standard 'api' middleware
     *
     * @return void
     */
    private function mapApiRoutes()
    {
        Route::namespace($this->namespace)
            ->middleware("api")
            ->prefix("api")
            ->group(function () {
                require __DIR__. '/../routes.php';
            });
    }
}
