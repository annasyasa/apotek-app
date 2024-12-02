<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\facades\Auth;

class isLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check()){
            return $next($request);
        }else if ($request->routeIs('login')){
            return $next($request);
        } else {
            return redirect()->route('login')->with('failed', 'Anda harus login kembali');
        }
            

        //     //kalo dh login blh akses
        //     return $next($request);
        // } else if ($request->routeIs('login')) {
        //     return $next($request);
        // }
        // else{
        //     //klo blm login balikin ke login
        //     return redirect()->route('errors.permission');
        }
    }

