<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdminLoggedIn
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
        if($request->session()->has("user")){
            $user = $request->session()->get("user");
            if($user->role_id != 2){
                return redirect("/home");
            }else{
                return $next($request);
            }
        }else{
            return redirect("/home");
        }
    }
}
