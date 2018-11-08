<?php

namespace App\Http\Middleware;

use Closure;
use App;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->session()->has('locale')  ) {
            $locale = $request->session()->get('locale');
            App::setLocale($locale);
        }
        return $next($request);
    }
}
