<?php

namespace App\Http\Controllers;
use App\Models\JadwalHarian;
use App\Models\JadwalUmum;
use App\Models\Kelas;
use App\Models\Instruktur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class JadwalHarianController extends Controller
{
    // INDEX
    // public function index()
    // {
    //     $jadwal = JadwalHarian::orderBy('TANGGAL_JADWAL_HARIAN', 'asc')->get();
    //     $tanggal_jadwal = JadwalHarian::first();

    //     return view('manager/jadwalharian')->with([
    //         'user' => Auth::guard('pegawai')->user(),
    //         'jadwals' => $jadwal,
    //         'hari_jadwal' => $tanggal_jadwal,

    //     ]);
    // }

    public function index(){
        $jadwalHarian = JadwalHarian::where('TANGGAL_EXPIRED','>=',Carbon::now()->format('Y-m-d'))->orderBy('TANGGAL_JADWAL_HARIAN','asc')->get();
        // $tgljadwalHarian = JadwalHarian::first();
        $tgljadwalHarian = JadwalHarian::where('TANGGAL_EXPIRED','>=',Carbon::now()->format('Y-m-d'))->first();

        return view("manager/jadwalharian")->with ([
            'user' => Auth::guard('pegawai')->user(),
            'jadwals' => $jadwalHarian,
            'hari_jadwal' => $tgljadwalHarian,
        ]);
    }


    public function edit($id){
        $jadwalHarian = JadwalHarian::where('TANGGAL_JADWAL_HARIAN',$id)->first();
        $instruktur = Instruktur::all();

        return view('manager/editjadwalharian')->with([
            'user' => Auth::guard('pegawai')->user(),
            'jadwalHarian' => $jadwalHarian,
            'instruktur' => $instruktur
        ]);
    }

    public function update(Request $request,$id) {
        $jadwalHarian = JadwalHarian::where('TANGGAL_JADWAL_HARIAN',$id)->first();
        
        if($request->ID_INSTRUKTUR){
            $jadwalHarian->ID_INSTRUKTUR = $request->ID_INSTRUKTUR;
        }
        if($request->KETERANGAN) {
            $jadwalHarian->KETERANGAN = $request->KETERANGAN;
        }
        $jadwalHarianNew = $jadwalHarian->update();
        
        if($jadwalHarianNew) {
            return redirect()->intended('/jadwalharian')->with(['success' => 'Succesfully update daily schedule']);
        }
        return redirect()->intended('/jadwalharian')->with(['error' => 'Failed update daily schedule']);
        
    }


    public function destroy($id)
    {
        $jadwal = JadwalHarian::where('ID_JADWAL_UMUM', $id);

        $jadwal->delete();

        if ($jadwal) {
            return redirect()->intended('/jadwalharian')->with([
                'success' => 'Schedule has been successfully deleted'
            ]);
        } else {
            return redirect()->intended('/jadwalharian')->with([
                'error' => 'Schedule not deleted successfully'
            ]);
        }
    }


    // public function atur()
    // {
    //     $jadwal_umum = JadwalUmum::all();
    //     $tanggaljadwal = JadwalHarian::first();

    //     $cekJadwal = JadwalHarian::where('TANGGAL_EXPIRED', '>=', Carbon::now())->first();

    //     if (JadwalHarian::exists() || $cekJadwal) {
    //         return redirect()->intended('/jadwalharian')->with(['error' => 'Daily schedule has been generated. You can generate again on the date after ' . $tanggaljadwal->TANGGAL_EXPIRED]);
    //     } else {
    //    //     JadwalHarian::truncate();

    //         for ($i = Carbon::now(); $i <= Carbon::now()->addDays(6); $i->modify('+1 day')) {
    //             $day = Carbon::createFromFormat('Y-m-d H:i:s', $i)->format('l');
    //             foreach ($jadwal_umum as $item) {
    //                 if ($day == $item->HARI_JADWAL) {
    //                     $harian = JadwalHarian::create([
    //                         'TANGGAL_JADWAL_HARIAN' => $i->format('Y-m-d') . ' ' . $item->SESI_JADWAL,
    //                         'ID_INSTRUKTUR' => $item->ID_INSTRUKTUR,
    //                         'ID_JADWAL_UMUM' => $item->ID_JADWAL_UMUM,
    //                         'KETERANGAN' => '-',
    //                         'TANGGAL_EXPIRED' => Carbon::now()->addDays(6)->format('Y-m-d H:i:s'),
    //                     ]);
    //                 }
    //             }
    //         }
    //         return redirect()->intended('/jadwalharian')->with(['success' => 'Succesfully generate daily schedule']);
    //     }
    // }

    public function atur(){
        $jadwal_umum = JadwalUmum::all();
        // $tgljadwalHarian = JadwalHarian::where('expired','>=',Carbon::now())->first();

        $cekJadwal = JadwalHarian::where('TANGGAL_EXPIRED', '>=' ,Carbon::now()->format('Y-m-d'))->latest('TANGGAL_EXPIRED')->first();

        if($cekJadwal) {
            return redirect()->intended('/jadwalharian')->with(['error' => 'Jadwal Harian sudah digenerate, dapat generate lagi pada '. $tanggaljadwal->TANGGAL_EXPIRED ]);
        }else {     
            // JadwalHarian::truncate();
            $TANGGAL_EXPIRED = Carbon::now()->addDays(6)->format('Y-m-d H:i:s');
            for($i=Carbon::now();$i<=Carbon::now()->addDays(6);$i->modify('+1 day')){
                $day = Carbon::createFromFormat('Y-m-d H:i:s', $i)->format('l');
                foreach($jadwal_umum as $item){
                    if($day == $item->HARI_JADWAL){
                        $harian = JadwalHarian::create([
                            'TANGGAL_JADWAL_HARIAN' => $i->format('Y-m-d').' '.$item->SESI_JADWAL,
                            'ID_INSTRUKTUR' => $item->ID_INSTRUKTUR,
                            'ID_JADWAL_UMUM' => $item->ID_JADWAL_UMUM,
                            'KETERANGAN' => '-',
                            'TANGGAL_EXPIRED' => $TANGGAL_EXPIRED,
                        ]);
                    }
                }
            }
            return redirect()->intended('/jadwalharian')->with(['success' => 'Berhasil men-generate jadwal harian']);
        }
    }

    // public function search(Request $request){
    //     $tanggal_jadwal = JadwalHarian::first();
    //     if($request->search != null) {
    //         $instruktur = Instruktur::where('NAMA_INSTRUKTUR',$request->search)->first();
    //         $kelas = Kelas::where('NAMA_KELAS',$request->search)->first();
    //         if($instruktur) {
    //             $jadwal_harian = JadwalHarian::where('ID_INSTRUKTUR',$instruktur->ID_INSTRUKTUR)->get();
    //         }else if($kelas){
    //             $jadwal_umum = JadwalUmum::where('ID_KELAS',$kelas->ID_KELAS)->first();
    //             $jadwal_harian = JadwalHarian::where('ID_JADWAL_UMUM',$jadwal_umum->ID_JADWAL_UMUM)->get();
    //         }else {
    //             $jadwal_harian = JadwalHarian::where('TANGGAL_JADWAL_HARIAN',$request->search)->orWhere('KETERANGAN',$request->search)->get();
    //         }
    //     }
    //     else {
    //         $jadwal_harian = JadwalHarian::orderby('TANGGAL_JADWAL_HARIAN','asc')->get();
    //     }
        
    //     return view('manager/jadwalharian')->with([
    //         'user' => Auth::guard('pegawai')->user(),
    //         'jadwals' => $jadwal_harian,
    //         'hari_jadwal' => $tanggal_jadwal
    //     ]);
    // }

    public function search(Request $request){
        // $tanggal = JadwalHarian::where('expired','<=',Carbon::now());
        $tanggal_jadwal = JadwalHarian::where('TANGGAL_EXPIRED','>=',Carbon::now())->first();
        if($request->search != null) {
            $instruktur = Instruktur::where('NAMA_INSTRUKTUR',$request->search)->first();
            $kelas = Kelas::where('NAMA_KELAS',$request->search)->first();
            if($instruktur) {
                // $jadwalHarian = JadwalHarian::where('TANGGAL_JADWAL_HARIAN',$request->search)->orWhere('ID_INSTRUKTUR',$instruktur->ID_INSTRUKTUR)->orWhere('ID_JADWAL_UMUM',$jadwal->ID_JADWAL_UMUM)->orWhere('KETERANGAN',$request->search);
                $jadwal_harian = JadwalHarian::where('ID_INSTRUKTUR',$instruktur->ID_INSTRUKTUR)->where('TANGGAL_EXPIRED',$tanggal_jadwal->TANGGAL_EXPIRED)->get();
            }
            else if($kelas){
                //MASIH AMBIGU
                $jadwal = Jadwal::where('ID_KELAS',$kelas->ID_KELAS)->get();
                $jadwal_harian = JadwalHarian::whereIn('ID_JADWAL_UMUM',$jadwal->pluck('ID_JADWAL_UMUM'))->where('TANGGAL_EXPIRED',$tanggal_jadwal->TANGGAL_EXPIRED)->get();
                // $jadwal_harian = DB::select('SELECT * from jadwal_harian jh 
                // join jadwal_umum ju ON (jh.ID_JADWAL_UMUM = ju.ID_JADWAL_UMUM) 
                // join kelas k on (ju.ID_KELAS = k.ID_KELAS)
                // where k.NAMA_KELAS LIKE "%'.$kelas->NAMA_KELAS.'%"
                // ');
            }else {
                $jadwal_harian = JadwalHarian::where('TANGGAL_JADWAL_HARIAN','like','%'.$request->search.'%')
                ->where('TANGGAL_EXPIRED',$tanggal_jadwal->TANGGAL_EXPIRED)
                ->orWhere('KETERANGAN','like','%'.$request->search.'%')
                ->where('TANGGAL_EXPIRED',$tanggal_jadwal->TANGGAL_EXPIRED)
                ->get();
            }
        }
        else {
            $jadwal_harian = JadwalHarian::orderby('TANGGAL_JADWAL_HARIAN','asc')->where('expired',$tanggal_jadwal->TANGGAL_EXPIRED)->get();
        }
        
        return view('manager/jadwalharian')->with([
            'user' => Auth::guard('pegawai')->user(),
            'jadwals' => $jadwal_harian,
            'hari_jadwal' => $tanggal_jadwal
        ]);
    }

    public function indexApi(Request $request){
        if($request->expectsjson()){
            $jadwalHarian = DB::table('jadwal_harian as jh')
            ->select('jh.TANGGAL_JADWAL_HARIAN','i.NAMA_INSTRUKTUR','k.NAMA_KELAS','ju.ID_KELAS','jh.KETERANGAN','ju.HARI_JADWAL', 'k.TARIF')
            ->join('instruktur as i','jh.ID_INSTRUKTUR','i.ID_INSTRUKTUR')
            ->join('jadwal_umum as ju','jh.ID_JADWAL_UMUM','ju.ID_JADWAL_UMUM')
            ->join('kelas as k','ju.ID_KELAS','k.ID_KELAS')
            ->orderby('jh.TANGGAL_JADWAL_HARIAN','asc')->get();
            if($jadwalHarian){
                return response([
                    'message' => 'Successfully get data schedule',
                    'data' => $jadwalHarian,
                ],200);
            }
            return response([
                'message' => 'Successfully get data permission',
                'data' => null,
            ],400);
        }
    }

}
