<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddCacheHeaders
{
    public function handle(Request $request, Closure $next, string $type = 'static'): Response
    {
        $response = $next($request);

        // Only add cache headers for successful responses
        if (!$response->isSuccessful()) {
            return $response;
        }

        // Add cache headers based on the type
        if ($type === 'static') {
            // 1 year cache for static assets
            $response->header('Cache-Control', 'public, max-age=31536000, immutable');
        } elseif ($type === 'dynamic') {
            // 1 hour cache for dynamic content
            $response->header('Cache-Control', 'public, max-age=3600, must-revalidate');
        }

        // Add ETag for cache validation
        if (!$response->headers->has('ETag')) {
            $response->setEtag(md5($response->getContent()));
        }

        $response->isNotModified($request);

        return $response;
    }
}
