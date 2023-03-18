<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\RouteNotFoundException;
use App\Services\PaymentGatewayService;
use App\Services\PaymentGatewayServiceInterface;


class App
{
    private static DB $db;

    /**
     * @param Router $router
     * @param array $request
     * @param Config $config
     */
    public function __construct(protected Container $container,protected Router $router, protected array $request, protected Config $config)
    {
       static::$db=new DB($config->db ?? []);

       $this->container->set(PaymentGatewayServiceInterface::class,fn(Container $c)=>$c->get(PaymentGatewayService::class));

    }

    /**
     * @return DB get the database connection
     * get the database connection
     */
    public static function db(): DB
    {
        return static::$db;
    }

    /**
     * @return void
     * resolve the routes and run the application$_SERVER
     */
    public function run(): void
    {
        try{
           echo  $this->router->resolve($this->request['uri'],strtolower( $this->request['method']));

        }catch (RouteNotFoundException){
            http_response_code(404);
            echo View::make('error/404');
        }
    }
}