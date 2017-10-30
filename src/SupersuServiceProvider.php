<?php

namespace Rakshitbharat\Supersu;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class SupersuServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Router $router) {
        $router->aliasMiddleware('supersu', \Rakshitbharat\Supersu\Middleware\SupersuMiddleware::class);

        $this->publishes([
            __DIR__ . '/Config/supersu.php' => config_path('supersu.php'),
                ], 'supersu_config');

        $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');

        $this->loadMigrationsFrom(__DIR__ . '/Migrations');

        $this->loadTranslationsFrom(__DIR__ . '/Translations', 'supersu');

        $this->publishes([
            __DIR__ . '/Translations' => resource_path('lang/vendor/supersu'),
        ]);

        $this->loadViewsFrom(__DIR__ . '/Views', 'supersu');
// Add an inline view composer for the user-selector
        View::composer('supersu::user-selector', function ($view) {
            $supersu = App::make(SuperSu::class);

            $view->with([
                'users' => $supersu->getUsers(),
                'hasSupered' => $supersu->hasSupered(),
                'originalUser' => $supersu->getOriginalUser(),
                'currentUser' => Auth::user()
            ]);
        });
        
        $this->publishes([
            __DIR__ . '/Views' => resource_path('views/vendor/supersu'),
        ]);

        $this->publishes([
            __DIR__ . '/Assets' => public_path('vendor/supersu'),
                ], 'supersu_assets');

        if ($this->app->runningInConsole()) {
            $this->commands([
                \Rakshitbharat\Supersu\Commands\SupersuCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        $this->mergeConfigFrom(
                __DIR__ . '/Config/supersu.php', 'supersu'
        );
    }

}
