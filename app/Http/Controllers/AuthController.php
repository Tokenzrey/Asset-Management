<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (session('success')) {
                Alert::success(session('success'));
            }

            if (session('error')) {
                Alert::error(session('error'));
            }

            return $next($request);
        });
    }
    public function login()
    {
        return view('login');
    }

    public function check(Request $request)
    {
        // Validasi input username dan password
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi!',
            'password.required' => 'Password wajib diisi!',
        ]);

        $username = $request->username;
        $password = $request->password;
        if (!$username || !$password) {
            Alert::error('Error', 'Silahkan cek username/password anda!');
            return redirect('/');
        }
        // Cari user berdasarkan username dan status aktif
        $user = User::where(['username' => $username, 'aktif' => 'y'])->first();

        if (!$user) {
            Alert::error('Error', 'Silahkan cek username/password anda!');
            return back()->withInput();
        }

        if (!Hash::check($password, $user->password)) {
            Alert::error('Error', 'Password kurang tepat!');
            return back()->withInput();
        }

        // Set session jika login berhasil
        session(['userdata' => $user, 'logged_in' => true]);
        Alert::success('Success', 'Login berhasil!');
        return redirect('/');
    }

    public function logout(Request $request)
    {
        session()->flush();
        return redirect('/login');
    }
}
