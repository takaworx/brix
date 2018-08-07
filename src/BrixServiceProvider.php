<?php

namespace Takaworx\Brix;

use Illuminate\Support\ServiceProvider;

class BrixServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRepositoryGenerator();
        $this->registerRequestGenerator();
    }

    /**
     * Register the make:repository command
     *
     * @return void
     */
    private function registerRepositoryGenerator()
    {
        $this->app->singleton('command.takaworx.brix.repository', function ($app) {
            return $app['Takaworx\Brix\Commands\RepositoryMakeCommand'];
        });

        $this->commands('command.takaworx.brix.repository');
    }

    /**
     * Register the make:brequest command
     *
     * @return void
     */
    private function registerRequestGenerator()
    {
        $this->app->singleton('command.takaworx.brix.request', function ($app) {
            return $app['Takaworx\Brix\Commands\RequestMakeCommand'];
        });

        $this->commands('command.takaworx.brix.request');
    }
}
