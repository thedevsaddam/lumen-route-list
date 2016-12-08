<?php

namespace Thedevsaddam\LumenRouteList\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;


class RouteListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'route:list';

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

    /**
     * Display the routes in console
     * @return bool
     */
    public function displayRoutes()
    {
        $headers = ['Method', 'URI', 'Name', 'Action', 'Middleware', 'Map To'];
        $this->generateRoutes();
        $this->applyFilters();
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
                'method' => $route['method'],
                'uri' => $route['uri'],
                'name' => $this->getRouteName($route),
                'action' => $this->getRouteAction($route),
                'middleware' => $this->getRouteMiddleware($route),
                'map' => $this->getRouteMapTo($route)
            ]);
        }
    }

    /**
     * Apply filters on routes if user provide
     */
    private function applyFilters()
    {
        $availableOptions = ['name', 'method', 'uri', 'action', 'middleware'];
        $routes = $this->routes;
        foreach ($this->options() as $key => $option) {
            if (in_array($key, $availableOptions) && null != $option) {
                foreach ($routes as $index => $route) {
                    if (strtolower($route[$key]) == strtolower($option)) {
                        array_push($routes, $routes[$index]);
                    }
                }
            }
        }
        $this->routes = $routes;
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

    /**
     * Get console input options
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['method', 'me', InputOption::VALUE_OPTIONAL, 'Method'],
            ['uri', 'ur', InputOption::VALUE_OPTIONAL, 'Uri'],
            ['name', 'na', InputOption::VALUE_OPTIONAL, 'Name'],
            ['action', 'ac', InputOption::VALUE_OPTIONAL, 'Action'],
            ['middleware', 'mw', InputOption::VALUE_OPTIONAL, 'Middleware'],
            ['map', 'mp', InputOption::VALUE_OPTIONAL, 'Map to']
        ];
    }
}