<?php

namespace App\Providers;

use Laravel\Nova\Nova;
use Laravel\Nova\Cards\Help;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\NovaApplicationServiceProvider;
use NovaCards\SystemInformationCard\SystemInformationCard;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                "nicolas.sey@gmail.com",
                "alexis59ber@gmail.com",
                "gauvain.boiche@wanadoo.fr",
                "camille.sautot@gmail.com",
                "vador@sith.gal",
            ]);
        });
    }

    /**
     * Get the cards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
            new Help,
            new SystemInformationCard(),
            new \Vink\NovaCacheCard\CacheCard(),
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            new \Inani\LaravelNovaConfiguration\LaravelNovaConfiguration(),
            new \Christophrumpel\NovaNotifications\NovaNotifications(),
            new \Yadahan\BouncerTool\BouncerTool(),
            new \Beyondcode\TinkerTool\Tinker(),
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
