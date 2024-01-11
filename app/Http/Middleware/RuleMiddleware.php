<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class RuleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            if (Auth::user()->role == '1') {
                return $next($request);
            }
            if ((Auth::user()->branch_id != null) && (Auth::user()->active == '1')) {
                return $next($request);
            } else {
                return redirect('/')->with('message', 'ليس لديك الصلاحيات لعرض هذه الصفحة');
            }
        } else {
            return redirect('/login')->with('message', 'الرجاء تسجيل الدخول لعرض الصفحة');
        }
        return $next($request);
    }
}
