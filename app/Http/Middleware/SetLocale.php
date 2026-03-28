<?php

namespace App\Http\Middleware;

use App\Modules\Settings\Infrastructure\Persistence\Models\BusinessProfile;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $supported = ['en', 'ru', 'uk'];

        $userLocale = auth()->user()?->preferred_locale;

        if ($userLocale instanceof \BackedEnum) {
            $userLocale = $userLocale->value;
        }

        $systemLocale = BusinessProfile::query()
            ->where('is_active', true)
            ->value('default_locale');

        if ($systemLocale instanceof \BackedEnum) {
            $systemLocale = $systemLocale->value;
        }

        $locale = $userLocale ?: $systemLocale ?: config('app.locale');

        if (! in_array($locale, $supported, true)) {
            $locale = config('app.fallback_locale', 'en');
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
