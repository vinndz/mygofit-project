<?php

namespace App\Http\Controllers;
use App\Models\TransaksiDepositUang;
use App\Models\Member;
use App\Models\Promo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransaksiDepositUangController extends Controller
{
    public function index() {
        $transaksiUang = TransaksiDepositUang::orderBy('ID_TRANSAKSI_DEPOSIT_UANG','asc')->paginate(5);
        $member = Member::all();
        $promo = Promo::all();

        return view('transaksi_deposit_uang/transaksideposituang')->with([
            'user' => Auth::guard('pegawai')->user(),
            'transaksiUang' => $transaksiUang, 
            'member' => $member,
            'promo' => $promo
        ]);
    }

    public function cetak($id)
    {
        $transaksiUang = TransaksiDepositUang::where('ID_TRANSAKSI_DEPOSIT_UANG', $id)->first();
        return view('transaksi_deposit_uang/cetakdeposituang')->with([
            'user' => Auth::guard('pegawai')->user(),
            'transaksiUang' => $transaksiUang,
        ]);
    }

    // public function store(Request $request){
    //     $validate = $request->validate([
    //         'ID_MEMBER' => ['required'],
    //         'JUMLAH_DEPOSIT' => ['required','numeric'],
    //     ],[
    //         'ID_MEMBER.required' => 'The member name field is required',
    //         'JUMLAH_DEPOSIT.required' => 'The nominal field is required',
    //         'JUMLAH_DEPOSIT.numeric' => 'Format nominal is numeric'
    //     ]);
        
    //     $member = Member::where('ID_MEMBER',$request->ID_MEMBER)->first();

    //     if($request->JUMLAH_DEPOSIT >= 3000000 && $member->SISA_DEPOSIT_MEMBER >=500000) {
    //         $promo = Promo::where('BONUS',300000)->first();
    //         // $promo = Promo::where('BONUS', 3000000)->first();
    //         if($promo) {
    //             $id_promo = $promo->ID_PROMO;
    //             $bonus_depo= $promo->BONUS;
    //         }else {
    //             $id_promo = null;
    //             $bonus_depo= 0;
    //         }
    //     }else {
    //         $id_promo = null;
    //         $bonus_depo= 0;
    //     }
        
        
    //     if($member->SISA_DEPOSIT_MEMBER) {
    //         $sisa = $member->SISA_DEPOSIT_MEMBER;
    //     }else {
    //         $sisa = 0;
    //     }

        
    //     $depouang = TransaksiDepositUang::create([
    //         'ID_PROMO' => $id_promo,
    //         'ID_MEMBER' => $request->ID_MEMBER,
    //         'ID_PEGAWAI' => Auth::guard('pegawai')->user()->ID_PEGAWAI,
    //         'JUMLAH_DEPOSIT' => $request->JUMLAH_DEPOSIT,
    //         'BONUS_DEPOSIT' => $bonus_depo,
    //         'SISA_DEPOSIT' => $sisa,
    //         'TOTAL_DEPOSIT' => $request->JUMLAH_DEPOSIT + $sisa + $bonus_depo,
    //         'TANGGAL_DEPOSIT_UANG' => Carbon::now(),
    //     ]);

    //     if($depouang){
    //         $member = Member::where('ID_MEMBER',$request->ID_MEMBER)->first();
    //         $member->SISA_DEPOSIT_MEMBER= $request->JUMLAH_DEPOSIT + $sisa + $bonus_depo;
    //         $member->update();
    //         return redirect()->intended('transaksiuang')->with(['success' => 'Success deposit member']);
    //     }else {
    //         return redirect()->intended('transaksiuang')->with(['error' => 'Failed deposit member']);
    //     }
    // }

    public function confirmPaymentDepositUang(Request $request){
        $this->validate($request,[
            'ID_MEMBER' => 'required',
            'JUMLAH_DEPOSIT' => ['required','numeric'],
        ],[
            'ID_MEMBER.required' => 'The member field is required',
            'JUMLAH_DEPOSIT.required' => 'The nominal field is required',
            'JUMLAH_DEPOSIT.numeric' => 'Format nominal is numeric'
        ]);

        $member = member::where('ID_MEMBER',$request->ID_MEMBER)->first();
        
        return view('transaksi_deposit_uang/konfirmasiuang')->with([
            'user' => Auth::guard('pegawai')->user(),
            'member' => $member,
            'jumlah_deposit' => $request->JUMLAH_DEPOSIT
        ]);
    }

    // public function store(Request $request){
    //     $validate = $request->validate([
    //         'ID_MEMBER' => ['required'],
    //         'JUMLAH_DEPOSIT' => ['required','numeric'],
    //         'JUMLAH_UANG' => ['required']
    //     ],[
    //         'ID_MEMBER.required' => 'The member name field is required',
    //         'JUMLAH_DEPOSIT.required' => 'The nominal field is required',
    //         'JUMLAH_DEPOSIT.numeric' => 'Format nominal is numeric',
    //         'JUMLAH_UANG.required' => 'The pay cost field is required'
    //     ]);

    //     $member_check = member::where('ID_MEMBER',$request->ID_MEMBER)->where('MASA_AKTIVASI','!=',null)->where('MASA_AKTIVASi','>=',Carbon::now())->first();

    //     // $member_check = Member::where('ID_MEMBER',$request->ID_MEMBER)->first();
    //     // if($member_check->SISA_DEPOSIT_MEMBER) {
    //     //     $sisa = $member_check->SISA_DEPOSIT_MEMBER;
    //     // }else {
    //     //     $sisa = 0;
    //     // }

    //     if(!($member_check)) {
    //         return redirect()->intended('/transaksiuang')->with(['error' => 'Member not activated. Please activate first']);
    //     }
        
    //     if($request->JUMLAH_DEPOSIT >= 3000000 && $request->SISA_DEPOSIT_MEMBER >=500000) {
    //         $promo = Promo::where('BONUS',300000)->first();
    //         if($promo) {
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
        
    //     if($request->SISA_DEPOSIT_MEMBER) {
    //         $sisa = $request->SISA_DEPOSIT_MEMBER;
    //     }else {
    //         $sisa = 0;
    //     }

    //     if($request->JUMLAH_UANG < $request->JUMLAH_DEPOSIT){
    //         return redirect()->back()->with(['error' => 'Your payment is less']);
    //     }
        
    //     $datadepomoney = TransaksiDepositUang::create([
    //         'ID_PROMO' => $idPromo,
    //         'ID_MEMBER' => $request->ID_MEMBER,
    //         'ID_PEGAWAI' => Auth::guard('pegawai')->user()->ID_PEGAWAI,
    //         'JUMLAH_DEPOSIT' => $request->JUMLAH_DEPOSIT,
    //         'BONUS_DEPOSIT' => $bonus,
    //         'SISA_DEPOSIT' => $sisa,
    //         'TOTAL_DEPOSIT' => $request->JUMLAH_DEPOSIT + $sisa + $bonus,
    //         'TANGGAL_DEPOSIT_UANG' => Carbon::now(),
    //         'KEMBALIAN' => $request->JUMLAH_UANG - $request->JUMLAH_DEPOSIT
    //     ]);

    //     if($datadepomoney){
    //         $member = Member::where('ID_MEMBER',$request->ID_MEMBER)->first();
    //         $member->SISA_DEPOSIT_MEMBER = $request->JUMLAH_DEPOSIT + $sisa + $bonus;
    //         $member->update();
    //         $data = TransaksiDepositUang::latest('ID_TRANSAKSI_DEPOSIT_UANG')->first();
    //         return redirect()->intended('/cetakdeposituang/'.$data->ID_TRANSAKSI_DEPOSIT_UANG);
    //     }else {
    //         return redirect()->intended('/transaksiuang')->with(['error' => 'Failed deposit member']);
    //     }
    // }

    public function store(Request $request){
        $validate = $request->validate([
            'ID_MEMBER' => ['required'],
            'JUMLAH_DEPOSIT' => ['required','numeric'],
            'JUMLAH_UANG' => ['required']
        ],[
            'ID_MEMBER.required' => 'Member tidak boleh kosong',
            'JUMLAH_DEPOSIT.required' => 'Jumlah Deposit Uang tidak boleh kosong',
            'JUMLAH_DEPOSIT.numeric' => 'Format Jumlah Deposit Uang numerik',
            'JUMLAH_UANG.required' => 'Nominal uang pembayaran tidak boleh kosong'
        ]);

        $member_check = member::where('ID_MEMBER',$request->ID_MEMBER)->where('MASA_AKTIVASI','!=',null)->where('MASA_AKTIVASi','>=',Carbon::now())->first();

        if(!($member_check)) {
            return redirect()->intended('/transaksiuang')->with(['error' => 'Member belum melakukan aktivasi']);
        }
        
        // if($request->JUMLAH_DEPOSIT >= 3000000 && $request->SISA_DEPOSIT >=500000) {
        //     $promo = promo::where('BONUS',300000)->first();
        //     if($promo) {
        //         $idPromo = $promo->ID_PROMO;
        //         $bonus = $promo->BONUS;
        //     }else {
        //         $idPromo = null;
        //         $bonus = 0;
        //     }
        // }else {
        //     $idPromo = null;
        //     $bonus = 0;
        // }
        
        $cek_member = Member::where('ID_MEMBER',$request->ID_MEMBER)->first();
        if($cek_member->SISA_DEPOSIT_MEMBER) {
            $sisa = $cek_member->SISA_DEPOSIT_MEMBER;
        }else {
            $sisa = 0;
        }

        if($request->JUMLAH_DEPOSIT >= 3000000 && $cek_member->SISA_DEPOSIT_MEMBER >=500000) {  
            $promo = Promo::where('BONUS',300000)->first();
            if($promo) {
                $idPromo = $promo->ID_PROMO;
                $bonus = $promo->BONUS;
            }
        }else {
            $idPromo = null;
            $bonus = 0;
        }

        if($request->JUMLAH_UANG < $request->JUMLAH_DEPOSIT){
            return redirect()->back()->with(['error' => 'Nominal uang pembayaran tidak mencukupi']);
        }
        
        $datadepomoney = TransaksiDepositUang::create([
            'ID_PROMO' => $idPromo,
            'ID_MEMBER' => $request->ID_MEMBER,
            'ID_PEGAWAI' => Auth::guard('pegawai')->user()->ID_PEGAWAI,
            'JUMLAH_DEPOSIT' => $request->JUMLAH_DEPOSIT,
            'BONUS_DEPOSIT' => $bonus,
            'SISA_DEPOSIT' => $sisa,
            'TOTAL_DEPOSIT' => $request->JUMLAH_DEPOSIT + $sisa + $bonus,
            'TANGGAL_DEPOSIT_UANG' => Carbon::now(),
            'KEMBALIAN' => $request->JUMLAH_UANG - $request->JUMLAH_DEPOSIT
        ]);

        if($datadepomoney){
            $member = Member::where('ID_MEMBER',$request->ID_MEMBER)->first();
            $member->SISA_DEPOSIT_MEMBER = $request->JUMLAH_DEPOSIT + $sisa + $bonus;
            $member->update();
            $data = TransaksiDepositUang::latest('ID_TRANSAKSI_DEPOSIT_UANG')->first();
            return redirect()->intended('/cetakdeposituang/'.$data->ID_TRANSAKSI_DEPOSIT_UANG);
        }else {
            return redirect()->intended('/transaksiuang')->with(['error' => 'Transaksi gagal']);
        }
    }
}
