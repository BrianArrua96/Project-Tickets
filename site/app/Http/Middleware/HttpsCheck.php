<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HttpsCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
   {
    //$request->server("HTTP_HOST")!="127.0.0.1:8000"
       if (!$request->secure() && $request->server("HTTP_HOST")!="127.0.0.1:8000") {
        
           return redirect()->secure($request->getRequestUri());
       }
       return $next($request);
   }
}
