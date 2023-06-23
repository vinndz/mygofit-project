<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Izin extends Model
{
    use HasFactory;

    protected $guard ="izin_instruktur";
    protected $primaryKey = "ID_IZIN_INSTRUKTUR";
    protected $table = "izin_instruktur";

    protected $fillable =[
        'ID_INSTRUKTUR',
        'TANGGAL_IZIN_INSTRUKTUR',
        'TANGGAL_KONFIRMASI',
        'TANGGAL_MELAKUKAN_IZIN',
        'STATUS_IZIN',
        'KETERANGAN_IZIN',
        'NAMA_INSTRUKTUR_PENGGANTI'
    ];

    public function getCreatedAtAttribute() {
        if(!is_null($this->attributes['created_at'])) {
            return Carbon::parse($this->attributes['created_at'])->format('Y-m-d H:i:s');
        }
    }

    public function getUpdateAtAtrribute() {
        if(!is_null($this->attributes['updated_at'])) {
            return Carbon::parse($this->attributes['updated_at'])->format('Y-m-d H:i:s');
        }
    }

    public function instruktur()
    {
        return $this->belongsTo('App\Models\Instruktur','ID_INSTRUKTUR');
    }
    

}
