<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;

class Member extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard = "member";
    protected $primaryKey = "ID_MEMBER";
    protected $keyType = 'string';
    protected $table = "member";

    protected $fillable = [
        'NAMA_MEMBER',
        'ALAMAT_MEMBER',
        'TELEPON_MEMBER',
        'TANGGAL_LAHIR_MEMBER',
        'SISA_DEPOSIT_MEMBER',
        'SISA_DEPOSIT_KELAS',
        'MASA_AKTIVASI',
        'MASA_EXPIRED',
        'TANGGAL_NONAKTIF',
        'TANGGAL_RESET_KELAS',
        'EMAIL_MEMBER',
        'password'
    ];
    
    // protected $hidden = [
    //     'remember_token',
    // ];

    public function getCreatedAtAttribute() {
        if(!is_null($this->attributes['created_at'])) {
            return Carbon::parse($this->attributes['created_at'])->format('Y-m-d H:i:s');
        }
    }

    public function getUpdateAtAtrribute() {
        if(!is_null($this->attributes['update_at'])) {
            return Carbon::parse($this->attributes['update_at'])->format('Y-m-d H:i:s');
        }
    }
}
