<?php namespace AuraIsHere\LaravelMultiTenant;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class LaravelMultiTenantServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // $this->package('aura-is-here/laravel-multi-tenant');
        $config = realpath(__DIR__.'/../../config/config.php');

        $this->publishes([
            $config => config_path('tenant.php'),
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Merge the package config values so they don't have to have a complete configuration
        $this->mergeConfigFrom(__DIR__.'/../../config/config.php', 'tenant');

    // Register our tenant scope instance
    $this->app->singleton('AuraIsHere\LaravelMultiTenant\TenantScope', function ($app) {
            return new TenantScope();
        });

        // Define alias 'TenantScope'
        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('TenantScope', 'AuraIsHere\LaravelMultiTenant\Facades\TenantScopeFacade');
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}