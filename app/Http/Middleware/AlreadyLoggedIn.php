<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class AlreadyLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Session()->has('loginEmail') && ((url('login') == $request->url() || url('registrationAgency') == $request->url() || url('registrationUser') == $request->url() || url('admin') == $request->url()))) {
            return back();
        }
        return $next($request);
    }
}