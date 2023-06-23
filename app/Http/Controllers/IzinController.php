<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Izin;
use App\Models\Instruktur;
use App\Models\JadwalHarian;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class IzinController extends Controller
{
    //
    public function index()
    {
        $izin = Izin::all();
        return view("manager/izininstruktur")->with([
            "user" => Auth::guard("pegawai")->user(),
            "izins" => $izin,
        ]);
    }

    public function edit($id)
    {
        //
        $izin = Izin::where("ID_IZIN_INSTRUKTUR", $id)->first();
        $instruktur = Instruktur::all();

        return view("manager/izininstruktur")->with([
            "user" => Auth::guard("pegawai")->user(),
            "izins" => $izin,
            "instruktur" => $instruktur,
        ]);
    }

    // public function update(Request $request, $id)
    // {
    //     //
    //     // $instruktur = Instruktur::where(
    //     //     "ID_INSTRUKTUR",
    //     //     $request->ID_INSTRUKTUR
    //     // )->first();

    //     $izin = Izin::where("ID_IZIN_INSTRUKTUR", $id)->first();

    //     if ($izin->STATUS_IZIN==null) {
    //         $izin->STATUS_IZIN = "Konfirmasi";
    //         $izin->TANGGAL_KONFIRMASI = Carbon::now()->format("Y-m-d");

    //     }

    //     // if ($izin->TANGGAL_KONFIRMASI) {
    //     //     $izin->TANGGAL_KONFIRMASI = Carbon::now()->format("Y-m-d");
    //     // }

    //     $updateIzin = $izin->update();

    //     if ($updateIzin) {
    //         return redirect()
    //             ->intended("/izin")
    //             ->with(["success" => "Berhasil mengkonfirmasi izin instruktur"]);
    //     }
    // }

    public function update($id)
    {
        $izin = Izin::orderby('ID_IZIN_INSTRUKTUR','desc')->where('ID_IZIN_INSTRUKTUR',$id)->first();

        if($izin){
            $izin->TANGGAL_KONFIRMASI = Carbon::now();
            $izin->STATUS_IZIN = 'Konfirmasi';

            $jadwalHarian = JadwalHarian::where("TANGGAL_JADWAL_HARIAN",$izin->TANGGAL_IZIN_INSTRUKTUR)->first();

            if($jadwalHarian) {
                if($izin->NAMA_INSTRUKTUR_PENGGANTI){

                    $instruktur = Instruktur::where('NAMA_INSTRUKTUR',$izin->NAMA_INSTRUKTUR_PENGGANTI)->first();
                    $instruktur2 = Instruktur::where('ID_INSTRUKTUR',$jadwalHarian->ID_INSTRUKTUR)->first();

                    if($instruktur) {
                        $jadwalHarian->ID_INSTRUKTUR = $instruktur->ID_INSTRUKTUR;
                        $jadwalHarian->KETERANGAN = "Menggantikan ".$instruktur2->NAMA_INSTRUKTUR;
                    }
                }else {
                    $jadwalHarian->KETERANGAN = 'Libur';
                } 
                $jadwalHarian->update();
            }
            $izin->update();
            return redirect()->intended('/izin')->with(['success' => 'Sucessfully Confirmation']);
        }
        return redirect()->intended('/izin')->with(['error' => 'Failed Confirmation']);
    }

    public function store(Request $request)
    {
        if ($request->expectsJson()) {
            $validate = Validator::make($request->all(), [
                'ID_INSTRUKTUR' => ['required'],
                'TANGGAL_MENGAJAR' => ['required'],
            ]);

            if ($validate->fails()) {
                return response(['success' => false, 'message' => $validate->errors()], 400);
            }

            $attendace = Izin::where('TANGGAL_MENGAJAR', $request->TANGGAL_MENGAJAR)->where('ID_INSTRUKTUR', $request->ID_INSTRUKTUR)->first();

            if ($attendace) {
                if ($attendace->JAM_SELESAI == null) {
                    $attendace->JAM_SELESAI = Carbon::now()->format('H:i:s');
                    $attendace->update();
                    return response([
                        'message' => 'Succesfully Update Finish Class',
                        'data' => $attendace,
                    ], 200);
                } else {
                    return response([
                        'message' => 'You have been Update Start and Finish Class',
                        'data' => null,
                    ], 400);
                }

            } else {

                if ($request->TANGGAL_MENGAJAR > Carbon::now()) {
                    $temp_mulai = Carbon::parse($request->TANGGAL_MENGAJAR)->format("H:i:s");
                    $temp_late = 0;
                } else {
                    $temp_late = Carbon::now()->diffInSeconds(Carbon::parse($request->TANGGAL_MENGAJAR));
                    $temp_mulai = Carbon::parse(Carbon::now()->format('H:i:s'));
                    $instructor = Instruktur::where('ID_INSTRUKTUR', $request->ID_INSTRUKTUR)->first();
                    if ($instructor) {
                        $instructor->JUMLAH_TERLAMBAT += $temp_late;
                        $instructor->update();
                    }
                }

                $store_data = Izin::create([
                    'ID_INSTRUKTUR' => $request->ID_INSTRUKTUR,
                    'TANGGAL_MENGAJAR' => $request->TANGGAL_MENGAJAR,
                    'WAKTU_TERLAMBAT' => $temp_late,
                    'JAM_MULAI' => $temp_mulai,
                    'JAM_SELESAI' => null,
                    'DURASI_KELAS' => "2 jam",
                ]);

                if ($store_data) {
                    return response([
                        'message' => 'Succesfully Update Start Class',
                        'data' => $store_data,
                    ], 200);
                } else {
                    return response([
                        'message' => 'Failed Update Start Class',
                        'data' => null,
                    ], 400);
                }
            }
        }
    }

    public function tambahIzin(Request $request)
    {
        if ($request->expectsJson()) {
            $validate = Validator::make($request->all(), [
                'ID_INSTRUKTUR' => ['required'],
                'TANGGAL_IZIN_INSTRUKTUR' => ['required'],
                'KETERANGAN_IZIN' => ['required'],
            ]);

            if ($validate->fails()) {
                return response(['success' => false, 'message' => $validate->errors()], 400);
            }

            if ($request->NAMA_INSTRUKTUR_PENGGANTI) {
                $instructor = Instruktur::where('NAMA_INSTRUKTUR', $request->NAMA_INSTRUKTUR_PENGGANTI)->first();
                if ($instructor) {
                    $temp_instructor = $instructor->NAMA_INSTRUKTUR;
                } else {
                    return response([
                        'message' => 'Instruktur  Not Found',
                        'data' => null,
                    ], 400);
                }
            } else {
                $temp_instructor = null;
            }

            $check = Izin::where('TANGGAL_IZIN_INSTRUKTUR', $request->TANGGAL_IZIN_INSTRUKTUR)->exists();

            if ($check) {
                return response([
                    'message' => 'You have been create permission on this date',
                    'data' => null,
                ], 400);
            }

            $store_data = Izin::create([
                'ID_INSTRUKTUR' => $request->ID_INSTRUKTUR,
                'NAMA_INSTRUKTUR_PENGGANTI' => $temp_instructor,
                'TANGGAL_IZIN_INSTRUKTUR' => $request->TANGGAL_IZIN_INSTRUKTUR,
                'KETERANGAN_IZIN' => $request->KETERANGAN_IZIN,
                'TANGGAL_MELAKUKAN_IZIN' => Carbon::now(),
                'STATUS_IZIN' => null,
                'TANGGAL_KONFIRMASI' => null,
            ]);

            if ($store_data) {
                return response([
                    'message' => 'Successfully added permission',
                    'data' => $store_data,
                ], 200);
            }
            return response([
                'message' => 'Failed added permission',
                'data' => null,
            ], 400);
        }
    }

    public function dataInstruktur(Request $request, $id)
    {
        if ($request->expectsjson()) {
            $permission = Izin::where('ID_INSTRUKTUR', $id)->get();
            if ($permission) {
                return response([
                    'message' => 'Successfully get data permission',
                    'data' => $permission,
                ], 200);
            }
            return response([
                'message' => 'Failed get data permission',
                'data' => null,
            ], 200);
        }
    }

    public function getJadwal(Request $request, $id)
    {
        if ($request->expectsjson()) {
            $schedule = JadwalHarian::where("ID_INSTRUKTUR", $id)
                ->where("TANGGAL_JADWAL_HARIAN", ">", Carbon::now())
                ->get();
            if ($schedule) {
                return response(
                    [
                        "message" => "Successfully get data permission",
                        "data" => $schedule,
                    ],
                    200
                );
            }
            return response(
                [
                    "message" => "Failed get data permission",
                    "data" => null,
                ],
                200
            );
        }
    }
}
