<?php

namespace App\Shared\Presentation\Http\Middleware;

use App\Shared\Domain\Enums\SupportedLocale;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->user()?->preferred_locale?->value
            ?? config('app.locale', SupportedLocale::EN->value);

        if (! in_array($locale, SupportedLocale::values(), true)) {
            $locale = config('app.fallback_locale', SupportedLocale::EN->value);
        }

        App::setLocale($locale);

        return $next($request);
    }
}
