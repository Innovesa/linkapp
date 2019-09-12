<?php

namespace LinkApp\Providers;

use Illuminate\Support\ServiceProvider;

class TraerMenusServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        require_once app_path() . '/Helpers/TraerMenus.php'; // La ruta del helper que creamos
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
