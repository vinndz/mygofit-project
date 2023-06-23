<?php

namespace App\Http\Controllers;

use App\Models\Instruktur;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InstrukturController extends Controller
{
    //
    public function index()
    {
        //Tampilan Awal Instruktur
        $instruktur = instruktur::paginate(5);
        return view("admin/data_instruktur/datainstruktur")->with([
            "user" => Auth::guard("pegawai")->user(),
            "instruktur" => $instruktur,
        ]);
    }


    public function tambahInstruktur()
    {
        //Tampilan Create Member
        return view("admin/data_instruktur/tambahinstruktur")->with([
            "user" => Auth::guard("pegawai")->user(),
        ]);
    }

    public function store(Request $request)
    {

        $dataInstruktur= $request->all();

        $dataInstruktur["password"] = \bcrypt($request->password);


        $instruktur = instruktur::create($dataInstruktur);


        if ($instruktur) {
            return redirect()
                ->intended("/instruktur")
                ->with(["success" => "Successfully added instruktur"]);
        }
        return redirect()
            ->intended("/dashboard")
            ->with(["error" => "Failed added instruktur"]);
    }


    public function update(Request $request, $id)
    {
        //
        $instruktur = instruktur::where("ID_INSTRUKTUR", $id)->first();

        if ($request->NAMA_INSTRUKTUR) {
            $instruktur->NAMA_INSTRUKTUR = $request->NAMA_INSTRUKTUR;
        }

        if ($request->ALAMAT_INSTRUKTUR) {
            $instruktur->ALAMAT_INSTRUKTUR = $request->ALAMAT_INSTRUKTUR;
        }

        if ($request->TELEPON_INSTRUKTUR) {
            $instruktur->TELEPON_INSTRUKTUR = $request->TELEPON_INSTRUKTUR;
        }
        if($request->TANGGAL_LAHIR_INSTRUKTUR){
            $instruktur->TANGGAL_LAHIR_INSTRUKTUR = $request->TANGGAL_LAHIR_INSTRUKTUR;
        }

        if ($request->EMAIL_INSTRUKTUR) {
            $instruktur->EMAIL_INSTRUKTUR = $request->EMAIL_INSTRUKTUR;
        }
        if ($request->password) {
            $instruktur->password = \bcrypt($request->password);
        }

        $instruktur->update();

        if ($instruktur) {
            return redirect()
                ->intended("/instruktur")
                ->with(["success" => "Successfully update instruktur"]);
        }
        return redirect()
            ->intended("/dashboard")
            ->with(["error" => "Failed update instruktur"]);
    }


    public function editPage($id)
    {
        //Mengubah
        $instruktur = instruktur::where("ID_INSTRUKTUR", $id)->first();

        return view("admin/data_instruktur/editinstruktur")->with([
            "user" => Auth::guard("pegawai")->user(),
            "instruktur" => $instruktur,
        ]);
    }

    // public function search(Request $request) {
    //     if($request->search != null) {
    //         $instruktur = instruktur::where('NAMA_INSTRUKTUR',$request->search)->paginate(5);
    //     }
    //     else {
    //         $instruktur = instruktur::orderby('ID_INSTRUKTUR','desc')->paginate(5);
    //     }
        
    //     return view('admin.data_instruktur.datainstruktur')->with([
    //         'user' => Auth::guard('pegawai')->user(),
    //         'instruktur' => $instruktur,
    //     ]);
    // }

    public function search(Request $request) {
        $instruktur = Instruktur::where('NAMA_INSTRUKTUR', 'like' , '%'.$request->search.'%')
        ->orWhere('ALAMAT_INSTRUKTUR',
                    'like' , '%'.$request->search.'%')
        ->orWhere('TELEPON_INSTRUKTUR', 
                    'like' , '%'.$request->search.'%')
        ->orWhere('TANGGAL_LAHIR_INSTRUKTUR', 
                    'like' , '%'.$request->search.'%')
        ->orWhere('EMAIL_INSTRUKTUR', 
                    'like' , '%'.$request->search.'%')
        ->orWhere('JUMLAH_TERLAMBAT', 
                    'like' , '%'.$request->search.'%')
        ->paginate(5);
        $instruktur->appends(['search' => $request->search]);
        // if($request->keyword != null) {
           
        // }
        // else {
        //     $instruktur = Instructor::orderby('ID_INSTRUKTUR','desc')->paginate(5);
        //     // $instruktur->appends(['keyword' => $request->keyword]);
        // }
        
        return view('admin.data_instruktur.datainstruktur')->with([
            'user' => Auth::guard('pegawai')->user(),
            'instruktur' => $instruktur,
        ]);
     }

    public function destroy($id)
    {
        $instruktur = instruktur::where("ID_INSTRUKTUR", $id);

        $instruktur->delete();

        if ($instruktur) {
            return redirect()
                ->intended("/instruktur")
                ->with(["sucesss" => "Member berhasil dihapus"]);
        } else {
            return redirect()
                ->intended("/dashboard")
                ->with(["sucesss" => "Member tidak sberhasil dihapus"]);
        }
    }

    public function ResetIndex()
    {
        $instruktur = Instruktur::all();

        return view("kasir/data_member/resetterlambat")->with([
            'user' => Auth::guard('pegawai')->user(),
            'instruktur' => $instruktur
        ]);
    }

    public function ResetTerlambat()
    {
        $instruktur = Instruktur::all();

        if ($instruktur) {
            if ($instruktur->first()->TANGGAL_EXPIRED_TERLAMBAT < Carbon::now() || $instruktur->first()->TANGGAL_EXPIRED_TERLAMBAT == null) {
                foreach ($instruktur as $item) {
                    $item->JUMLAH_TERLAMBAT = 0;
                    $item->TANGGAL_EXPIRED_TERLAMBAT = Carbon::now()->addMonths(1);
                    $item->update();
                }
                return redirect()->intended('reset')->with(['success' => 'Succesfully reset instruktur late. You can reset again on ' . $item->TANGGAL_EXPIRED_TERLAMBAT]);
            } else {

                return redirect()->intended('reset')->with(['error' => 'Failed reset instructor late. You can reset again on ' . $instruktur->first()->TANGGAL_EXPIRED_TERLAMBAT]);
            }

        }
        return redirect()->intended('reset')->with(['error' => 'Failed reset instructor late']);
    }

    public function getDataInstruktur(Request $request, $id)
    {
        if ($request->expectsjson()) {
       

            $dataInstruktur = Instruktur::where("ID_INSTRUKTUR", $id)->first();

            if ($dataInstruktur) {
                return response(
                    [
                        "message" => "Berhasil mengambil data instruktur",
                        "data" => $dataInstruktur,
                    ],
                    200
                );
            }

            return response(
                [
                    "message" => "Instruktur tidak ditemukan",
                    "data" => null,
                ],
                200
            );
        }
    }

    public function getHistoriAktivitasInstruktur(Request $request, $id)
    {
        if ($request->expectsjson()) {
       
            $dataInstruktur = DB::table("instruktur as i")
            ->select(
                "k.NAMA_KELAS",
                "i.NAMA_INSTRUKTUR",
                "k.TARIF",
                "ju.TANGGAL_JADWAL",
                "ju.HARI_JADWAL",
                "ju.SESI_JADWAL",
                "pi.JAM_MULAI",
                "pi.JAM_SELESAI"
            )
            ->leftjoin("jadwal_umum as ju", "i.ID_INSTRUKTUR", "=", "ju.ID_INSTRUKTUR")
            ->leftjoin("kelas as k", "ju.ID_KELAS", "=", "k.ID_KELAS")
            ->leftjoin("presensi_instruktur as pi", "ju.ID_KELAS", "=", "pi.ID_INSTRUKTUR")
            ->where("i.ID_INSTRUKTUR", $id)
            ->get();
        

            if ($dataInstruktur) {
                return response(
                    [
                        "message" => "Berhasil mengambil data instruktur",
                        "data" => $dataInstruktur,
                    ],
                    200
                );
            }

            return response(
                [
                    "message" => "Instruktur tidak ditemukan",
                    "data" => null,
                ],
                200
            );
        }
    }


}
