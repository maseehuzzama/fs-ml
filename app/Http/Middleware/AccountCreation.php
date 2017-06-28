<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App;

class AccountCreation
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
        if(Auth::user()->accounts === null){
            return redirect()->route('client.create-account',App::getLocale());
        }
        return $next($request);
    }
}
