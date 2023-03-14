<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\RouteNotFoundException;

class Router
{
    /**
     * @param array $routes
     * the routes and their actions
     */
    private array $routes;

    /**
     * @param callable|array $action
     * @param string $route
     * @return self $this the current instance of the router
     * register a route and its action to the router
     */
    public function register(string $route, callable|array $action): self
    {
        $this->routes[$route] = $action;

        return $this;
    }


    /**
     * @return mixed the result of the action
     * @throws RouteNotFoundException
     * @param string $requestUri
     * resolve the route and return the result of the action
     */
    public function resolve(string $requestUri): mixed
    {
        $route = explode('?', $requestUri)[0];
        $action = $this->routes[$route] ?? null; // ?? null is the same as isset($this->routes[$route]) ? $this->routes[$route] : null;

        if (!$action) {
            throw new  RouteNotFoundException();
        }
        //check if the action is callable
        if (is_callable($action)) {
            return call_user_func($action);
        }

        //check if the action is an array
        if (is_array($action)) {
            //destructuring the array
            [$controller, $method] = $action;
            //check if controller exists
            if (class_exists($controller)){
                $controller = new $controller();
                //check if method exists
                if (method_exists($controller, $method)) {
                    return call_user_func([$controller, $method]);
                }
            }
        }
        throw new RouteNotFoundException();


    }
}