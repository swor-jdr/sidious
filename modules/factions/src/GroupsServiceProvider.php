<?php
namespace Modules\Factions;

use App\Traits\UsesProviderHelpers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class GroupsServiceProvider extends ServiceProvider
{
    use UsesProviderHelpers;

    protected $namespace = "Modules\Factions\Http\Controllers";

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->mapApiRoutes();
        $this->mergeConfigFrom(__DIR__."/../config.php", "groups");
    }

    public function register()
    {
        $this->registerEloquentFactoriesFrom(__DIR__."/../database/factories");
    }

    private function mapApiRoutes()
    {
        Route::namespace($this->namespace)
            ->middleware("api")
            ->prefix('api')
            ->group(function () {
                require __DIR__.'/Http/api.php';
            });
    }
}
