<?php

namespace Thedevsaddam\LumenRouteList\Console\Commands;

use Illuminate\Console\Command;


class RouteListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'route:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display all the registered routes in list like laravel';

    /*
     * Routes list
     */
    protected $routes = [];

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->displayRoutes();
        return;
    }


    public function displayRoutes()
    {
        $headers = ['Method', 'URI', 'Name', 'Action', 'Middleware', 'Map To'];
        $this->generateRoutes();
        if (!$this->routes) {
            $this->warn('You don\'t have any routes!');
            return false;
        }
        $this->table($headers, $this->routes);
    }

    /**
     * Generate the formatted routes array
     * @return bool
     */
    public function generateRoutes()
    {
        foreach (app()->getRoutes() as $route) {
            array_push($this->routes, [
                $route['method'],
                $route['uri'],
                $this->getRouteName($route),
                $this->getRouteAction($route),
                $this->getRouteMiddleware($route),
                $this->getRouteMapTo($route)
            ]);
        }
    }

    /**
     * Get the route name
     * @param $route
     * @return null
     */
    private function getRouteName($route)
    {
        return (isset($route['action']['as'])) ? $route['action']['as'] : '';
    }

    /**
     * Get the route action type
     * @param $route
     * @return string
     */
    private function getRouteAction($route)
    {
        return ($this->isClosureRoute($route)) ? 'Closure' : 'Controller';
    }

    /**
     *  Get where the route map to
     * @param $route
     * @return string
     */
    private function getRouteMapTo($route)
    {
        return (!$this->isClosureRoute($route)) ? $route['action']['uses'] : '';
    }

    /**
     * Get route middleware
     * @param $route
     * @return string
     */
    private function getRouteMiddleware($route)
    {
        if (isset($route['action']['middleware'])) {
            return join(',', $route['action']['middleware']);
        }
        return '';
    }

    /**
     *  Check if the route is closure or controller route
     * @param $route
     * @return bool
     */
    private function isClosureRoute($route)
    {
        return !isset($route['action']['uses']);
    }

}