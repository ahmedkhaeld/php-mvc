<?php

namespace App\Enums;

enum HttpMethod: string
{
    case Get = 'get';
    case Post = 'post';
    case Put = 'put';
    case Head = 'head';
    case Delete = 'delete';
    case Patch = 'patch';
    case Options = 'options';
    case Trace = 'trace';
    case Connect = 'connect';


}
