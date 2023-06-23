<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiAktivasi;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransaksiAktivasiController extends Controller
{
    //
    public function index() {
        $transaksi = TransaksiAktivasi::orderBy('ID_TRANSAKSI_AKTIVASI','desc')->paginate(5);
        $member = Member::where('MASA_AKTIVASI','<',Carbon::now())->orWhere('MASA_AKTIVASI',null)->get();
        
        return view('kasir/data_member/transaksiaktivasi')->with([
            'user' => Auth::guard('pegawai')->user(),
            'aktivasi' => $transaksi, 
            'members' => $member,
        ]);
    }

    public function cetak($id)
    {
        $transaksi = TransaksiAktivasi::where('ID_TRANSAKSI_AKTIVASI', $id)->first();
        return view('kasir/data_member/cetaktransaksiaktivasi')->with([
            'user' => Auth::guard('pegawai')->user(),
            'aktivasi' => $transaksi,
        ]);
    }

    // public function create(Request $request)
    // {

    //     $this->validate($request, [
    //         'ID_MEMBER' => 'required'
    //     ], [
    //             'ID_MEMBER.required' => 'The member field is required'
    //         ]);

    //     $member = Member::where('ID_MEMBER', $request->ID_MEMBER)->first();
    //     $pegawai = Auth::guard('pegawai')->user();

    //     if ($member) {
    //         $aktivasi_transaksi = TransaksiAktivasi::create([
    //             'ID_MEMBER' => $member->ID_MEMBER,
    //             'ID_PEGAWAI' => $pegawai->ID_PEGAWAI,
    //             'TANGGAL_TRANSAKSI_AKTIVASI' => Carbon::now()->format('Y-m-d H:i:s'),
    //             'TANGGAL_EXPIRED' => Carbon::now()->addYears(1)->format('Y-m-d H:i:s'),
    //             'BIAYA_AKTIVASI' => 3000000,
    //             'STATUS' => "Paid successfully",
    //         ]);

    //         if ($aktivasi_transaksi) {
    //             $member->MASA_AKTIVASI = Carbon::now()->addYears(1)->format('Y-m-d H:i:s');
    //             $member->update();
    //             $data = TransaksiAktivasi::latest('ID_TRANSAKSI_AKTIVASI')->first();
    //             return redirect()->intended('/transaksiaktivasi');
    //         } else {
    //             return redirect()->intended('/transaksiaktivasi')->with(['error' => 'Failed activate member']);
    //         }
    //     } else {
    //         return redirect()->intended('/transaksiaktivasi')->with(['error' => 'Failed activate member']);
    //     }
    // }

    public function confirmPaymentAktivasi(Request $request){
        $this->validate($request,[
            'ID_MEMBER' => 'required'
        ],[
            'ID_MEMBER.required' => 'The member field is required'
        ]);

        $member = member::where('ID_MEMBER',$request->ID_MEMBER)->first();
        
        return view('kasir/data_member/konfirmasiaktivasi')->with([
            'user' => Auth::guard('pegawai')->user(),
            'member' => $member,
        ]);
    }

    public function create(Request $request) {

        $this->validate($request,[
            'ID_MEMBER' => 'required',
            'JUMLAH_UANG' => 'required',
        ],[
            'ID_MEMBER.required' => 'The member field is required',
            'JUMLAH_UANG.required' => 'The pay cost field is required'
        ]);
        
        $member = member::where('ID_MEMBER',$request->ID_MEMBER)->first();
        $pegawai = Auth::guard('pegawai')->user();

        if($request->JUMLAH_UANG < 3000000){
            return redirect()->back()->with(['error' => 'Your payment is less']);
        }
        
        if($member) {
            $activation_transaction = transaksiAktivasi::create([
                'ID_MEMBER' => $member->ID_MEMBER,
                'ID_PEGAWAI' => $pegawai->ID_PEGAWAI,
                'TANGGAL_TRANSAKSI_AKTIVASI' => Carbon::now()->format('Y-m-d H:i:s'),
                'TANGGAL_EXPIRED' => Carbon::now()->addYears(1)->format('Y-m-d H:i:s'),
                'BIAYA_AKTIVASI' => 3000000,
                'STATUS' => "Paid Successfully",
                'KEMBALIAN' => $request->JUMLAH_UANG - 3000000
            ]);
            
            if($activation_transaction) {
                $member->MASA_AKTIVASI = Carbon::now()->addYears(1)->format('Y-m-d H:i:s');
                $member->update();
                $data = transaksiAktivasi::latest('ID_TRANSAKSI_AKTIVASI')->first();
                return redirect()->intended('/cetaktransaksiaktivasi/'.$data->ID_TRANSAKSI_AKTIVASI);
            }else {
                return redirect()->intended('/transaksiAktivasi')->with(['error' => 'Failed activate member']);
            }
        }else {
            return redirect()->intended('/transaksiAktivasi')->with(['error' => 'Failed activate member']);
        }
    }
}
