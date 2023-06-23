<?php

namespace App\Http\Controllers;

use App\Models\Member;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\MemberDepositKelas;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Tampilan Awal Member
        // $member = member::all();
        $member = member::paginate(5);
        return view("kasir/data_member/datamember")->with([
            "user" => Auth::guard("pegawai")->user(),
            "member" => $member,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tambahMember()
    {
        //Tampilan Create Member
        return view("kasir/data_member/tambahmember")->with([
            "user" => Auth::guard("pegawai")->user(),
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Memasukkan data
        // Session::flash("NAMA_MEMBER", $request->NAMA_MEMBER);
        // Session::flash("ALAMAT_MEMBER", $request->ALAMAT_MEMBER);
        // Session::flash("TELEPON_MEMBER", $request->NO_TELEPON_MEMBER);
        // Session::flash("USIA_MEMBER", $request->USIA_MEMBER);
        
        // Session::flash("JENIS_KELAMIN_MEMBER", $request->JENIS_KELAMIN_MEMBER);
        // Session::flash("EMAIL_MEMBER", $request->EMAIL_MEMBER);
        // Session::flash("password", $request->password);

        $validate = $request->validate(
            [
                // "NAMA_MEMBER" => ["required"],
                // "NO_TELEPON_MEMBER" => ["required"],
                // "USIA_MEMBER" => ["required"],
                // "ALAMAT_MEMBER" => ["required"],
                // "JENIS_KELAMIN_MEMBER" => ["required"],
                // "MASA_AKTIVASI" => ["required"],
                // "SISA_DEPOSIT_MEMBER" => ["required"],
                // "SISA_DEPOSIT_KELAS" => ["required"],
                // "EMAIL_MEMBER" => ["required"],
                // "password" => ["required"],
            ],
            [
            ]
        );

        $dataMember = $request->all();

        $dataMember["password"] = \bcrypt($request->password);
        $dataMember["MASA_AKTIVASI"] = null;
        $dataMember["SISA_DEPOSIT_MEMBER"] = null;
        $dataMember["SISA_DEPOSIT_KELAS"] = null;

        $member = Member::create($dataMember);
        // $member = Member::create();

        if ($member) {
            return redirect()
                ->intended("/member")
                ->with(["success" => "Successfully added member"]);
        }
        return redirect()
            ->intended("/dashboard")
            ->with(["error" => "Failed added member"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function editPage()
    // {
    //     //Tampilan Edit Member
    //     return view("kasir/data_member/editmember")->with([
    //         "user" => Auth::guard("pegawai")->user(),
    //     ]);
    // }


    public function editPage($id)
    {
        //Mengubah
        $member = member::where("ID_MEMBER", $id)->first();

        return view("kasir.data_member.editmember")->with([
            "user" => Auth::guard("pegawai")->user(),
            "member" => $member,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $member = member::where("ID_MEMBER", $id)->first();

        if ($request->NAMA_MEMBER) {
            $member->NAMA_MEMBER = $request->NAMA_MEMBER;
        }

        if ($request->ALAMAT_MEMBER) {
            $member->ALAMAT_MEMBER = $request->ALAMAT_MEMBER;
        }

        if ($request->TELEPON_MEMBER) {
            $member->TELEPON_MEMBER = $request->TELEPON_MEMBER;
        }
        if($request->TANGGAL_LAHIR_MEMBER){
            $member->TANGGAL_LAHIR_MEMBER = $request->TANGGAL_LAHIR_MEMBER;
        }

        if ($request->EMAIL_MEMBER) {
            $member->EMAIL_MEMBER = $request->EMAIL_MEMBER;
        }
        if ($request->password) {
            $member->password = \bcrypt($request->password);
        }

        $member->update();

        if ($member) {
            return redirect()
                ->intended("/member")
                ->with(["success" => "Successfully update member"]);
        }
        return redirect()
            ->intended("/dashboard")
            ->with(["error" => "Failed update member"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $member = member::where("ID_MEMBER", $id);

        $member->delete();

        if ($member) {
            return redirect()
                ->intended("/member")
                ->with(["sucesss" => "Member berhasil dihapus"]);
        } else {
            return redirect()
                ->intended("/dashboard")
                ->with(["sucesss" => "Member tidak sberhasil dihapus"]);
        }
    }

    public function cetakMember($id)
    {
        $member = member::where("ID_MEMBER", $id)->first();

        return view("kasir/data_member/cetakmember")->with([
            "member" => $member,
        ]);
        
    }

    // public function search(Request $request) {
    //     if($request->search != null) {
    //         $member = member::where('NAMA_MEMBER',$request->search)->paginate(5);
    //     }
    //     else {
    //         $member = member::orderby('ID_MEMBER','desc')->paginate(5);
    //     }
        
    //     return view('kasir.data_member.datamember')->with([
    //         'user' => Auth::guard('pegawai')->user(),
    //         'member' => $member,
    //     ]);
    // }

    public function search(Request $request) {
        $member = Member::where('NAMA_MEMBER', 'like','%'.$request->search.'%')
        ->orWhere('EMAIL_MEMBER', 'like','%'.$request->search.'%')
        ->orWhere('ALAMAT_MEMBER', 'like','%'.$request->search.'%')
        ->orWhere('TANGGAL_LAHIR_MEMBER', 'like','%'.$request->search.'%')
        ->orWhere('TELEPON_MEMBER', 'like','%'.$request->search.'%')
        ->orWhere('MASA_AKTIVASI', 'like','%'.$request->search.'%')
        ->orWhere('SISA_DEPOSIT_MEMBER', 'like','%'.$request->search.'%')
        ->orWhere('ID_MEMBER', 'like','%'.$request->search.'%')
        ->paginate(5);
        $member->appends(['search' => $request->search]);
    
    return view('kasir.data_member.datamember')->with([
        'user' => Auth::guard('pegawai')->user(),
        'member' => $member,
    ]);
}


    public function reset($id){
        $member = member::where('ID_MEMBER',$id)->first();

        $member_update = member::where('ID_MEMBER', $id)
        ->limit(1) 
        ->update(array('password' => bcrypt($member->TANGGAL_LAHIR_MEMBER))); 

        if($member_update) {
            return redirect()->intended('/member')->with([
                'success' => 'Member has been successfully reset password using DOB Member (yyyy-mm-dd)'
            ]);
        }else {
            return redirect()->intended('/dashboard')->with([
                'success' => 'Member not reset password successfully'
            ]);
        }
    }

    public function DeaktivasiIndex(){
        $member = member::orderby('ID_MEMBER','desc')->where('MASA_AKTIVASI','<',Carbon::now())->get();

        return view("kasir/data_member/deaktivasimember")->with ([
            'user'=> Auth::guard('pegawai')->user(),
            'member'=> $member
        ]);
    }

    public function DeaktivasiMember(){

     $member = member::where("MASA_AKTIVASI","<",Carbon::now())->get();
        if($member){     
                foreach($member as $item){
                    $item->MASA_AKTIVASI = null;
                    $item->SISA_DEPOSIT_KELAS = 0;
                    $item->SISA_DEPOSIT_MEMBER = 0;
                    $item->MASA_EXPIRED = null;
                    $item->TANGGAL_NONAKTIF = Carbon::now()->addDays(1);
                    $item->update();
                }
                return redirect()->intended('/deaktivasi')->with(['success' => 'Sucessfully deactive member']);
            

        }
        return redirect()->intended('/deaktivasi')->with(['error' => 'Failed deactive member']);
    }

    public function ResetIndex(){
        $member = MemberDepositKelas::orderby('ID_DEPOSIT','desc')->where('MASA_BERLAKU','<',Carbon::now())->paginate(5);
        $member_setelah = MemberDepositKelas::orderby('ID_DEPOSIT','desc')->where('MASA_BERLAKU',null)->paginate(5);
        
        return view('kasir/data_member/resetkelas')->with([
            'user' => Auth::guard('pegawai')->user(),
            'members' => $member,
            'members_setelah' => $member_setelah
        ]);
        
    }

    public function ResetKelas(){
        $members = MemberDepositKelas::orderby('ID_DEPOSIT','desc')->where('MASA_BERLAKU','<',Carbon::now())->get();
        if($members){
            foreach($members as $member){
                if($member->expired_reset_kelas < Carbon::now() || $member && $member->expired_reset_kelas == null ){
                    $member->SISA_DEPO = 0;
                    $member->MASA_BERLAKU = null;
                    $member->expired_reset_kelas = Carbon::now()->addDays(1);
                    $member->update();
                }else {
                    return redirect()->intended('resetkelas')->with(['error' => 'Failed reset class member '.$member->member->NAMA_MEMBER.' class '.$member->kelas->NAMA_KELAS.' because you can deactive this member tomorrow']);
                }
            }
            return redirect()->intended('resetkelas')->with(['success' => 'Sucessfully reset class packet']);
        }
        return redirect()->intended('resetkelas')->with(['error' => 'Member not found']);
    }



    public function getDataMember(Request $request, $id)
    {
        if ($request->expectsjson()) {


            $members = DB::select(
                'SELECT m.ID_MEMBER, m.NAMA_MEMBER, m.EMAIL_MEMBER, m.MASA_AKTIVASI, m.SISA_DEPOSIT_MEMBER, md.SISA_DEPO FROM member m LEFT JOIN member_deposit_kelas md ON m.ID_MEMBER = md.ID_MEMBER  WHERE m.ID_MEMBER = "' .
                    $id .
                    '" GROUP BY m.NAMA_MEMBER, md.SISA_DEPO '
            );

            if ($members) {
                return response(
                    [
                        "message" => "Berhasil mengambil data member",
                        "data" => $members,
                    ],
                    200
                );
            }

            return response(
                [
                    "message" => "Member tidak ditemukan",
                    "data" => null,
                ],
                200
            );
        }
    }
}