<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekUserStatus
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
        if(session('userdata')['status'] != 'ADMIN' || session('userdata')['status'] != 'DIREKSI') {
            return redirect()->route('dashboard.user');
        }
        return $next($request);
    }
}
