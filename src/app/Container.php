<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\Container\ContainerException;
use App\Exceptions\Container\NotFoundException;
use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    /**
     * @var array $entries the entries or the services registered in the container
     */
    private array $entries = [];

    public function get(string $id)
    {
        if ($this->has($id)) {
            $entry= $this->entries[$id];

            if (is_callable($entry)){
                return $entry($this);
            }
            $id=$entry; //if the entry is a string, we will use it as the id
        }

        return $this->resolve($id);

    }

    public function has(string $id): bool
    {
        return isset($this->entries[$id]);
    }

    /**
     * @param string $id the fully qualified class name
     * @param callable|string $entry the resolver of the class, a fully qualified class name or a callable
     * it should return an instance of the class with its dependencies resolved from the container
     * @return void set the entry in the container with the given id and callable entry
     */
    public function set(string $id,callable|string $entry): void
    {
        $this->entries[$id] = $entry;
    }

    public function resolve(string $id)
    {
        //1. Inspect the class that we are trying to get from the container
        $reflector = new \ReflectionClass($id);
            //1.1. If the class is not instantiable [interface, abstract class, trait]
            if (!$reflector->isInstantiable()) {
                throw new ContainerException('The class"' .$id.'" is not instantiable');
            }

        //2. Inspect the constructor of the class
        $constructor = $reflector->getConstructor();
            //2.1. If the class does not have a constructor (no dependencies)
            if (is_null($constructor)) { //if(!$constructor)
                return new $id;
            }

        //3. Inspect the constructor parameters of the class (dependencies)
        $parameters = $constructor->getParameters();
            //3.1. If the class does not have any parameters (no dependencies)
            if (empty($parameters)) {  //if(!$parameters)
                return new $id;
            }

        //4. If the constructor has parameters, resolve them recursively
        $dependencies=array_map(function (\ReflectionParameter $parameter) use ($id){
            //4.1 get the name and type of the parameter
            $name = $parameter->getName();
            $type = $parameter->getType();

            //4.2 check the type is hinted
            if (!$type) {
                throw new ContainerException('The parameter "'.$name.'" does not have a type hint');
            }

            //4.3 check the type hint is not a primitive type [means is not a class we cannot instantiate]
            if($type instanceof \ReflectionUnionType){
                throw new ContainerException('The parameter "'.$name.'" has a union type hint');
            }

            if ($type instanceof \ReflectionNamedType && !$type->isBuiltin()) {
                //4.4.1. If the class is registered in the container, get it from the container
                return $this->get( $type->getName());
            }
            throw new ContainerException('Failed to resolve class "'.$id.'because invalid parameter');


        },$parameters);

        return  $reflector->newInstanceArgs($dependencies);

    }


}