<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRestaurantSubscriptionIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        $restaurant = $request->user()?->restaurant;

        if ($restaurant && ! $restaurant->isSubscriptionActive()) {
            abort(403, 'الحساب غير مفعل حالياً.');
        }

        return $next($request);
    }
}
