<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Ambil status user dari session
        $userStatus = session('userdata')['status'] ?? null;

        // Jika status user tidak ada atau tidak termasuk dalam daftar role yang diizinkan
        if (!$userStatus || !in_array($userStatus, $roles)) {
            return redirect()->route('dashboard.user');
        }

        // Lanjutkan request jika user memiliki izin
        return $next($request);
    }
}
