<?php

declare(strict_types=1);
namespace Tests\Unit;

use App\Exceptions\RouteNotFoundException;
use App\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    /**
     * @var Router
     */
    private Router $router;


    protected function setUp(): void
    {
        parent::setUp();
        $this->router = new Router();
    }

    public function testRegisterRoutes():void
    {
        //success case should be equal
        $this->router->register('get','/users',['Users','index']);
        $exp = ['get' => [ '/users' => ['Users','index']]];
        $this->assertSame($exp,$this->router->routes());

        //failure case should not be equal
        $this->router->register('get','/users',['Users','index']);
        $exp = ['put' => [ '/users' => ['Users','index']]];
        $this->assertNotEquals($exp,$this->router->routes());

    }

    public function testGetRoutes():void
    {

        //success case should be equal
        $this->router->get('/users', ['Users', 'index']);
        $exp = ['get' => ['/users' => ['Users', 'index']]];
        $this->assertSame($exp, $this->router->routes());

        //failure case should not be equal
        $this->router->get('/users', ['Users', 'index']);
        $exp = ['put' => ['/users' => ['Users', 'index']]];
        $this->assertNotEquals($exp, $this->router->routes());


    }

    public function testPostRoutes():void
    {

        $this->router->post('/users', ['Users', 'store']);
        $exp = ['post' => ['/users' => ['Users', 'store']]];
        $this->assertSame($exp, $this->router->routes());

        $this->router->post('/users', ['Users', 'store']);
        $exp = ['put' => ['/users' => ['Users', 'store']]];
        $this->assertNotEquals($exp, $this->router->routes());
    }

    //test the routes' method, confirm all routes can be returned
    public function testRoutes():void
    {

        //test empty routes return empty array
        $route=new Router();
        $this->assertEmpty($route->routes());

       //$routes() return multidimensional associative array
        //$routes['method']['route'] = ['controller','action']
        $this->router->get('/users', ['Users', 'index']);
        $this->router->post('/users', ['Users', 'store']);

        $exp = [
            'get' => ['/users' => ['Users', 'index']],
            'post' => ['/users' => ['Users', 'store']]
        ];

        $this->assertSame($exp, $this->router->routes());

     }





     /**
      * @dataProvider \Tests\DataProviders\RouterDataProvider::ExceptionsCasesToResolve
      */
    public function testResolveExceptions(string $uri,string $method):void
    {
        //test the failure cases
        //RouteNotFoundException should be thrown if
        //the action is not set which means the route is not registered or the method is not allowed
        //the class of the action is not exists
        //the class of the action exists but the method is not exists

        //simulate a controller
        $users=new class{
            public function delete():bool
            {
                return true;
            }
        };

        //given a routes and its actions
        $this->router->get('/users', ['Users', 'index']);
        $this->router->post('/users', [$users::class, 'store']);

        $this->expectException(RouteNotFoundException::class);
        $this->router->resolve($uri,$method);

    }

    public function testResolveClosure():void
    {

        //given a routes and its actions
        $this->router->get('/users', fn() => [1,2,3]);

        $this->assertSame([1,2,3],$this->router->resolve('/users','get'));

    }

    public function testResolve():void
    {

        //simulate a controller
        $users=new class{
            public function index():array
            {
                return [1,2,3];
            }
        };

        //given a routes and its actions
        $this->router->get('/users', [$users::class, 'index']);
        $this->assertSame([1,2,3],$this->router->resolve('/users','get'));

        //assertEqual : ==
        //assertSame : ===


    }
}
