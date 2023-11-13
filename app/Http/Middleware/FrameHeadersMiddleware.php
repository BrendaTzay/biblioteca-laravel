<?php

namespace App\Http\Middleware;

use Closure;

class FrameHeadersMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Evitar que la página sea mostrada en un frame o iframe para prevenir ataques de clickjacking
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN', false);

        return $response;
    }
}
