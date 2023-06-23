<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;

class JadwalUmum extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard = "jadwal_umum";
    protected $primaryKey = "ID_JADWAL_UMUM";
    protected $table = "jadwal_umum";


    protected $fillable =[
        'ID_KELAS',
        'ID_INSTRUKTUR',
        'SESI_JADWAL',
        'HARI_JADWAL',
        'TANGGAL_JADWAL'
    ];



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

    public function instruktur()
    {
        return $this->belongsTo('App\Models\Instruktur','ID_INSTRUKTUR');
    }

    public function kelas()
    {
        return $this->belongsTo('App\Models\Kelas','ID_KELAS');
    }

}
