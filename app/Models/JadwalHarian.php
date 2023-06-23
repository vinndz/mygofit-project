<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;

class JadwalHarian extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard= "jadwal_harian";
    protected $table = "jadwal_harian";
    protected $primaryKey = "TANGGAL_JADWAL_HARIAN";
    protected $keyType = "datetime";

    protected $fillable =[
        'TANGGAL_JADWAL_HARIAN',
        'ID_INSTRUKTUR',
        'ID_JADWAL_UMUM',
        'KETERANGAN',
        'TANGGAL_EXPIRED'
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
        if (!is_null($this->attributes["updated_at"])) {
            return Carbon::parse($this->attributes["updated_at"])->format(
                "Y-m-d H:i:s"
            );
        }
    }

    
    public function instruktur()
    {
        return $this->belongsTo('App\Models\Instruktur','ID_INSTRUKTUR');
    }

    public function jadwal()
    {
        return $this->belongsTo('App\Models\JadwalUmum','ID_JADWAL_UMUM');
    }

    protected function serializeDate(\DateTimeInterface $date){
        return $date->format('Y-m-d H:i:s');
    }

}   
