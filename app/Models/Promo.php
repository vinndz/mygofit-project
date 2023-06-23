<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;

class Promo extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard= "promo";
    protected $table = "promo";
    protected $primaryKey = "ID_PROMO";
    protected $keyType = "string";

    protected $fillable =[
        'NAMA_PROMO',
        'TANGGAL_MULAI_PROMO',
        'TANGGAL_BATAS_PROMO',
        'JENIS_PROMO',
        'KETERANGAN_PROMO',
        'MINIMAL_PEMBELIAN',
        'BONUS'
    ];

}
