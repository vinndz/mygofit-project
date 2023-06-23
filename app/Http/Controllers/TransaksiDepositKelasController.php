<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiDepositKelas;
use App\Models\Member;
use App\Models\Promo;
use App\Models\MemberDepositKelas;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransaksiDepositKelasController extends Controller
{
    public function index() {
        $transaksiKelas = TransaksiDepositKelas::orderBy('ID_TRANSAKSI_PAKET','asc')->paginate(5);
        $member = Member::all();
        $promo = Promo::all();
        $kelas = Kelas::all();

        return view('transaksi_deposit_kelas/transaksidepositkelas')->with([
            'user' => Auth::guard('pegawai')->user(),
            'transaksiKelas' => $transaksiKelas, 
            'member' => $member,
            'promo' => $promo,
            'kelas' => $kelas
        ]);
    }

    public function cetak($id)
    {
        $transaksiKelas = TransaksiDepositKelas::where('ID_TRANSAKSI_PAKET', $id)->first();
        return view('transaksi_deposit_kelas/cetakdepositkelas')->with([
            'user' => Auth::guard('pegawai')->user(),
            'transaksiKelas' => $transaksiKelas,
        ]);
    }

    // public function store(Request $request){
    //     $validate = $request->validate([
    //         'ID_MEMBER' => ['required'],
    //         'ID_KELAS' => ['required'],
    //         'JUMLAH_DEPOSIT_KELAS' => ['required','numeric'],
    //     ],[
    //         'ID_MEMBER.required' => 'The member name field is required',
    //         'ID_KELAS.required' => 'The kelas name field is required',
    //         'JUMLAH_DEPOSIT_KELAS.required' => 'The packet field is required',
    //         'JUMLAH_DEPOSIT_KELAS.numeric' => 'Format packet is numeric'
    //     ]);

    //     $depokelas = TransaksiDepositKelas::where('ID_MEMBER',$request->ID_MEMBER)->orderby('ID_TRANSAKSI_PAKET','desc')->first();
    //     $member = Member::where('ID_MEMBER',$request->ID_MEMBER)->first();

    //     if($member) {
    //         if($member->MASA_BERLAKU_KELAS < Carbon::now() && $member->SISA_DEPOSIT_KELAS != 0 || $member->MASA_BERLAKU_KELAS > Carbon::now() && $member->SISA_DEPOSIT_KELAS == 0 || $member->MASA_BERLAKU_KELAS < Carbon::now() && $member->SISA_DEPOSIT_KELAS == 0 ) {
    //             $member->SISA_DEPOSIT_KELAS = 0;
    //             $member->update();
    //         }else {
    //             return redirect()->intended('transaksikelas')->with(['error' => 'Member cant deposit before expired date or remaining deposit = 0']);
    //         }
    //     }

    //     $member_cekaktif = Member::where('ID_MEMBER',$request->ID_MEMBER)->where('MASA_AKTIVASI','!=',null)->where('MASA_AKTIVASi','>=',Carbon::now())->first();
    //     if(!($member_cekaktif)) {
    //         return redirect()->intended('transaksikelas')->with(['error' => 'Member not activated. Please activate first']);
    //     }

    //     $member_deposit = MemberDepositKelas::where('ID_MEMBER',$request->ID_MEMBER)->where('ID_KELAS',$request->ID_KELAS)->first();
    //     if($member_deposit){
    //         if($member_deposit->MASA_BERLAKU < Carbon::now() && $member_deposit->SISA_DEPO != 0 || $member_deposit->MASA_BERLAKU > Carbon::now() && $member_deposit->SISA_DEPO == 0 || $member_deposit->MASA_BERLAKU < Carbon::now() && $member_deposit->SISA_DEPO == 0) {
    //             $member_deposit->SISA_DEPO = 0;
    //             $member_deposit->MASA_BERLAKU = null;
    //             $member_deposit->update();
    //         }else {
    //             return redirect()->intended('transaksikelas')->with(['error' => 'This member has been deposit this class. Member cant deposit before expired date or remaining deposit = 0']);
    //         }
    //     }
        
    //     if($request->JUMLAH_DEPOSIT_KELAS == 5 || $request->JUMLAH_DEPOSIT_KELAS == 10 ) {
    //         $promo = Promo::where('MINIMAL_PEMBELIAN',$request->JUMLAH_DEPOSIT_KELAS)->first();
    //         if($promo) {
    //             if($promo->MINIMAL_PEMBELIAN == 5) {
    //                 $month = 1;
    //             }else {
    //                 $month=2;
    //             }
    //             $idPromo = $promo->ID_PROMO;
    //             $bonus = $promo->BONUS;
    //         }else {
    //             $idPromo = null;
    //             $bonus = 0;
    //         }
    //     }else {
    //         $idPromo = null;
    //         $bonus = 0;
    //     }

    //     $kelas = Kelas::where('ID_KELAS',$request->ID_KELAS)->first();

    //     $depokelas = TransaksiDepositKelas::create([
    //         'ID_MEMBER' => $request->ID_MEMBER,
    //         'ID_PROMO' => $idPromo,
    //         'ID_PEGAWAI' => Auth::guard('pegawai')->user()->ID_PEGAWAI,
    //         'ID_KELAS' => $request->ID_KELAS,
    //         'JUMLAH_DEPOSIT_KELAS'=> $request->JUMLAH_DEPOSIT_KELAS,
    //         'TANGGAL_DEPOSIT_KELAS' => Carbon::now(),
    //         'BONUS_DEPOSIT_KELAS' => $bonus,
    //         'TOTAL_DEPOSIT_KELAS' => $request->JUMLAH_DEPOSIT_KELAS + $bonus,
    //         'JUMLAH_PEMBAYARAN'=> $kelas->TARIF * $request->JUMLAH_DEPOSIT_KELAS,
    //         'MASA_BERLAKU_KELAS' => Carbon::now()->addMonths($month),
    //     ]);

    //     if($depokelas){
    //         $member_depo2 = MemberDepositKelas::where('ID_MEMBER',$request->ID_MEMBER)->first();

    //         if($member_depo2){
    //             $member_depo2->DEPO_SISA = $request->JUMLAH_DEPOSIT_KELAS + $bonus;
    //             $member_depo2->MASA_BERLAKU = Carbon::now()->addMonths($month);
    //             $member_depo2->update();
            
    //     }else{
    //         $member_deposit_buat = MemberDepositKelas::create([
    //             'ID_MEMBER'=>$request->ID_MEMBER,
    //             'ID_KELAS'=> $request->ID_KELAS,
    //             'SISA_DEPO'=> $request->JUMLAH_DEPOSIT_KELAS + $bonus,
    //             'MASA_BERLAKU'=> Carbon::now()->addMonths($month),
    //         ]);
    //         }
    //         $data = TransaksiDepositKelas::latest('ID_TRANSAKSI_PAKET')->first();
    //         return redirect()->intended('transaksikelas')->with(['success' => 'Success deposit member']);
    //     }
    // }
    public function confirmPaymentDepositKelas(Request $request){
        $this->validate($request,[
            'ID_MEMBER' => ['required'],
            'ID_KELAS' => ['required'],
            'JUMLAH_DEPOSIT_KELAS' => ['required','numeric'],
        ],[
            'ID_MEMBER.required' => 'The member name field is required',
            'ID_KELAS.required' => 'The kelas name field is required',
            'JUMLAH_DEPOSIT_KELAS.required' => 'The packet field is required',
            'JUMLAH_DEPOSIT_KELAS.numeric' => 'Format packet is numeric'
        ]);

        $member = member::where('ID_MEMBER',$request->ID_MEMBER)->first();
        $kelas = kelas::where('ID_KELAS',$request->ID_KELAS)->first();
        
        $member_deposit = memberDepositKelas::where('ID_MEMBER',$request->ID_MEMBER)->where('ID_KELAS',$request->ID_KELAS)->first();
        if($member_deposit){
            if($member_deposit->MASA_BERLAKU < Carbon::now() && $member_deposit->SISA_DEPO != 0 || $member_deposit->MASA_BERLAKU > Carbon::now() && $member_deposit->SISA_DEPO == 0 || $member_deposit->MASA_BERLAKU < Carbon::now() && $member_deposit->SISA_DEPO == 0) {
                
            }else {
                return redirect()->intended('transaksikelas')->with(['error' => 'This member has been deposit this class. Member cant deposit before expired date or remaining deposit = 0']);
            }
        }
        return view('transaksi_deposit_kelas/konfirmasikelas')->with([
            'user' => Auth::guard('pegawai')->user(),
            'member' => $member,
            'ID_KELAS' => $request->ID_KELAS,
            'NAMA_KELAS' => $kelas->NAMA_KELAS,
            'JUMLAH_DEPOSIT_KELAS' => $request->JUMLAH_DEPOSIT_KELAS,
            'BIAYA' => $request->JUMLAH_DEPOSIT_KELAS * $kelas->TARIF
        ]);
    }

    public function store(Request $request){
        $validate = $request->validate([
            'ID_MEMBER' => ['required'],
            'ID_KELAS' => ['required'],
            'JUMLAH_DEPOSIT_KELAS' => ['required','numeric'],
            'JUMLAH_UANG' => ['required']
        ],[
            'ID_MEMBER.required' => 'The member name field is required',
            'ID_KELAS.required' => 'The kelas name field is required',
            'JUMLAH_DEPOSIT_KELAS.required' => 'The packet field is required',
            'JUMLAH_DEPOSIT_KELAS.numeric' => 'Format packet is numeric',
            'JUMLAH_UANG.required' => 'The pay cost field is required'
        ]);

        $datadepoclass = transaksiDepositKelas::where('ID_MEMBER',$request->ID_MEMBER)->orderby('ID_TRANSAKSI_PAKET','desc')->first();
        
        $member_check_activate = member::where('ID_MEMBER',$request->ID_MEMBER)->where('MASA_AKTIVASI','!=',null)->where('MASA_AKTIVASi','>=',Carbon::now())->first();
        if(!($member_check_activate)) {
            return redirect()->intended('/transaksikelas')->with(['error' => 'Member not activated. Please activate first']);
        }

        $member_deposit = memberDepositKelas::where('ID_MEMBER',$request->ID_MEMBER)->where('ID_KELAS',$request->ID_KELAS)->first();
                if($member_deposit){
            if($member_deposit->MASA_BERLAKU < Carbon::now() && $member_deposit->SISA_DEPO != 0 || $member_deposit->MASA_BERLAKU > Carbon::now() && $member_deposit->SISA_DEPO == 0 || $member_deposit->MASA_BERLAKU < Carbon::now() && $member_deposit->SISA_DEPO == 0) {
                $member_deposit->SISA_DEPO = 0;
                $member_deposit->MASA_BERLAKU = null;
                $member_deposit->update();
            }else {
                return redirect()->intended('transaksikelas')->with(['error' => 'This member has been deposit this class. Member cant deposit before expired date or remaining deposit = 0']);
            }
        }
        // if($member_deposit){
        //     if($member_deposit->MASA_BERLAKU < Carbon::now() && $member_deposit->SISA_DEPO != 0 || 
        //     $member_deposit->MASA_BERLAKU > Carbon::now() && $member_deposit->SISA_DEPO == 0 || 
        //     $member_deposit->MASA_BERLAKU < Carbon::now() && $member_deposit->SISA_DEPO == 0) {
        //         $member_deposit->SISA_DEPO = 0;
        //         $member_deposit->MASA_BERLAKU = null;
        //         $member_deposit->update();
        //     }else {
        //         return redirect()->intended('/transaksikelas')->with(['error' => 'This member has been deposit this class. Member cant deposit before expired date or remaining deposit = 0']);
        //     }
        // }

        
        if($request->JUMLAH_DEPOSIT_KELAS == 5 || $request->JUMLAH_DEPOSIT_KELAS == 10 ) {
            $promo = promo::where('MINIMAL_PEMBELIAN',$request->JUMLAH_DEPOSIT_KELAS)->first();
            if($promo) {
                if($promo->MINIMAL_PEMBELIAN == 5) {
                    $month = 1;
                }else {
                    $month=2;
                }
                $idPromo = $promo->ID_PROMO;
                $bonus = $promo->BONUS;
            }else {
                $idPromo = null;
                $bonus = 0;
            }
        }else {
            $idPromo = null;
            $bonus = 0;
        }

        $kelas = kelas::where('ID_KELAS',$request->ID_KELAS)->first();

        if($request->JUMLAH_UANG < ($kelas->TARIF * $request->JUMLAH_DEPOSIT_KELAS)){
            return redirect()->back()->with(['error' => 'Your money is less']);
        }

        $datadepoclass = transaksiDepositKelas::create([
            'ID_MEMBER' => $request->ID_MEMBER,
            'ID_PROMO' => $idPromo,
            'ID_PEGAWAI' => Auth::guard('pegawai')->user()->ID_PEGAWAI,
            'ID_KELAS' => $request->ID_KELAS,
            'JUMLAH_DEPOSIT_KELAS'=> $request->JUMLAH_DEPOSIT_KELAS,
            'TANGGAL_DEPOSIT_KELAS' => Carbon::now(),
            'BONUS_DEPOSIT_KELAS' => $bonus,
            'TOTAL_DEPOSIT_KELAS' => $request->JUMLAH_DEPOSIT_KELAS + $bonus,
            'JUMLAH_PEMBAYARAN'=> $kelas->TARIF * $request->JUMLAH_DEPOSIT_KELAS,
            'MASA_BERLAKU_KELAS' => Carbon::now()->addMonths($month),
            'KEMBALIAN' => $request->JUMLAH_UANG - ($kelas->TARIF * $request->JUMLAH_DEPOSIT_KELAS)
        ]);

        if($datadepoclass){
            $member_deposit2 = memberDepositKelas::where('ID_MEMBER',$request->ID_MEMBER)->where('ID_KELAS',$request->ID_KELAS)->first();

            if($member_deposit2){
                $member_deposit2->SISA_DEPO = $request->JUMLAH_DEPOSIT_KELAS + $bonus;
                $member_deposit2->MASA_BERLAKU = Carbon::now()->addMonths($month);
                $member_deposit2->update();
            }else {
                $member_deposit_create = memberDepositKelas::create([
                    'ID_MEMBER'=>$request->ID_MEMBER,
                    'ID_KELAS'=> $request->ID_KELAS,
                    'SISA_DEPO'=> $request->JUMLAH_DEPOSIT_KELAS + $bonus,
                    'MASA_BERLAKU'=> Carbon::now()->addMonths($month),
                ]);
            }

            $data = transaksiDepositKelas::latest('ID_TRANSAKSI_PAKET')->first();

            return redirect()->intended('/cetakdepositkelas/'.$data->ID_TRANSAKSI_PAKET);
            
        }else {
            return redirect()->intended('/transaksikelas')->with(['error' => 'Failed deposit member']);
        }
    }
}
