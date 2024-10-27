<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class CekSesi
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
        // Jika path bukan 'login' dan session 'logged_in' tidak ada, redirect ke login
        if ($request->path() != 'login') {
            if (!session('logged_in')) {
                return redirect('login');
            }

            // Update session dengan data terbaru dari database
            $userId = session('userdata')->getAttribute('id') ?? null;
            if ($userId) {
                $user = User::find($userId);

                // Periksa apakah data user ditemukan dan status aktif
                if ($user && $user->aktif === 'y') {
                    session(['userdata' => $user]);  // Update data user di session
                } else {
                    session()->flush();  // Hapus session jika user tidak valid
                    return redirect('login')->with('error', 'Session tidak valid. Silahkan login kembali.');
                }
            }

            return $next($request);
        } else {
            // Jika user sudah login dan mengakses 'login' lagi, redirect ke halaman utama
            if (session('logged_in')) {
                return redirect('/');
            }
            return $next($request);
        }
    }
}
