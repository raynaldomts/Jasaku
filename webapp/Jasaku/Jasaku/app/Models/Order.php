<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    public static function getOrderKonsumen($id_user)
    {
        return self::select(DB::raw("COUNT(orders.id) as count"))
        ->join('jasa_tangan', 'jasa_tangan.id', '=', 'orders.id_jasa')
        ->whereYear('orders.waktu_dibuat', date('Y'))
        ->where('jasa_tangan.id_penjual', $id_user)
        ->groupBy(DB::raw('MONTH(orders.waktu_dibuat)'))
        ->pluck('count');
    }

    public static function getOrderAdmin()
    {
        return self::select(DB::raw("COUNT(id) as count"))
        ->whereYear('waktu_dibuat', date('Y'))
        ->groupBy(DB::raw('MONTH(waktu_dibuat)'))
        ->pluck('count');
    }

    public static function getMonth()
    {
        return self::select(DB::raw("Month(orders.waktu_dibuat) as month"))
        ->whereYear('orders.waktu_dibuat',date('Y'))
        ->groupBy(DB::raw("Month(orders.waktu_dibuat)"))
        ->pluck('month');
    }

    public static function getOrderPenjualExcel()
    {
        return self::whereHas('getJasa', function($query){
            $query->where('id_penjual', '=', Auth::user()->id);
        })->get();
    }

    public function getPengguna()
    {
        return $this->belongsTo('App\Models\User', 'id_pengguna', 'id');
    }

    public function getJasa()
    {
        return $this->hasOne('App\Models\Jasa', 'id', 'id_jasa');
    }
}
