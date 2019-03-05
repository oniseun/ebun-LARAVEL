<?php

namespace App\Http\Middleware;

use Closure;
use App\Auth;

class WebAuth
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
        if (!Auth::check()) {
            if(\Request::ajax())
            {
                echo ajax_alert('warning', 'You are not logged in, please refresh this page');
            }
            else { 
                if(\Request::path() == 'post')
                {
                    return redirect()->action('AuthController@loginForm')
                        ->with('failure' , 'You must login to view this page');
                }
                else {
                    return redirect()->action('AuthController@loginForm')
                        ->with(['failure' => 'You must login to view this page', 'redirect_url' => \Request::path()]);
                }
                
            }
            
        }
        return $next($request);
    }
}
