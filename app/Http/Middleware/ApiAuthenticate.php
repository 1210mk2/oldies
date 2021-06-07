<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('api_key');

        if ($token !== env('API_KEY')) {
            throw new HttpException(401, 'Invalid token');
        }

        return $next($request);
    }
}
