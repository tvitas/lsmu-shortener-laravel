<?php

namespace App\Http\Middleware;


use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Closure;

class Language
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->app->setLocale(session()->get('lang', config('app.locale')));
        return $next($request);
    }
}
