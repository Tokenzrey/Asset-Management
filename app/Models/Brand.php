<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brand';
    protected $fillable = ['name'];

    public function aset()
    {
        return $this->hasMany(Aset::class, 'brand_id', 'id');
    }
}
