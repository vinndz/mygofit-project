<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;

class Instruktur extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard = "instruktur";
    protected $primaryKey = "ID_INSTRUKTUR";
    protected $table = "instruktur";


    protected $fillable = [
        'NAMA_INSTRUKTUR',
        'ALAMAT_INSTRUKTUR',
        'TELEPON_INSTRUKTUR',
        'TANGGAL_LAHIR_INSTRUKTUR',
        'JUMLAH_TERLAMBAT',
        'TANGGAL_EXPIRED_TERLAMBAT',
        'EMAIL_INSTRUKTUR',
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
