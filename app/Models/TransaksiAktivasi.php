<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;

class TransaksiAktivasi extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard= "transaksi_aktivasi";
    protected $table = "transaksi_aktivasi";
    protected $primaryKey = "ID_TRANSAKSI_AKTIVASI";
    protected $keyType = "string";

    protected $fillable =[
        'ID_TRANSAKSI_AKTIVASI',
        'ID_MEMBER',
        'ID_PEGAWAI',
        'BIAYA_AKTIVASI',
        'TANGGAL_TRANSAKSI_AKTIVASI',
        'TANGGAL_EXPIRED',
        'STATUS',
        'KEMBALIAN'
    ];


    public function getCreatedAtAttribute()
    {
        if (!is_null($this->attributes["created_at"])) {
            return Carbon::parse($this->attributes["created_at"])->format(
                "Y-m-d H:i:s"
            );
        }
    }

    public function getUpdatedAtAttribute()
    {
        if (!is_null($this->attributes["update_at"])) {
            return Carbon::parse($this->attributes["update_at"])->format(
                "Y-m-d H:i:s"
            );
        }
    }

    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai', 'ID_PEGAWAI');
    }

    public function member()
    {
        return $this->belongsTo('App\Models\Member', 'ID_MEMBER');
    }

}
