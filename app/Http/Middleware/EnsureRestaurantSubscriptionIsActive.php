<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRestaurantSubscriptionIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        $restaurant = $request->user()?->restaurant;

        if (! $restaurant) {
            return $next($request);
        }

        if ($request->isMethod('get') || $request->isMethod('head')) {
            return $next($request);
        }

        if ($restaurant->isSubscriptionActive()) {
            return $next($request);
        }

        $message = 'اشتراكك غير نشط حالياً. تقدر تدخل وتراجع البيانات فقط لحد ما يتم التجديد أو إعادة التفعيل.';

        if ($request->expectsJson()) {
            return new JsonResponse([
                'message' => $message,
            ], 403);
        }

        return (new RedirectResponse(url()->previous()))
            ->with('error', $message)
            ->withInput();
    }
}
