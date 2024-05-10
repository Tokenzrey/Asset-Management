<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    protected $table = 'kategori';

    protected $primaryKey = 'id';
    protected $fillable = ['nama', 'aktif'];

    protected $hidden = [];

    public function aset()
    {
        return $this->hasMany(Aset::class, 'kategori_id', 'id');
    }
}
