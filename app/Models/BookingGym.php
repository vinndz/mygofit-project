<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BookingGym extends Model
{
    use HasFactory;

    protected $table = 'booking_gym';
    protected $primaryKey = 'KODE_BOOKING_GYM';
    protected $keyType = 'string';

    protected $fillable = [
        'ID_MEMBER',
        'TANGGAL_BOOK_GYM',
        'TANGGAL_MELAKUKAN_BOOK_GYM',
        'STATUS_PRESENSI_GYM',
        'SLOT_WAKTU_GYM',
        'WAKTU_PRESENSI_GYM',
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

    protected function serializeDate(\DateTimeInterface $date){
        return $date->format('Y-m-d H:i:s');
    }

    public function member()
    {
        return $this->belongsTo('App\Models\Member','ID_MEMBER');
    }

}
