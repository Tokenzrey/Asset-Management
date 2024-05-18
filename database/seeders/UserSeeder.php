<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();

        //percobaan testing
        // User::create([
        //     'nip'           => '1111111111',
        //     'nama'          => 'Admin',
        //     'jenis_kelamin' => 'Laki-laki',
        //     'no_telepon'    => '85632112345',
        //     'alamat'        => 'Sidoarjo',
        //     'status'        => 'ADMIN',
        //     'aktif'         => 'y',
        //     'username'      => 'admin',
        //     'email'         => 'admin@gmail.com',
        //     'password'      => bcrypt('adminsmk'),
        //     'gambar'        => 'gambar_user/user1.jpg',
        //     'divisi_id'     => 19
        // ]);
        // User::create([
        //     'nip'           => '2222222222',
        //     'nama'          => 'User',
        //     'jenis_kelamin' => 'Laki-laki',
        //     'no_telepon'    => '856343243245',
        //     'alamat'        => 'Sidoarjo',
        //     'status'        => 'USER',
        //     'aktif'         => 'y',
        //     'username'      => 'user',
        //     'email'         => 'user@gmail.com',
        //     'password'      => bcrypt('rahasia'),
        //     'gambar'        => 'gambar_user/user2.png',
        //     'divisi_id'     => 19
        // ]);

        //1
        User::create([
            'nama'          => ' MOH. AMIN, S.A.N.',
            'jenis_kelamin' => 'Laki-laki',
            'no_telepon'    => '081939111113',
            'alamat'        => 'Surabaya',
            'status'        => 'ADMIN',
            'aktif'         => 'y',
            'username'      => 'amin',
            'email'         => 'amin@gmail.com',
            'password'      => bcrypt('adminsmk'),
            'gambar'        => 'gambar_user/user1.jpg',
            'divisi_id'     => 5
        ]);

        //2
        User::create([
            'nama'          => 'ISHAK, S.Pd., M.M.',
            'jenis_kelamin' => 'Laki-laki',
            'no_telepon'    => '82332918672',
            'alamat'        => 'Surabaya',
            'status'        => 'USER',
            'aktif'         => 'y',
            'username'      => 'ishak',
            'email'         => 'ishak@gmail.com',
            'password'      => bcrypt('rahasia'),
            'gambar'        => 'gambar_user/user2.png',
            'divisi_id'     => 1
        ]);

        //3
        User::create([
            'nama'          => 'ANGGIT SUBIANTO, S.Pd',
            'jenis_kelamin' => 'Laki-laki',
            'no_telepon'    => '82332918672',
            'alamat'        => 'Surabaya',
            'status'        => 'USER',
            'aktif'         => 'y',
            'username'      => 'anggit',
            'email'         => 'anggit@gmail.com',
            'password'      => bcrypt('rahasia'),
            'gambar'        => 'gambar_user/user2.png',
            'divisi_id'     => 5
        ]);

        //4
        User::create([
            'nama'          => 'AGUNG SETIAWAN, S.Pd',
            'jenis_kelamin' => 'Laki-laki',
            'no_telepon'    => '000000000000',
            'alamat'        => 'Surabaya',
            'status'        => 'USER',
            'aktif'         => 'y',
            'username'      => 'agung',
            'email'         => 'agung@gmail.com',
            'password'      => bcrypt('rahasia'),
            'gambar'        => 'gambar_user/user2.png',
            'divisi_id'     => 9
        ]);

        //5
        User::create([
            'nama'          => 'Drs. MOCH. YASIN',
            'jenis_kelamin' => 'Laki-laki',
            'no_telepon'    => '000000000000',
            'alamat'        => 'Surabaya',
            'status'        => 'USER',
            'aktif'         => 'y',
            'username'      => 'yasin',
            'email'         => 'yasin@gmail.com',
            'password'      => bcrypt('rahasia'),
            'gambar'        => 'gambar_user/user2.png',
            'divisi_id'     => 8
        ]);

        //6
        User::create([
            'nama'          => 'TAUFIQUR RAHMAN, S.Pd',
            'jenis_kelamin' => 'Laki-laki',
            'no_telepon'    => '000000000000',
            'alamat'        => 'Surabaya',
            'status'        => 'USER',
            'aktif'         => 'y',
            'username'      => 'taufiqur',
            'email'         => 'taufiqur@gmail.com',
            'password'      => bcrypt('rahasia'),
            'gambar'        => 'gambar_user/user2.png',
            'divisi_id'     => 9
        ]);

        //7
        User::create([
            'nama'          => 'HAIRUL AMIN, S.Pd',
            'jenis_kelamin' => 'Laki-laki',
            'no_telepon'    => '000000000000',
            'alamat'        => 'Surabaya',
            'status'        => 'USER',
            'aktif'         => 'y',
            'username'      => 'hairul',
            'email'         => 'hairul@gmail.com',
            'password'      => bcrypt('rahasia'),
            'gambar'        => 'gambar_user/user2.png',
            'divisi_id'     => 9
        ]);

        //8
        User::create([
            'nama'          => 'LISWIYANI FARRAWATI, S.E.',
            'jenis_kelamin' => 'Peremupuan',
            'no_telepon'    => '000000000000',
            'alamat'        => 'Surabaya',
            'status'        => 'USER',
            'aktif'         => 'y',
            'username'      => 'liswiyani',
            'email'         => 'liswiyani@gmail.com',
            'password'      => bcrypt('rahasia'),
            'gambar'        => 'gambar_user/user2.png',
            'divisi_id'     => 12
        ]);

        //9
        User::create([
            'nama'          => 'SOFI INDRIANA, S.Pd., M.M.',
            'jenis_kelamin' => 'Perempuan',
            'no_telepon'    => '000000000000',
            'alamat'        => 'Surabaya',
            'status'        => 'USER',
            'aktif'         => 'y',
            'username'      => 'sofi',
            'email'         => 'sofi@gmail.com',
            'password'      => bcrypt('rahasia'),
            'gambar'        => 'gambar_user/user2.png',
            'divisi_id'     => 8
        ]);

        //10
        User::create([
            'nama'          => 'ACHMAD BASRI, S.Pd',
            'jenis_kelamin' => 'Laki-laki',
            'no_telepon'    => '000000000000',
            'alamat'        => 'Surabaya',
            'status'        => 'USER',
            'aktif'         => 'y',
            'username'      => 'basri',
            'email'         => 'basri@gmail.com',
            'password'      => bcrypt('rahasia'),
            'gambar'        => 'gambar_user/user2.png',
            'divisi_id'     => 18
        ]);

        //11
        User::create([
            'nama'          => 'ISWONDO, S.Pd',
            'jenis_kelamin' => 'Laki-laki',
            'no_telepon'    => '000000000000',
            'alamat'        => 'Surabaya',
            'status'        => 'USER',
            'aktif'         => 'y',
            'username'      => 'iswondo',
            'email'         => 'iswondo@gmail.com',
            'password'      => bcrypt('rahasia'),
            'gambar'        => 'gambar_user/user2.png',
            'divisi_id'     => 8
        ]);

        //12
        User::create([
            'nama'          => 'YUNI HARTATIK, S.T.',
            'jenis_kelamin' => 'Perempuan',
            'no_telepon'    => '000000000000',
            'alamat'        => 'Surabaya',
            'status'        => 'USER',
            'aktif'         => 'y',
            'username'      => 'yuni',
            'email'         => 'yuni@gmail.com',
            'password'      => bcrypt('rahasia'),
            'gambar'        => 'gambar_user/user2.png',
            'divisi_id'     => 10
        ]);

        //13
        User::create([
            'nama'          => 'AHMAD FARHAN WAHYUDI, S.Pd',
            'jenis_kelamin' => 'Laki-laki',
            'no_telepon'    => '000000000000',
            'alamat'        => 'Surabaya',
            'status'        => 'USER',
            'aktif'         => 'y',
            'username'      => 'farhan',
            'email'         => 'farhan@gmail.com',
            'password'      => bcrypt('rahasia'),
            'gambar'        => 'gambar_user/user2.png',
            'divisi_id'     => 5
        ]);

        //14
        User::create([
            'nama'          => 'NANANG EKA YULIANTO, S.Pd',
            'jenis_kelamin' => 'Laki-laki',
            'no_telepon'    => '000000000000',
            'alamat'        => 'Surabaya',
            'status'        => 'USER',
            'aktif'         => 'y',
            'username'      => 'nanang',
            'email'         => 'nanang@gmail.com',
            'password'      => bcrypt('rahasia'),
            'gambar'        => 'gambar_user/user2.png',
            'divisi_id'     => 6
        ]);

        //15
        User::create([
            'nama'          => 'ERWINDYA YULI, S.Pd',
            'jenis_kelamin' => 'Laki-laki',
            'no_telepon'    => '000000000000',
            'alamat'        => 'Surabaya',
            'status'        => 'USER',
            'aktif'         => 'y',
            'username'      => 'erwindya',
            'email'         => 'erwindya@gmail.com',
            'password'      => bcrypt('rahasia'),
            'gambar'        => 'gambar_user/user2.png',
            'divisi_id'     => 9
        ]);

        User::create([
            'nama'          => 'EA YULI, S.Pd',
            'jenis_kelamin' => 'Laki-laki',
            'no_telepon'    => '000400608000',
            'alamat'        => 'Surabaya',
            'status'        => 'MANAGER',
            'aktif'         => 'y',
            'username'      => 'erwdya',
            'email'         => 'erwina@gmail.com',
            'password'      => bcrypt('rahasia'),
            'gambar'        => 'gambar_user/user2.png',
            'divisi_id'     => 9
        ]);
    }
}
