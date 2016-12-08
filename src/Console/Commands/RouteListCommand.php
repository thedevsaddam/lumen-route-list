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
            $this->warn('No routes found!');
            return false;
        }
        //change the reverse order if command contains reverse command
        if ($this->option('reverse')) {
            rsort($this->routes);
        }
        $this->info("Route found: " . count($this->routes));
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
        $input = $this->option('filter');
        if (!str_contains($input, ':')) {
            return false;
        }
        $input = explode(':', $input);
        $routes = $this->routes;
        $this->routes = [];
        if (in_array($input[0], $availableOptions) && null != $input[1]) {
            foreach ($routes as $index => $route) {
                if (str_contains(strtolower($route[$input[0]]), strtolower($input[1])))
                    $this->routes[] = $route;
            }
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

    /**
     * Get console input options
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['filter', 'f', InputOption::VALUE_OPTIONAL, 'filter'],
            ['reverse', 'me', InputOption::VALUE_NONE, 'Method'],
        ];
    }
}