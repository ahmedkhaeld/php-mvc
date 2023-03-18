<?php

declare(strict_types=1);

namespace App;

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
        if (!$this->has($id)) {
            throw new NotFoundException('Class "' . $id . '" not found.');
        }

        $entry= $this->entries[$id];

        return $entry($this);
    }

    public function has(string $id): bool
    {
        return isset($this->entries[$id]);
    }

    /**
     * @param string $id the fully qualified class name
     * @param callable $entry the resolver of the class,
     * it should return an instance of the class with its dependencies resolved from the container
     * @return void set the entry in the container with the given id and callable entry
     */
    public function set(string $id,callable $entry): void
    {
        $this->entries[$id] = $entry;
    }


}