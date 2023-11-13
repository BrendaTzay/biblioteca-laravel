<?php

namespace App\Policies;

use Spatie\Csp\Policies\Policy;

class CustomCspPolicy extends Policy
{
    public function configure()
{
    $this
        ->addDirective('default-src', ["'self'"])
        ->addDirective('script-src', [
            "'self'",
            "https://code.jquery.com",
            "https://cdnjs.cloudflare.com",
            "https://maxcdn.bootstrapcdn.com",
            "https://cdn.jsdelivr.net",
            "'unsafe-inline'", 
        ])
        ->addDirective('style-src', [
            "'self'",
            "https://fonts.googleapis.com",
            "https://cdnjs.cloudflare.com",
            "https://maxcdn.bootstrapcdn.com",
            "https://cdn.jsdelivr.net",
            "https://code.jquery.com", 
            "'unsafe-inline'", 
        ])
        ->addDirective('img-src', [
            "'self'",
            "data:",
            "https:",
        ])
        ->addDirective('font-src', [
            "'self'",
            "https://fonts.gstatic.com",
            "https://cdnjs.cloudflare.com",
            "https://cdn.jsdelivr.net",
            "data:",
        ])
        ->addDirective('connect-src', ["'self'"])
        ->addDirective('frame-src', ["'self'"])
        ->addDirective('object-src', ["'none'"])
        ->addDirective('base-uri', ["'self'"])
        ->addDirective('form-action', ["'self'"])
        ;
}

}
