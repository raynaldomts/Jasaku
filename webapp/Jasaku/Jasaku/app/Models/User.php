<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'no_telp',
        'alamat',
        'no_rek',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function KerajinanMilikUser($id_user)
    {
        return self::with('getJasaUser')->find($id_user);
    }

    public function getJasaUser()
    {
        return $this->hasMany('App\Models\Jasa', 'id_penjual', 'id');
    }

    public function getKeranjang()
    {
        return $this->hasOne('App\Models\Keranjang', 'id_pengguna', 'id');
    }

    public function getOrder()
    {
        return $this->hasMany('App\Models\Order', 'id_pengguna', 'id');
    }
}
