<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\RouteNotFoundException;
use App\Services\PaymentGatewayService;
use App\Services\PaymentGatewayServiceInterface;
use Dotenv\Dotenv;
use Symfony\Component\Mailer\MailerInterface;


class App
{
    private static DB $db;
    private Config $config;

    /**
     * @param Container $container
     * @param Router|null $router
     * @param array $request
     */
    public function __construct(
        protected Container $container,
        protected ?Router $router=null,
        protected array $request=[] )
    {
    }

    public function boot(): static
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();

        $this->config = new Config($_ENV);
        static::$db = new DB($this->config->db ?? []);

        $this->container->set(PaymentGatewayServiceInterface::class,PaymentGatewayService::class);
        $this->container->set(MailerInterface::class,fn()=>new CustomMailer($this->config->mailer['dsn']));

        return $this;
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