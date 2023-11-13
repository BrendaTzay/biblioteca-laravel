<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RemoveHeadersMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
    
        // Remover encabezados
        $response->headers->remove('X-Powered-By');
    
        return $response;
    }
    
}
