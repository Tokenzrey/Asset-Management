<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekDoubleUserStatus
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
        if (session('userdata')['status'] == 'ADMIN' || session('userdata')['status'] == 'MANAGER') {
            return $next($request);
        }
        return redirect()->route('dashboard.user');
    }
}
