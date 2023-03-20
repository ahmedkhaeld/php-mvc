<?php

declare(strict_types=1);

namespace App;

use App\Attributes\Route;
use App\Exceptions\RouteNotFoundException;
use ReflectionAttribute;
use ReflectionException;

class Router
{
    /**
     * @param array $routes
     * the routes and their actions
     */
    private array $routes=[];

    public function __construct( private Container $container)
    {
    }

    /**
     * @param array $controllers
     * @throws ReflectionException
     * register routes from attributes using reflection to get the attributes of the methods of the controllers
     * and register them to the router
     */
    public function registerRoutesFromAttributes(array $controllers): void
    {
        foreach ($controllers as $controller) {
            $reflection = new \ReflectionClass($controller);
            $methods = $reflection->getMethods();
            foreach ($methods as $method) {
                $attributes = $method->getAttributes(Route::class, ReflectionAttribute::IS_INSTANCEOF);
                foreach ($attributes as $attribute) {
                    $route = $attribute->newInstance();
                    $this->register($route->method->value, $route->path, [$controller, $method->getName()]);
                }
            }
        }
    }

    /**
     * @param callable|array $action the action of the route
     * @param string $route the route of the request
     * @param string $method the method of the request could be GET or POST
     * @return self $this the current instance of the router
     * register a route and its action to the router
     */
    public function register(string $method,string $route, callable|array $action): self
    {
        $this->routes[$method][$route] = $action;

        return $this;
    }

    public function get(string $route, callable|array $action): self
    {
        return $this->register('get',$route, $action);
    }

    public function post(string $route, callable|array $action): self
    {
        return $this->register('post',$route, $action);
    }

    /**
     * @return array the routes and their actions
     * get the routes and their actions
     */
    public function routes(): array
    {
        return $this->routes;
    }


    /**
     * @return mixed the result of the action
     * @throws RouteNotFoundException
     * @param string $requestUri
     * resolve the route and return the result of the action
     */
    public function resolve(string $requestUri,string $method): mixed
    {
        $route = explode('?', $requestUri)[0];
        $action = $this->routes[$method][$route] ?? null;

        if (!$action) {
            throw new  RouteNotFoundException();
        }
        //check if the action is callable
        if (is_callable($action)) {
            return call_user_func($action);
        }


            //destructuring the array
            [$controller, $method] = $action;
            //check if controller exists
            if (class_exists($controller)){
                $controller = $this->container->get($controller);
                //check if method exists
                if (method_exists($controller, $method)) {
                    return call_user_func([$controller, $method]);
                }
            }

        throw new RouteNotFoundException();


    }
}