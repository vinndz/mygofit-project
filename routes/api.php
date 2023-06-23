<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\JadwalHarianController;

use App\Http\Controllers\BookingGymController;
use App\Http\Controllers\PresensiIzinInstrukturController;
use App\Http\Controllers\BookingKelasController;
use App\Http\Controllers\InstrukturController;
//use App\Http\Controllers\IzinController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post("login", "App\Http\Controllers\LoginController@login");
Route::post("reset", "App\Http\Controllers\LoginController@reset_password");
Route::resource('izinInstruktur', \App\Http\Controllers\IzinInstrukturController::class);

    Route::group(   
        ["middleware" => "auth:pegawai-api,member-api,instruktur-api"],
        function () {
            Route::post("logout", "App\Http\Controllers\LoginController@logout");
        }
    );
Route::post("resetpw","App\Http\Controllers\LoginController@gantiPassword");
Route::get('indexApi',"App\Http\Controllers\JadwalHarianController@indexApi");


//BOOKING GYM
Route::get("indexGym/{id}","App\Http\Controllers\BookingGymController@indexBookingGym_mobile");
Route::delete( "batalGym/{id}", "App\Http\Controllers\BookingGymController@batalGym");
Route::post("addBooking","App\Http\Controllers\BookingGymController@storeGym");


//Presensi Instruktur
Route::get("dataPresensi","App\Http\Controllers\PresensiIzinInstrukturController@index_api_presensi");
Route::post("tambahPresensi","App\Http\Controllers\PresensiIzinInstrukturController@store");


Route::get("dataMember/{id}","App\Http\Controllers\MemberController@getDataMember");
Route::get("dataInstruktur/{id}","App\Http\Controllers\InstrukturController@getDataInstruktur");

//BOOKING KELAS
Route::post("addBookKelas", "App\Http\Controllers\BookingKelasController@store");
Route::get("indexKelas/{id}", "App\Http\Controllers\BookingKelasController@getDataBooking");
Route::delete("batalKelas/{id}", "App\Http\Controllers\BookingKelasController@cancelBooking");

//IZIN INSTRUKTUR
Route::post("tambahIzin", "App\Http\Controllers\IzinController@tambahIzin");
Route::get("indexIzin/{id}", "App\Http\Controllers\IzinController@dataInstruktur");
Route::get("jadwal/{id}", "App\Http\Controllers\IzinController@getJadwal");

//HISORY MEMBER
Route::get("indexHistoryMember/{id}", "App\Http\Controllers\BookingKelasController@getHistoryMember");

//HISTORY INSTRUKTUR
Route::get("indexHistoryInstruktur/{id}", "App\Http\Controllers\InstrukturController@getHistoriAktivitasInstruktur");

//Presensi 
Route::get('presensiInstruktur/{id}','App\Http\Controllers\BookingKelasController@index_api_schedule_presence');
    Route::get('presensiMember/{id}','App\Http\Controllers\BookingKelasController@index_api_history_presence');
    Route::post('ubahPresensi','App\Http\Controllers\BookingKelasController@update_transaction');
    