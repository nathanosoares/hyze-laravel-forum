<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
// use Fideloper\Proxy\TrustProxies as Middleware;
use Monicahq\Cloudflare\Http\Middleware\TrustProxies as Middleware;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * @var array
     */
    protected $proxies = [
        'localhost',
        '127.0.0.1',
        '0.0.0.0'
    ];

    /**
     * The headers that should be used to detect proxies.
     *
     * @var int
     */
    protected $headers = Request::HEADER_X_FORWARDED_ALL;
}
