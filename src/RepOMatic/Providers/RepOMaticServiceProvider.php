<?php

namespace AlexTigaer\RepOMatic\Providers;

use Illuminate\Support\ServiceProvider;

class RepOMaticServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if($this->app->runningInConsole()){
            $this->commands([
                'AlexTigaer\RepOMatic\Commands\CreateRepo',
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
