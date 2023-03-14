<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\RouteNotFoundException;

class Router
{
    /**
     * @var array $routes
     * the routes and their actions
     */
    private array $routes;

    /**
     * @return self $this the current instance of the router
     * register a route and its action to the router
     * @var string $route
     * @var callable $action
     */
    public function register(string $route, callable $action): self
    {
        $this->routes[$route] = $action;

        return $this;
    }


    /**
     * @return mixed the result of the action
     * @throws RouteNotFoundException
     * @var string $requestUri
     * resolve the route and return the result of the action
     */
    public function resolve(string $requestUri): mixed
    {
        $route = explode('?', $requestUri)[0];
        $action = $this->routes[$route] ?? null; // ?? null is the same as isset($this->routes[$route]) ? $this->routes[$route] : null;

        if (!$action) {
            throw new  RouteNotFoundException();
        }

        return call_user_func($action);
    }
}