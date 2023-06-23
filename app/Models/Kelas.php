<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;


class Kelas extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard ="kelas";
    protected $primaryKey = "ID_KELAS";
    protected $table = "kelas";

    protected $fillable =[
        'NAMA_KELAS',
        'TARIF',
        'KAPASITAS'
    ];
}
