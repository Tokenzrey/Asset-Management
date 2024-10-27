<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aset extends Model
{
    use HasFactory, Searchable;

    protected $table = 'aset';

    protected $primaryKey = 'id';

    protected $fillable = [
        'kode', 'nama', 'jumlah', 'satuan', 'tanggal_pembelian', 'brand_id', 'aktif',
        'tempat', 'kondisi', 'gambar', 'nama_penerima', 'deskripsi',
        'kategori_id', 'jenis_pemeliharaan_id', 'ruang_id', 'vendor_id'
    ];

    protected $rules = [
            'nama'                  => 'required|min:3',
            'jumlah'                => 'required',
            'satuan'                => 'required',
            'gambar'                => 'required|mimes:jpg,jpeg,png',
            'brand_id'              => 'required',
            'nama_penerima'         => 'required|min:3',
            'tempat'                => 'required|min:3',
            'kondisi'               => 'required',
            'tanggal_pembelian'     => 'required',
            'kategori_id'           => 'required',
            'jenis_pemeliharaan_id' => 'required',
            'ruang_id'              => 'required',
            'vendor_id'           => 'required'
    ];

    protected $hidden = [];

    public function toSearchableArray(): array
    {
        return [
            'kode' => $this->kode
        ];
    }

    public function kategori(){
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }

    public function jenis_pemeliharaan(){
        return $this->belongsTo(JenisPemeliharaan::class, 'jenis_pemeliharaan_id', 'id');
    }

    public function ruang(){
        return $this->belongsTo(Ruang::class, 'ruang_id', 'id');
    }

    public function vendor(){
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
    }
    public static function generateCode(String $kategori, String $vendor, String $lokasi){
        $latestKode = Aset::where('kode', 'like', '____/'.$kategori.'/'.$vendor.'/'.$lokasi)->latest()->first();
        if($latestKode){
            $kode = explode('/', $latestKode->kode);
            return sprintf('%04d',$kode[0] + 1 ). '/' . $kategori . '/' . $vendor . '/' . $lokasi;
        }else{
            return '0001/' . $kategori . '/' . $vendor . '/' . $lokasi;
        }
    }
    public static function stringToInitial(String $string){
        $initial = '';
        $words = explode(' ', $string);
        foreach($words as $word){
            $initial .= $word[0];
        }
        return $initial;
    }

    public static function getMaintenanceTime($aset){
        $masa_maintenance = Aset::whereHas('kategori', function ($query) {
            $query->where(DB::raw("TIMESTAMPDIFF(YEAR, tanggal_pembelian, NOW())"), '>=', DB::raw('masa_manfaat'));
        })->get();

        foreach ($masa_maintenance as $value) {
            $value->umur = Carbon::parse($value->tanggal_pembelian)->diffInYears(Carbon::now());
            $dataPemeliharaan = JadwalPemeliharaan::latest()
                ->where('aset_id', $value->id)
                ->where('status', 'selesai')
                ->first();

            if ($dataPemeliharaan) {
                $yearDiff = Carbon::parse($dataPemeliharaan->tanggal_selesai)->diffInYears(Carbon::now());
                if ($yearDiff >= $value->kategori->masa_manfaat) {
                    $value->is_maintenance_time = true;
                } else {
                    $value->umur = $yearDiff;
                    $value->is_maintenance_time = false;
                }
            } else {
                $value->is_maintenance_time = true;
            }
        }
        return $masa_maintenance;
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }
}
