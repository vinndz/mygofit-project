<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalUmum;
use App\Models\Instruktur;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;

class JadwalUmumController extends Controller
{
    public function index() {
        $kelas = Kelas::all();
        $jadwalUmum = JadwalUmum::orderBy('SESI_JADWAL','asc')->get();

        return view('manager/jadwalumum')->with([
            'user' => Auth::guard('pegawai')->user(),
            // 'kelas' => $kelas,
            'jadwalUmum' => $jadwalUmum
        ]);
    }

    public function tambahJadwalUmum(){
        $kelas = Kelas::all();
        $instruktur = Instruktur::all();
        return view('manager/tambahjadwalumum')->with([
            'user' => Auth::guard('pegawai')->user(),
            'kelas' => $kelas,
            'instruktur' => $instruktur
        ]);
    }

    public function store(Request $request){
        $validate = $request->validate([
            'ID_KELAS' => ['required', 'numeric'],
            'ID_INSTRUKTUR' => ['required','numeric'],
            'HARI_JADWAL' => ['required'],
            'SESI_JADWAL' => ['required','date_format:H:i:s'],
        //    'TANGGAL_JADWAL' => ['required','date_format:Y-m-d']
        ],[
            'ID_KELAS.required' => 'The kelas field is required',
            'ID_INSTRUKTUR.required' => 'The instructor field is required',
            'HARI_JADWAL' => 'The day field is required',
            'SESI_JADWAL' => 'The time field is required'
        ]);

        $datajadwal= $request->all();

        //cek apakah jadwal instruktur bertabrakan
        $jadwal_check = JadwalUmum::where('ID_INSTRUKTUR',$request->ID_INSTRUKTUR)->where('HARI_JADWAL',$request->HARI_JADWAL)->where('SESI_JADWAl',$request->SESI_JADWAL)->first();

        if($jadwal_check) {
            return redirect()->intended('/tambahjadwalumum')->with(['error' => 'Instruktur sudah di jadwalkan']);
        }else {
            $jadwalUmum = JadwalUmum::create($datajadwal);

            if($jadwalUmum) {
                return redirect()->intended('/jadwalumum')->with(['success' => 'Successfully added Schedule']);
            }
            return redirect()->intended('/tambahjadwalumum')->with(['error' => 'Failed added Schedule']);
        }
    }

    public function edit($id){
        $jadwal = JadwalUmum::where('ID_JADWAL_UMUM',$id)->first();
        $kelas = Kelas::all();
        $instruktur = Instruktur::all();

        return view('manager/editjadwalumum')->with([
            'user' => Auth::guard('pegawai')->user(),
            'jadwal' => $jadwal,
            'kelas' => $kelas,
            'instruktur' => $instruktur
        ]);
    }

    public function update(Request $request,$id) {
        $jadwal = JadwalUmum::find($id);
        $temp = JadwalUmum::find($id);

        if($request->ID_KELAS != $temp->ID_KELAS && $request->ID_INSTRUKTUR == $temp->ID_INSTRUKTUR && $request->HARI_JADWAL == $temp->HARI_JADWAL && $request->SESI_JADWAL == $temp->SESI_JADWAL) {
            $jadwal->ID_KELAS = $request->ID_KELAS;
            $jadwal->update();
            if($jadwal) {
                return redirect()->intended('/jadwalumum')->with(['success' => 'Successfully update schedule']);
            }
            return redirect()->intended('editjadwalumum/'.$id)->with(['error' => 'Failed update schedule']);
        }
        if($request->ID_INSTRUKTUR){
            $jadwal->ID_INSTRUKTUR = $request->ID_INSTRUKTUR;
        }
        if($request->HARI_JADWAL){
            $jadwal->HARI_JADWAL = $request->HARI_JADWAL;
        }
        if($request->SESI_JADWAL){
            $jadwal->SESI_JADWAL = $request->SESI_JADWAL;
        }
        

        $schedule_check = JadwalUmum::where('ID_INSTRUKTUR',$request->ID_INSTRUKTUR)->where('HARI_JADWAL',$request->HARI_JADWAL)->where('SESI_JADWAL',$request->SESI_JADWAL)->first();

        if($schedule_check) {
            return redirect()->intended('editjadwalumumpage/'.$id)->with(['error' =>'Instructor has been scheduled']);
        }else {
            $jadwal->ID_KELAS = $request->ID_KELAS;
            $schedule_update = $jadwal->update();

            if($schedule_update) {
                return redirect()->intended('/jadwalumum')->with(['success' => 'Successfully update schedule']);
            }
            return redirect()->intended('editjadwalumum/'.$id)->with(['error' => 'Failed update schedule']);
        }
        
    }

    public function destroy($id) {
        $schedule = JadwalUmum::find($id);

        $schedule->delete();

        if($schedule) {
            return redirect()->intended('/jadwalumum')->with([
                'success' => 'Schedule has been successfully deleted'
            ]);
        }else {
            return redirect()->intended('/jadwalumum')->with([
                'error' => 'Schedule not deleted successfully'
            ]);
        }
        try {
        
         } catch ( \Exception $e) {
              var_dump($e->errorInfo );
         }
    }


}
