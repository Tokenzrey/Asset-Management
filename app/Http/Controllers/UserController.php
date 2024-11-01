<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Divisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index()
    {
        $user = User::where('aktif', '=', 'y')->get();
        $divisi = Divisi::where('aktif', '=', 'y')->get();
        return view('user.index', [
            'user'      => $user,
            'divisi'    => $divisi
        ]);
    }

    public function store(Request $request)
    {
        $gambar = null;
        if ($request->file('gambar')) {
            $gambar_extension = $request->file('gambar')->extension();
            if (in_array($gambar_extension, array('jpg', 'jpeg', 'png')) == false) {
                return back()->withInput()->with('error', 'Type gambar yang diijinkan jpg,jpeg,png!');
            }
            $gambar = $request->file('gambar')->store('public/gambar_user');
            $gambar = str_replace('public/', '', $gambar);
        }else{
            Alert::error('Error', 'Gambar wajib diunggah!');
            return redirect()->route('user.index');
        }


        User::create([
            'nama'              => $request->nama,
            'jenis_kelamin'     => $request->jk,
            'no_telepon'        => $request->no_telepon,
            'alamat'            => $request->alamat,
            'status'            => $request->status,
            'divisi_id'         => $request->divisi,
            'gambar'            => ($gambar) ? $gambar : null,
            'email'             => $request->email,
            'username'          => strtolower($request->username),
            'password'          => Hash::make($request->password),
            'created_at'        => date('Y-m-d H:m:s'),
        ]);
        Alert::success('Success', 'User Berhasil Ditambahkan');
        return redirect()->route('user.index');
    }

    public function show($id)
    {
        $user = User::find($id);
        $divisi = Divisi::where('aktif', '=', 'y')->get();
        return view('user.show', [
            'user'      => $user,
            'divisi'    => $divisi
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            Alert::error('Error', 'User Tidak Ditemukan');
            return redirect()->route('user.index');
        }

        $gambar = null;
        if ($request->file('gambar')) {
            $gambar_extension = $request->file('gambar')->extension();
            if (in_array($gambar_extension, array('jpg', 'jpeg', 'png')) == false) {
                Alert::error('Error', 'Type gambar yang diijinkan jpg,jpeg,png!');
                return redirect()->route('user.index');
            }
            $gambar = $request->file('gambar')->store('public/gambar_user');
            $gambar = str_replace('public/', '', $gambar);
        }else{
            Alert::error('Error', 'Gambar wajib diunggah!');
            return redirect()->route('user.index');
        }

        $data_user = [
            'nama'              => $request->nama,
            'jenis_kelamin'     => $request->jk,
            'no_telepon'        => $request->no_telepon,
            'alamat'            => $request->alamat,
            'status'            => $request->status,
            'divisi_id'         => $request->divisi_id,
            'email'             => $request->email,
            'username'          => $request->username,
            'updated_at'        => date('Y-m-d H:m:s')
        ];
        if($request->password != $user->password) {
            $data_user['password'] = Hash::make($request->password);
        }

        if ($gambar){
            $data_user['gambar'] = $gambar;
        }
        $user->update($data_user);
        Alert::success('Success', 'User Berhasil Di Update!');
        return redirect()->route('user.index');
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return back()->withInput()->with('error', 'User tidak ditemukan!');
        }

        // Coba lakukan update dan cek hasilnya
        if ($user->update(['aktif' => 't'])) {
            Alert::success('Success', 'User Berhasil Dihapus');
            return redirect()->route('user.index');
        } else {
            return back()->withInput()->with('error', 'Gagal menghapus user!');
        }
    }
}
