<?php

namespace App\Http\Middleware;

use Closure;
use Spatie\Csp\Directive;
use Spatie\Csp\Policies\Basic;

class CSPMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Aquí se crea una instancia de la política CSP que se a definido.
        $policy = new \App\Policies\CustomCspPolicy();
        
        $policy->applyTo($response);

        return $response;
    }
}
