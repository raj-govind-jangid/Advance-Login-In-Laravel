<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class LoginMiddleware
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
        if($request->path()=="login" && Auth::check()){
            return redirect('/');
        }
        elseif($request->path()=="register" && Auth::check()){
            return redirect('/');
        }
        elseif($request->path()=="logout" && !Auth::check()){
            return redirect('/login');
        }
        elseif($request->path()=="forgetpassword" && Auth::check()){
            return redirect('/');
        }
        elseif($request->path()=="changepassword" && Auth::check()){
            return redirect('/');
        }
        elseif($request->path()=="changeemailaddress" && !Auth::check()){
            return redirect('/');
        }
        elseif($request->path()=="changeuserpassword" && !Auth::check()){
            return redirect('/');
        }
        elseif($request->path()=="profile" && !Auth::check()){
            return redirect('/');
        }
        else{
            return $next($request);
        }

    }
}
