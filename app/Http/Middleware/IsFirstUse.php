<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Users;

class IsFirstUse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Users::first();
        if($user && !$request->session()->has('run_setup')){
            return redirect('/');
        }
        
        return $next($request);
    }
}
