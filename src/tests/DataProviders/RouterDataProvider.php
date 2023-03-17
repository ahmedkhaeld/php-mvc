<?php

namespace Tests\DataProviders;

class RouterDataProvider
{
    public function ExceptionsCasesToResolve(): array
    {
        //falling cases that should throw RouteNotFoundException
        return [
            ['/users','put'], //method not allowed
            ['/invoices','post'], //route not found
            ['/users','get'], //class not exists
            ['/users','post'] //class exists but method not exists
        ];
    }

}