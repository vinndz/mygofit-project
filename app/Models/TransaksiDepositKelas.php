<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;

class TransaksiDepositKelas extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard= "transaksi_deposit_kelas";
    protected $table = "transaksi_deposit_kelas";
    protected $primaryKey = "ID_TRANSAKSI_PAKET";
    protected $keyType = "string";

    protected $fillable =[
        'ID_MEMBER',
        'ID_PROMO',
        'ID_PEGAWAI',
        'ID_KELAS',
        'JUMLAH_DEPOSIT_KELAS',
        'TANGGAL_DEPOSIT_KELAS',
        'MASA_BERLAKU_KELAS',
        'BONUS_DEPOSIT_KELAS',
        'TOTAL_DEPOSIT_KELAS',
        'JUMLAH_PEMBAYARAN',
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

    public function member()
    {
        return $this->belongsTo('App\Models\Member', 'ID_MEMBER');
    }

    public function promo()
    {
        return $this->belongsTo('App\Models\Promo', 'ID_PROMO');
    }

    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai', 'ID_PEGAWAI');
    }

    public function kelas()
    {
        return $this->belongsTo('App\Models\Kelas', 'ID_KELAS');
    }
}
