<?php

namespace Thedevsaddam\LumenRouteList;

use Illuminate\Support\ServiceProvider;
use Thedevsaddam\LumenRouteList\Console\Commands\RouteListCommand;

class LumenRouteListServiceProvider extends ServiceProvider
{
    protected $commands = [
        RouteListCommand::class,
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //register the commands
        $this->commands($this->commands);
    }
}
