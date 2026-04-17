<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRestaurantSetup
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->restaurant_id && ! $request->routeIs('onboarding.*', 'logout')) {
            return redirect()->route('onboarding.create');
        }

        return $next($request);
    }
}
