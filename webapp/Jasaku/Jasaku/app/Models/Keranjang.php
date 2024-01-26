<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $table = 'keranjang';

    protected $fillable = [
        'id_pengguna',
    ];

    public $timestamps = false;

    public function getUserKeranjang()
    {
        return $this->belongsTo('App\Models\User', 'id_pengguna', 'id');
    }

    public function getKeranjangJasa()
    {
        return $this->belongsToMany('App\Models\Jasa', 'jasa_keranjang', 'id_keranjang', 'id_jasa')->withTimestamps();
    }
}
