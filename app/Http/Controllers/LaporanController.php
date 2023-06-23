<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\TransaksiAktivasi;
use App\Models\TransaksiDepositKelas;
use App\Models\TransaksiDepositUang;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function indexPendapatan(){
        return view('Laporan/laporanpendapatan')->with([
            'user' => Auth::guard('pegawai')->user(),
            'data_depo_class' => [],
            'data_activation' => [],
            'data_total_income' => []
        ]);
    }
    
    public function laporanPendapatan(Request $request){
        if($request->accepts('text/html')){
            $validate = $request->validate([
                'year_filter' => ['required']
            ]);
            
            for($x = 0; $x < 12 ; $x++){
                $report_income_deposit[] = DB::select(
                    'SELECT MONTHNAME(t.TANGGAL_DEPOSIT_KELAS) as bulan, SUM(t.jumlah_pembayaran) AS total_income_deposit FROM 
                    (SELECT jumlah_pembayaran, tanggal_deposit_kelas FROM transaksi_deposit_kelas 
                    UNION ALL 
                    SELECT total_deposit, tanggal_deposit_uang FROM transaksi_deposit_uang) t WHERE YEAR(t.TANGGAL_DEPOSIT_KELAS) = '.$request->year_filter.' AND MONTH(t.TANGGAL_DEPOSIT_KELAS) ='.$x.' +1 GROUP BY bulan');

                $report_income_activaton[] = DB::select(
                    'SELECT MONTHNAME(TANGGAL_TRANSAKSI_AKTIVASI) as bulan, SUM(BIAYA_AKTIVASI) as total_income_activation 
                    FROM transaksi_aktivasi 
                    WHERE YEAR(TANGGAL_TRANSAKSI_AKTIVASI) = '.$request->year_filter.' AND MONTH(TANGGAL_TRANSAKSI_AKTIVASI) ='.$x.' + 1 GROUP BY bulan');
                    
                $report_total[] = DB::select(
                    'SELECT MONTHNAME(t.TANGGAL_DEPOSIT_KELAS) as bulan, SUM(t.jumlah_pembayaran) AS total_income FROM 
                    (SELECT jumlah_pembayaran, tanggal_deposit_kelas FROM transaksi_deposit_kelas 
                    UNION ALL 
                    SELECT total_deposit, tanggal_deposit_uang FROM transaksi_deposit_uang
                    UNION ALL
                    SELECT biaya_aktivasi, tanggal_transaksi_aktivasi FROM transaksi_aktivasi ) t WHERE YEAR(t.TANGGAL_DEPOSIT_KELAS) = '.$request->year_filter.' AND MONTH(t.TANGGAL_DEPOSIT_KELAS) ='.$x.' +1 GROUP BY bulan'
                );
            }

            $collection = collect([
                $report_total
            ]);
    
            $collapsed = $collection->collapse();
            $collapsed2 = $collapsed->collapse();

            $temp_keys =['January','February','March','April','May','June','July','August','September','October','November','December'];
            $temp_value = [0,0,0,0,0,0,0,0,0,0,0,0];
            $keys = [];
            $value = [];

            for($i = 0; $i < 12; $i++){
                if($collapsed[$i]){
                    $keys[] = $collapsed[$i][0]->bulan;
                    $value[] = $collapsed[$i][0]->total_income;
                }else{
                    $keys[] = $temp_keys[$i];
                    $value[] = $temp_value[$i];
                }
            }
            
            return redirect()->intended('indexPendapatan')->with([
                'success' => 'Sucessfully Get Report '.$request->year_filter,
                'user' => Auth::guard('pegawai')->user(),
                'data_depo_class' => $report_income_deposit,
                'data_activation' => $report_income_activaton,
                'data_total_income' => $report_total,
                'year'=> $request->year_filter,
                'report_keys'=> $keys,
                'report_value' => $value
            ]);
        }else {
            for($x = 0; $x < 12 ; $x++){
    
                $report_income_deposit[] = DB::select(
                    'SELECT MONTHNAME(t.TANGGAL_DEPOSIT_KELAS) as bulan, SUM(t.jumlah_pembayaran) AS total_income_deposit FROM 
                    (SELECT jumlah_pembayaran, tanggal_deposit_kelas FROM transaksi_deposit_kelas 
                    UNION ALL 
                    SELECT jumlah_deposit, tanggal_deposit_uang FROM transaksi_deposit_uang) t WHERE YEAR(t.TANGGAL_DEPOSIT_KELAS) = 2023 AND MONTH(t.TANGGAL_DEPOSIT_KELAS) ='.$x.' + 1 GROUP BY bulan');

                $report_income_activaton[] = DB::select(
                    'SELECT MONTHNAME(TANGGAL_TRANSAKSI_AKTIVASI) as bulan, SUM(BIAYA_AKTIVASI) as total_income_activation 
                    FROM transaksi_aktivasi 
                    WHERE YEAR(TANGGAL_TRANSAKSI_AKTIVASI) = 2023 AND MONTH(TANGGAL_TRANSAKSI_AKTIVASI) ='.$x.' + 1 GROUP BY bulan');

                $report_total[] = DB::select(
                    'SELECT MONTHNAME(t.TANGGAL_DEPOSIT_KELAS) as bulan, SUM(t.jumlah_pembayaran) AS total_income FROM 
                    (SELECT jumlah_pembayaran, tanggal_deposit_kelas FROM transaksi_deposit_kelas 
                    UNION ALL 
                    SELECT jumlah_deposit, tanggal_deposit_uang FROM transaksi_deposit_uang
                    UNION ALL
                    SELECT biaya_aktivasi, tanggal_transaksi_aktivasi FROM transaksi_aktivasi ) t WHERE YEAR(t.TANGGAL_DEPOSIT_KELAS) = 2023 AND MONTH(t.TANGGAL_DEPOSIT_KELAS) ='.$x.' +1 GROUP BY bulan'
                );
            }

            $report_total2 = DB::select(
                'SELECT MONTHNAME(t.TANGGAL_DEPOSIT_KELAS) as bulan, SUM(t.jumlah_pembayaran) AS total_income FROM 
                (SELECT jumlah_pembayaran, tanggal_deposit_kelas FROM transaksi_deposit_kelas 
                UNION ALL 
                SELECT jumlah_deposit, tanggal_deposit_uang FROM transaksi_deposit_uang
                UNION ALL
                SELECT biaya_aktivasi, tanggal_transaksi_aktivasi FROM transaksi_aktivasi ) t WHERE YEAR(t.TANGGAL_DEPOSIT_KELAS) = 2023 GROUP BY bulan'
            );

            $fruits = collect($report_total)->only('bulan');
            $collapse = $fruits->collapse();
            
            $collection = collect([]);

            $collection = collect([
                $report_total
            ]);
             
            $collapsed = $collection->collapse();
            $collapsed2 = $collapsed->collapse();
             
            foreach ($collapsed2 as $item) {
                    if($item){
                        $temp[] = $item->bulan;
                    }
            }
            $temp_keys =['January','February','March','April','May','June','July','August','September','October','November','December'];
            $temp_value = [0,0,0,0,0,0,0,0,0,0,0,0];
            $keys = [];
            $value = [];

            for($i = 0; $i < 12; $i++){
                if($collapsed[$i]){
                    $keys[] = $collapsed[$i][0]->bulan;
                    $value[] = $collapsed[$i][0]->total_income;
                }else{
                    $keys[] = $temp_keys[$i];
                    $value[] = $temp_value[$i];
                }
            }
            
            return response([
                'data_depo_class' => $report_income_deposit,
                'data_activation' => $report_income_activaton,
                'data_total_income' => $report_total,
                'report_keys'=> $keys,
                'report_values' => $value
            ]);
        }
    }




    public function indexKelas(Request $request){
        if($request->accepts('text/html')){
            return view('Laporan/laporankelas')->with([
                'user' => Auth::guard('pegawai')->user(),
                'data_class_activity' => null,
            ]);
        }
    }

    public function laporanKelas(Request $request){
        if($request->accepts('text/html')){
            $validate = $request->validate([
                'year_filter' => ['required'],
                'month_filter' => ['required']
            ]);
            
            $data_class_activity = DB::select('SELECT k.NAMA_KELAS AS kelas, i.nama_instruktur AS instruktur, 
            SUM(CASE WHEN bk.KODE_BOOKING_KELAS IS NOT NULL THEN 1 ELSE 0 END) AS jumlah_peserta_kelas, 
            SUM(CASE WHEN jh.KETERANGAN = "Libur" THEN 1 ELSE 0 END) AS jumlah_libur 
            FROM kelas as k 
            LEFT JOIN jadwal_umum as ju on ju.ID_KELAS = k.ID_KELAS 
            LEFT JOIN jadwal_harian as jh on ju.ID_JADWAL_UMUM = jh.ID_JADWAL_UMUM 
            LEFT JOIN instruktur AS i ON jh.id_instruktur = i.id_instruktur 
            LEFT JOIN booking_kelas as bk on jh.TANGGAL_JADWAL_HARIAN = bk.TANGGAL_JADWAL_HARIAN 
            WHERE MONTH(jh.tanggal_jadwal_harian) = '.$request->month_filter.' AND YEAR(jh.TANGGAL_JADWAL_HARIAN) = '.$request->year_filter.' GROUP BY k.NAMA_KELAS, i.NAMA_INSTRUKTUR;');

            return redirect()->intended('indexKelas')->with([
                'success' => 'Sucessfully Get Report '.Carbon::now()->month($request->month_filter)->translatedformat('F').' '.$request->year_filter, 
                'user' => Auth::guard('pegawai')->user(),
                'data_class_activity' => $data_class_activity,
                'year' => $request->year_filter,
                'month' => $request->month_filter,
                'print' => 'yes'
            ]);
            
            
        }else{

        }
    }

    public function indexGym(Request $request){
        if($request->accepts('text/html')){
            return view('Laporan/laporangym')->with([
                'user' => Auth::guard('pegawai')->user(),
                'data_gym_activity' => null,
            ]);
        }
    }

    public function laporanGym(Request $request){
        if($request->accepts('text/html')){
            $validate = $request->validate([
                'year_filter' => ['required'],
                'month_filter' => ['required']
            ]);

            $data_gym_activity = DB::select('SELECT TANGGAL_BOOK_GYM as tanggal, COUNT(KODE_BOOKING_GYM) as jumlah_member  FROM `booking_gym` 
            WHERE YEAR(TANGGAL_BOOK_GYM) = '.$request->year_filter.'
            AND STATUS_PRESENSI_GYM = "Hadir"
            AND MONTH(TANGGAL_BOOK_GYM) = '.$request->month_filter.'
            GROUP BY TANGGAL_BOOK_GYM');

            return redirect()->intended('indexGym')->with([
                'success' => 'Sucessfully Get Report '.Carbon::now()->month($request->month_filter)->translatedformat('F').' '.$request->year_filter ,
                'user' => Auth::guard('pegawai')->user(),
                'data_gym_activity' => $data_gym_activity,
                'year' => $request->year_filter,
                'month' => $request->month_filter,
                'print' => 'yes'
            ]);
        }
    }


    public function indexInstruktur(Request $request){
        if($request->accepts('text/html')){
            return view('Laporan/laporaninstruktur')->with([
                'user' => Auth::guard('pegawai')->user(),
                'data_instructor' => null,
            ]);
        }
    }

    public function laporanInstruktur(Request $request){
        if($request->accepts('text/html')){
            $validate = $request->validate([
                'year_filter' => ['required'],
                'month_filter' => ['required']
            ]);

            // $data_instructor = DB::select('SELECT i.nama_instruktur, SUM(CASE WHEN pi.ID_PRESENSI_INSTRUKTUR IS NOT NULL THEN 1 ELSE 0 END) AS jumlah_hadir, SUM(CASE WHEN iz.ID_IZIN_INSTRUKTUR IS NOT NULL THEN 1 ELSE 0 END) AS jumlah_izin, 
            // IFNULL(i.jumlah_terlambat, 0) AS akumulasi_terlambat 
            // FROM instruktur AS i 
            // LEFT JOIN presensi_instruktur AS pi ON i.id_instruktur = pi.id_instruktur 
            // AND MONTH(pi.created_at) = '.$request->month_filter.' AND YEAR(pi.created_at) = '.$request->year_filter.'
            // LEFT JOIN izin_instruktur AS iz ON i.id_instruktur = iz.id_instruktur 
            // AND MONTH(iz.created_at) = '.$request->month_filter.'  AND YEAR(iz.created_at) = '.$request->year_filter.'
            // GROUP BY i.NAMA_INSTRUKTUR, i.jumlah_terlambat
            // ORDER BY i.jumlah_terlambat');

            $data_instructor = DB::select('SELECT i.nama_instruktur, SUM(CASE WHEN pi.ID_PRESENSI_INSTRUKTUR IS NOT NULL THEN 1 ELSE 0 END) AS jumlah_hadir, SUM(CASE WHEN iz.ID_IZIN_INSTRUKTUR IS NOT NULL THEN 1 ELSE 0 END) AS jumlah_izin, 
            SUM(CASE WHEN pi.WAKTU_TERLAMBAT iS NOT NULL THEN pi.WAKTU_TERLAMBAT ELSE 0 END) AS akumulasi_terlambat 
            FROM instruktur AS i 
            LEFT JOIN presensi_instruktur AS pi ON i.id_instruktur = pi.id_instruktur 
            AND MONTH(pi.created_at) = '.$request->month_filter.' AND YEAR(pi.created_at) = '.$request->year_filter.'
            LEFT JOIN izin_instruktur AS iz ON i.id_instruktur = iz.id_instruktur 
            AND MONTH(iz.created_at) = '.$request->month_filter.'  AND YEAR(iz.created_at) = '.$request->year_filter.'
            GROUP BY i.NAMA_INSTRUKTUR, i.jumlah_terlambat
            ORDER BY SUM(CASE WHEN pi.WAKTU_TERLAMBAT iS NOT NULL THEN pi.WAKTU_TERLAMBAT ELSE 0 END) ');

            return redirect()->intended('indexInstruktur')->with([
                'success' => 'Sucessfully Get Report '.Carbon::now()->month($request->month_filter)->translatedformat('F').' '.$request->year_filter ,
                'user' => Auth::guard('pegawai')->user(),
                'data_instructor' => $data_instructor,
                'year' => $request->year_filter,
                'month' => $request->month_filter,
                'print' => 'yes'
            ]);
        }
    }

   
}
