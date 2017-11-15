<?php
/**
 * SignalServiceProvider.php
 * Created by @anonymoussc on 6/5/2017 6:30 AM.
 */

namespace App\Components\Signal\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class SignalServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerMigration();

        // $this->loadMigrationsFrom(__DIR__ . '/../../Database/Migrations');

        $dispatcher = $this->app->make('events');
        $dispatcher->subscribe('App\Components\Signal\Listeners\SignalEventSubcriber');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register('Jenssegers\Agent\AgentServiceProvider');

        // Load the Facade aliases
        $loader = AliasLoader::getInstance();
        $loader->alias('Agent', \Jenssegers\Agent\Facades\Agent::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__ . '/../../Config/config.php' => config_path('signal.php'),
        ], 'config-signal');
        $this->mergeConfigFrom(
            __DIR__ . '/../../Config/config.php', 'signal'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/components/signal');

        $sourcePath = __DIR__ . '/../../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath,
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/components/signal';
        }, \Config::get('view.paths')), [$sourcePath]), 'signal');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/components/signal');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'signal');
        } else {
            $this->loadTranslationsFrom(__DIR__ . '/../../Resources/lang', 'signal');
        }
    }

    /**
     * Register migrations.
     *
     * @return void
     */
    public function registerMigration(){
        $this->publishes([
            __DIR__.'/../../Database/Migrations/' => database_path('migrations')
        ], 'migrations-signal');
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
