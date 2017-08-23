<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class CheckCart
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
        $key = 'cart';
        if(!Session::has($key)){
            return redirect('home');
        }

        return $next($request);
    }

}

?>