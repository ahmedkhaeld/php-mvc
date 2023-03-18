<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\RouteNotFoundException;
use App\Services\EmailService;
use App\Services\InvoiceService;
use App\Services\PaymentGatewayService;
use App\Services\SalesTaxService;

class App
{
    private static DB $db;
    public static Container $container;

    /**
     * @param Router $router
     * @param array $request
     * @param Config $config
     */
    public function __construct(protected Router $router, protected array $request, protected Config $config)
    {
       static::$db=new DB($config->db ?? []);
       //initialize the container
         static::$container=new Container();

            //register the InvoiceService with its dependencies in the container
         static::$container->set(InvoiceService::class,function(Container $c){
             return new InvoiceService(
                 $c->get(SalesTaxService::class),
                 $c->get(PaymentGatewayService::class),
                 $c->get(EmailService::class)
             );
         });

         //register the services in the container
         static::$container->set(SalesTaxService::class,fn()=>new SalesTaxService());
         static::$container->set(PaymentGatewayService::class,fn()=>new PaymentGatewayService());
         static::$container->set(EmailService::class,fn()=>new EmailService());
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