<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PresensiIzinInstruktur extends Model
{
    use HasFactory;

    protected $table = "presensi_instruktur";
    protected $primaryKey = "ID_PRESENSI_INSTRUKTUR";
    protected $keyType = "string";

    protected $fillable = [
        "ID_INSTRUKTUR",
        "TANGGAL_MENGAJAR",
        "WAKTU_TERLAMBAT",
        "JAM_MULAI",
        "JAM_SELESAI",
        "DURASI_KELAS",
        
    ];

    public function getCreatedAtAttribute()
    {
        if (!is_null($this->attributes["created_at"])) {
            return Carbon::parse($this->attributes["created_at"])->format(
                "Y-m-d H:i:s"
            );
        }
    }

    public function getUpdateAtAtrribute()
    {
        if (!is_null($this->attributes["updated_at"])) {
            return Carbon::parse($this->attributes["updated_at"])->format(
                "Y-m-d H:i:s"
            );
        }
    }

    public function instruktur()
    {
        return $this->belongsTo("App\Models\Instruktur", "ID_INSTRUKTUR");
    }
}
