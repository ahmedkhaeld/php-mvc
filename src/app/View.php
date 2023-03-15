<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\ViewNotFoundException;

class View
{

    /**
     * @param string $view the name of the view
     * @param array $params data to be passed to the view from the controller or the router or the model
     */
    public function __construct(protected string $view, protected array $params =[])
    {
    }

    public static function make(string $string,array $params=[] ):static
    {
        return new static($string,$params);
    }

    /**
     * @throws ViewNotFoundException
     */
    public function render(): string
    {
        $viewPath=VIEWS_PATH . '/'. $this->view . '.php';
        if (!file_exists($viewPath)) {
            throw new ViewNotFoundException();
        }

        extract($this->params);

        ob_start();
        include $viewPath;
        return (string) ob_get_clean();
    }

    public function __toString(): string
    {
        return $this->render();
    }

    //get the params from the view
    public function __get(string $name)
    {
        return $this->params[$name] ?? null;
    }

}