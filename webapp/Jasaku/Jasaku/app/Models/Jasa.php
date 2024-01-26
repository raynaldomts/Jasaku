<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jasa extends Model
{
    use HasFactory;

    protected $table = 'jasa';

    public static function latestPaginatedJasa()
    {
        return self::with('getPenjual', 'getKategori')->latest()->paginate(6);
    }

    public static function sortBy($column, $direction)
    {
        return self::with('getPenjual', 'getKategori')->orderBy($column, $direction)->latest()->paginate(6);
    }

    public static function findKerajinanShow($id)
    {
        return self::with('getKategori', 'getPenjual')->find($id);
    }

    public static function findKerajinanEdit($id)
    {
        return self::with('getPenjual')->find($id);
    }

    public static function searchPenjual($search) //tidak digunakan
    {
        return self::where('nama', 'like', '%' . $search . '%')->get();
    }

    public function getKategori()
    {
        return $this->belongsTo('App\Models\KategoriJasa', 'id_kategori', 'id');
    }

    public function getPenjual()
    {
        return $this->belongsTo('App\Models\User', 'id_penjual');
    }

    public function getJasaKeranjang()
    {
        return $this->belongsToMany('App\Models\Keranjang', 'jasa_keranjang', 'id_jasa', 'id_keranjang');
    }

    public function getOrder()
    {
        return $this->belongsTo('App\Models\Order', 'id');
    }
}
