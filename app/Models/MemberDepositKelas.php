<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;

class MemberDepositKelas extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard = "member_deposit_kelas";
    protected $primaryKey = "ID_DEPOSIT";
    protected $table = "member_deposit_kelas";

    protected $fillable = [
        'ID_MEMBER',
        'ID_KELAS',
        'SISA_DEPO',
        'MASA_BERLAKU',
        'expired_reset_kelas',
        'SISA_DEPOSIT_KELAS'
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

    public function member()
    {
        return $this->belongsTo('App\Models\Member','ID_MEMBER');
    }

    public function kelas()
    {
        return $this->belongsTo('App\Models\Kelas','ID_KELAS');
    }


}
