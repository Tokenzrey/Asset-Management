<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AsetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RuangController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\JenisPemeliharaanController;
use App\Http\Controllers\JadwalPemeliharaanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//authentikasi
Route::get('/login', [AuthController::class, 'login'])->middleware('ceksesi')->name('login');
Route::post('/login', [AuthController::class, 'check'])->middleware('ceksesi');
Route::get('/logout', [AuthController::class, 'logout'])->middleware('ceksesi')->name('logout');
Route::get('/', [DashboardController::class, 'admin'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('dashboard.admin');
Route::get('/dashboard', [DashboardController::class, 'user'])->middleware('ceksesi')->name('dashboard.user');

//divisi (turned off as not used)

// Route::get('/divisi', [DivisiController::class, 'index'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('divisi.index');
// Route::post('/divisi/create', [DivisiController::class, 'store'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('divisi.store');
// Route::get('/divisi/show/{id}', [DivisiController::class, 'show'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('divisi.show');
// Route::put('/divisi/update/{id}', [DivisiController::class, 'update'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('divisi.update');
// Route::get('/divisi/delete/{id}', [DivisiController::class, 'destroy'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('divisi.destroy');

//user pengguna
Route::get('/user', [UserController::class, 'index'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('user.index');
Route::post('/user/create', [UserController::class, 'store'])->middleware('ceksesi', 'cekuserstatus')->name('user.store');
Route::get('/user/show/{id}', [UserController::class, 'show'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('user.show');
Route::put('/user/update/{id}', [UserController::class, 'update'])->middleware('ceksesi', 'cekuserstatus')->name('user.update');
Route::get('/user/delete/{id}', [UserController::class, 'destroy'])->middleware(['ceksesi', 'cekuserstatus'])->name('user.destroy');

//kategori
Route::get('/kategori', [KategoriController::class, 'index'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('kategori.index');
Route::post('/kategori/create', [KategoriController::class, 'store'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('kategori.store');
Route::get('/kategori/show/{id}', [KategoriController::class, 'show'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('kategori.show');
Route::put('/kategori/update/{id}', [KategoriController::class, 'update'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('kategori.update');
Route::get('/kategori/delete/{id}', [KategoriController::class, 'destroy'])->middleware(['ceksesi', 'cekdoubleuserstatus'])->name('kategori.destroy');

//lokasi
Route::get('/lokasi', [RuangController::class, 'index'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('ruang.index');
Route::post('/lokasi/create', [RuangController::class, 'store'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('ruang.store');
Route::get('/lokasi/show/{id}', [RuangController::class, 'show'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('ruang.show');
Route::put('/lokasi/update/{id}', [RuangController::class, 'update'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('ruang.update');
Route::get('/lokasi/delete/{id}', [RuangController::class, 'destroy'])->middleware(['ceksesi', 'cekdoubleuserstatus'])->name('ruang.destroy');

//jenis_pemeliharaan
Route::get('/jenis_pemeliharaan', [JenisPemeliharaanController::class, 'index'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('jenis_pemeliharaan.index');
Route::post('/jenis_pemeliharaan/create', [JenisPemeliharaanController::class, 'store'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('jenis_pemeliharaan.store');
Route::get('/jenis_pemeliharaan/show/{id}', [JenisPemeliharaanController::class, 'show'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('jenis_pemeliharaan.show');
Route::put('/jenis_pemeliharaan/update/{id}', [JenisPemeliharaanController::class, 'update'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('jenis_pemeliharaan.update');
Route::get('jenis_pemeliharaan/delete/{id}', [JenisPemeliharaanController::class, 'destroy'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('jenis_pemeliharaan.destroy');

//supplier
Route::get('/vendors', [\App\Http\Controllers\VendorController::class, 'index'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('supplier.index');
Route::post('/vendors/create', [\App\Http\Controllers\VendorController::class, 'store'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('supplier.store');
Route::get('/vendors/show/{id}', [\App\Http\Controllers\VendorController::class, 'show'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('supplier.show');
Route::put('/vendors/update/{id}', [\App\Http\Controllers\VendorController::class, 'update'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('supplier.update');
Route::get('/vendors/delete/{id}', [\App\Http\Controllers\VendorController::class, 'destroy'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('supplier.destroy');

//aset
Route::get('/aset', [AsetController::class, 'index'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('aset.index');
Route::post('/aset/create', [AsetController::class, 'store'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('aset.store');
Route::get('/aset/show/{id}', [AsetController::class, 'show'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('aset.show');
Route::put('/aset/update/{id}', [AsetController::class, 'update'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('aset.update');
Route::get('/aset/delete/{id}', [AsetController::class, 'destroy'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('aset.destroy');

Route::get('/aset/qrcode', [AsetController::class, 'qrcode'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('aset.qrcode');
Route::get('/aset/scan_qrcode', [AsetController::class, 'scan_qrcode'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('aset.scan_qrcode');
Route::get('/aset/cetakqrcode', [AsetController::class, 'cetakqrcode'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('aset.cetakqrcode');


//export & import data aset
Route::get('/export-data-aset', [AsetController::class, 'aset_export'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('aset.export');
Route::post('/import-data-aset', [AsetController::class, 'aset_import'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('aset.import');

//jadwal pemeliharaan (maintenance)
Route::get('/jadwal_pemeliharaan', [JadwalPemeliharaanController::class, 'index'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('jadwal_pemeliharaan.index');
Route::post('/jadwal_pemeliharaan/create', [JadwalPemeliharaanController::class, 'store'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('jadwal_pemeliharaan.store');
Route::get('/jadwal_pemeliharaan/show/{id}', [JadwalPemeliharaanController::class, 'show'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('jadwal_pemeliharaan.show');
Route::put('/jadwal_pemeliharaan/update/{id}', [JadwalPemeliharaanController::class, 'update'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('jadwal_pemeliharaan.update');
Route::get('jadwal_pemeliharaan/delete/{id}', [JadwalPemeliharaanController::class, 'destroy'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('jadwal_pemeliharaan.destroy');

//report
Route::get('/report', [ReportController::class, 'index'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('report.index');
Route::get('/report/aset', [ReportController::class, 'report_aset'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('report.aset');
Route::get('/report/peminjaman', [ReportController::class, 'report_peminjaman'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('report.peminjaman');
Route::get('/report/history_peminjaman', [ReportController::class, 'report_history_peminjaman'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('report.history_peminjaman');

//admin & user
Route::get('/peminjaman', [PeminjamanController::class, 'index'])->middleware('ceksesi')->name('peminjaman.index');

//admin peminjaman
Route::post('/peminjaman/create', [PeminjamanController::class, 'store'])->middleware('ceksesi')->name('peminjaman.store');
Route::get('/peminjaman/show/{id}', [PeminjamanController::class, 'show'])->middleware('ceksesi')->name('peminjaman.show');
Route::get('/peminjaman/update', [PeminjamanController::class, 'update'])->middleware('ceksesi')->name('peminjaman.update');
Route::get('/peminjaman/data', [PeminjamanController::class, 'data_peminjaman'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('peminjaman.data');
Route::get('/peminjaman/data/history', [PeminjamanController::class, 'history_data_peminjaman'])->middleware('ceksesi', 'cekdoubleuserstatus')->name('peminjaman.data-history');
Route::get('/peminjaman/data_history_peminjaman/{id}', [PeminjamanController::class, 'destroy_history'])->middleware('ceksesi')->name('peminjaman.destroy_history');

//user peminjaman
Route::get('/peminjaman/scan_qrcode', [PeminjamanController::class, 'qrcode'])->middleware('ceksesi')->name('peminjaman.qrcode');
Route::get('/peminjaman/history', [PeminjamanController::class, 'history_peminjaman_user'])->middleware('ceksesi')->name('peminjaman.user-history');
