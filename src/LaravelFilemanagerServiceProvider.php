<?php namespace Powerplanetonline\PpoFilemanager;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;


/**
 * Class LaravelFilemanagerServiceProvider
 * @package Powerplanetonline\PpoFilemanager
 */
class LaravelFilemanagerServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (Config::get('lfm.use_package_routes'))
            include __DIR__ . '/routes.php';

        $this->loadTranslationsFrom(__DIR__.'/lang', 'ppo-filemanager');

        $this->loadViewsFrom(__DIR__.'/views', 'ppo-filemanager');

        $this->publishes([
            __DIR__ . '/config/lfm.php' => base_path('config/lfm.php'),
        ], 'lfm_config');

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/ppo-filemanager'),
        ], 'lfm_public');

        $this->publishes([
            __DIR__.'/views'  => base_path('resources/views/vendor/ppo-filemanager'),
        ], 'lfm_view');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app['ppo-filemanager'] = $this->app->share(function ()
        {
            return true;
        });
    }

}
