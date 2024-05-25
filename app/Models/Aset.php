<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aset extends Model
{
    use HasFactory, Searchable;

    protected $table = 'aset';

    protected $primaryKey = 'id';

    protected $fillable = [
        'kode', 'nama', 'jumlah', 'satuan', 'tanggal_pembelian', 'brand', 'aktif',
        'tempat', 'kondisi', 'gambar', 'nama_penerima', 'deskripsi',
        'kategori_id', 'jenis_pemeliharaan_id', 'ruang_id', 'vendor_id'
    ];

    protected $rules = [
            'nama'                  => 'required|min:3',
            'jumlah'                => 'required',
            'satuan'                => 'required',
            'gambar'                => 'required|mimes:png,jpg,jpeg,jfif',
            'brand'                 => 'required|min:3',
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
}