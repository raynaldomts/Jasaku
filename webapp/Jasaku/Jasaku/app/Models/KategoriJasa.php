<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriJasa extends Model
{
    use HasFactory;

    protected $table = 'kategori_jasa';

    public $timestamps = false;

    public static function perKategori($id_kategori)
    {
        return self::with('getJasa')->find($id_kategori);
    }

    public function getJasa()
    {
        return $this->hasMany('App\Models\Jasa', 'id_kategori', 'id');
    }
}
