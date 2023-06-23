<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookingGym;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class BookingGymController extends Controller
{
    public function index(Request $request){
        if($request->accepts('text/html')){
            $booking_gym = BookingGym::orderBy('KODE_BOOKING_GYM','desc')->where('STATUS_PRESENSI_GYM',null)->paginate(20);
            $booking_gym_setelah = BookingGym::orderBy('KODE_BOOKING_GYM','desc')->where('STATUS_PRESENSI_GYM','!=',null)->paginate(20);

            return view('booking_gym/bookinggym')->with([
                'user' => Auth::guard('pegawai')->user(),
                'booking_gym' => $booking_gym,
                'booking_gym_setelah' => $booking_gym_setelah, 
            ]);            
        }
    }

    public function storeGym(Request $request){
        if($request->expectsJson()){
            $validate = Validator::make($request->all(),
            [
                'ID_MEMBER' => ['required'],
                'SLOT_WAKTU_GYM' => ['required'],
                'TANGGAL_BOOK_GYM' => ['required'],
            ]);
    
            if($validate->fails()) {
                return response(['success' => false,'message' => $validate->errors()],400);   
            }

            if($request->TANGGAL_BOOK_GYM < Carbon::now()->format('Y-m-d')){
                return response([
                    'message' => 'please input date more than or same date now ',
                    'data' => null,
                ], 400);
            }

            $member = Member::where('ID_MEMBER',$request->ID_MEMBER)->first();

            if($member->MASA_AKTIVASI == null || $member->MASA_AKTIVASI < Carbon::now()){
                return response([
                    'message' => 'You not activated ',
                    'data' => null,
                ], 400);
            }

            $check_duplicate = BookingGym::where('ID_MEMBER',$request->ID_MEMBER)->where('TANGGAL_BOOK_GYM',$request->TANGGAL_BOOK_GYM)->first();
            if($check_duplicate) {
                return response([
                    'message' => 'You have been booking this class',
                    'data' => null,
                ], 400);
            }

            $check = BookingGym::where('SLOT_WAKTU_GYM',$request->SLOT_WAKTU_GYM)->where('TANGGAL_BOOK_GYM',$request->TANGGAL_BOOK_GYM)->count();

            if($check <= 10){
                $store_data = BookingGym::create([
                    'ID_MEMBER' => $request->ID_MEMBER,
                    'SLOT_WAKTU_GYM' => $request->SLOT_WAKTU_GYM,
                    'TANGGAL_BOOK_GYM' => $request->TANGGAL_BOOK_GYM,
                    'TANGGAL_MELAKUKAN_BOOK_GYM' => Carbon::now(),
                    'WAKTU_PRESENSI_GYM' => null,
                    'STATUS_PRESENSI_GYM' => null,
                ]);
                
                if($store_data){
                    return response([
                        'message' => 'Succesfully create booking gym',
                        'data' => $store_data,
                        // 'data_depo' => $member_deposit
                    ], 200);
                }else {
                    return response([
                        'message' => 'Failed create store booking gym',
                        'data' => null,
                    ], 400);
                }
            }else {
                return response([
                    'message' => 'Class Gym Full',
                    'data' => null,
                ], 400);
            }
        }
    }

    public function konfirmasi_gym(Request $request,$id){
        if($request->accepts('text/html')){
            $booking = BookingGym::where('KODE_BOOKING_GYM',$id)->first();
            if($booking){
                $booking->WAKTU_PRESENSI_GYM = Carbon::now();
                $booking->STATUS_PRESENSI_GYM = 'Hadir';
                $booking->update();
                return redirect()->intended('presensigym')->with(['success' => 'Successfully confirm booking gym']);
            }
            return redirect()->intended('presensigym')->with(['error' => 'Failed confirm booking gym']);
        }
    }

    public function cetakBookingGym($id){
        $presensies = BookingGym::where('KODE_BOOKING_GYM',$id)->first();
        return view('booking_gym/cetakbookinggym')->with([
            'user' => Auth::guard('pegawai')->user(),
            'bookings' => $presensies,
        ]);
    }

    

    public function batalGym($id){
        $booking = bookingGym::where('KODE_BOOKING_GYM',$id)->first();

        if($booking){
            if(Carbon::now()->format('Y-m-d') <= Carbon::parse($booking->TANGGAL_BOOK_GYM)->subDays(1)){
                $booking->delete();
                return response([
                    'message' => 'Succesfully cancel booking',
                    'data' => $booking,
                ], 200);
            }else {
                return response([
                    'message' => 'You can cancel booking class max h-1 day',
                    'data' => null,
                ], 400); 
            }
        }
        return response([
            'message' => 'Failed cancel booking',
            'data' => null,
        ], 400);
    }


    public function indexBookingGym_mobile($id)
    {
        $bookingGym = bookingGym::where("ID_MEMBER", $id)->get();

        if ($bookingGym) {
            return response(
                [
                    "message" => "Success to get all data",
                    "data" => $bookingGym,
                ],
                200
            );
        }
        return response(
            [
                "message" => "Failed to get all data",
                "data" => null,
            ],
            200
        );
    }

    
}
