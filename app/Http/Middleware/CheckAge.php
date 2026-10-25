<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAge
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    
public function handle(Request $request, Closure $next): Response
{
    if (!session()->has('age') || session('age') < 18) {
        return redirect('/')
            ->with('error', 'You must be 18 or older to access this page.');
    }

    return $next($request);
}

}
