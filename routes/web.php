<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\InstrukturController;
use App\Http\Controllers\JadwalUmumController;
use App\Http\Controllers\JadwalHarianController;
use App\Http\Controllers\TransaksiAktivasiController;
use App\Http\Controllers\TransaksiDepositKelasController;
use App\Http\Controllers\TransaksiDepositUangController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\BookingKelasController;
use App\Http\Controllers\BookingGymController;
use App\Http\Controllers\LaporanController;



Route::get("/", [LoginController::class, "index"]);
Route::post("login", [LoginController::class,"login"]);
Route::get("logout", [LoginController::class,"logout"]);
Route::get("dashboard", [DashboardController::class, "index"]);

//ubah pw
Route::get("/indexReset", [LoginController::class, "indexUbahPw"]);
Route::post("/ubahpw", [LoginController::class, "storeForgotPassword"]);


//Member
Route::get("/member", [MemberController::class, "index"]);
Route::get("/tambahmember", [MemberController::class, "tambahMember"]);
Route::post("/storeMember", [MemberController::class, "store"]);

Route::put("editmember/{id}", [MemberController::class, "update"]);
Route::get("editmemberpage/{id}", [MemberController::class, "editPage"]);
Route::delete("/deleteMember/{id}", [MemberController::class, "destroy"]);

Route::get("/searchmember", [MemberController::class, "search"]);
Route::get("cetakmember/{id}", [MemberController::class, "cetakMember"]);
Route::get("/resetmember/{id}", [MemberController::class, "reset"]);

//deaktivasi member
Route::get("/deaktivasi",[MemberController::class, "DeaktivasiIndex"]);
Route::get("/deaktivasiall",[MemberController::class, "DeaktivasiMember"]);

//reset kelas
Route::get("/resetkelas",[MemberController::class, "ResetIndex"]);
Route::get("/resetkelasall",[MemberController::class, "ResetKelas"]);

//instruktur
Route::get("/instruktur", [InstrukturController::class, "index"]);
Route::get("/tambahinstruktur", [InstrukturController::class, "tambahInstruktur"]);
Route::post("/storeInstruktur", [InstrukturController::class, "store"]);

Route::get("/searchinstruktur", [InstrukturController::class, "search"]);
Route::put("editinstruktur/{id}", [InstrukturController::class, "update"]);
Route::get("editinstrukturpage/{id}", [InstrukturController::class, "editPage"]);
Route::delete("/deleteinstruktur/{id}", [InstrukturController::class, "destroy"]);

//terlambat
Route::get("/reset", [InstrukturController::class, "ResetIndex"]);
Route::get("/resetterlambat", [InstrukturController::class, "ResetTerlambat"]);

// Manager Operasional
Route::get("/jadwalumum", [JadwalUmumController::class, "index"]);
Route::get("/tambahjadwalumum", [JadwalUmumController::class, "tambahJadwalUmum"]);
Route::post("/storejadwalumum", [JadwalUmumController::class, "store"]);
Route::put("editjadwalumum/{id}", [JadwalUmumController::class, "update"]);
Route::get("editjadwalumumpage/{id}", [JadwalUmumController::class, "edit"]);
Route::delete("/deletejadwalumum/{id}", [JadwalUmumController::class, "destroy"]);

// jadwal harian
Route::get("/jadwalharian", [JadwalHarianController::class, "index"]);
Route::get("/aturjadwalharian", [JadwalHarianController::class, "atur"]);
Route::get("/editjadwalharian/{id}",[JadwalHarianController::class, "edit"]);
Route::put("/updatejadwalharian/{id}", [JadwalHarianController::class, "update"]);
Route::get("/carijadwal", [JadwalHarianController::class, "search"]);
Route::delete("/deletejadwalharian/{id}", [JadwalHarianController::class, "destroy"]);

//aktivasi
Route::get("/transaksiaktivasi", [TransaksiAktivasiController::class, "index"]);
Route::post("/tambahtransaksiaktivasi", [TransaksiAktivasiController::class, "create"]);
Route::get("/cetaktransaksiaktivasi/{id}", [TransaksiAktivasiController::class, "cetak"]);
Route::get("/konfirmasiAktivasi", [TransaksiAktivasiController::class, "confirmPaymentAktivasi"]);

//depo kelas
Route::get("/transaksikelas", [TransaksiDepositKelasController::class, "index"]);
Route::get("/cetakdepositkelas/{id}", [TransaksiDepositKelasController::class, "cetak"]);
Route::post("/storedepokelas", [TransaksiDepositKelasController::class, "store"]);
Route::get("/konfirmasidepositkelas", [TransaksiDepositKelasController::class, "confirmPaymentDepositKelas"]);

//depo uang
Route::get("/transaksiuang", [TransaksiDepositUangController::class, "index"]);
Route::get("/cetakdeposituang/{id}", [TransaksiDepositUangController::class, "cetak"]);
Route::post("/storedepouang", [TransaksiDepositUangController::class, "store"]);
Route::get("/konfirmasideposituang", [TransaksiDepositUangController::class, "confirmPaymentDepositUang"]);

//Izin
Route::get("/izin", [IzinController::class, "index"]);
Route::get("/editizin/{id}", [IzinController::class, "edit"]);
Route::get("/updateizin/{id}", [IzinController::class, "update"]);

//Booking Kelas
Route::get("/presensikelas", [BookingKelasController::class, "index"]);
Route::get("/cetakpresensikelas/{id}", [BookingKelasController::class, "cetakPresensi"]);

//Booking Gym
Route::get("/presensigym", [BookingGymController::class, "index"]);
Route::get("/cetakpresensigym/{id}", [BookingGymController::class, "cetakBookingGym"]);
Route::get("/konfirmasigym/{id}", [BookingGymController::class, "konfirmasi_gym"]);

//Laporan

Route::get("/indexPendapatan", [LaporanController::class, "indexPendapatan"]);
Route::get("/laporanPendapatan", [LaporanController::class, "laporanPendapatan"]);

Route::get("/indexKelas", [LaporanController::class, "indexKelas"]);
Route::get("/laporanKelas", [LaporanController::class, "laporanKelas"]);

Route::get("/indexGym", [LaporanController::class, "indexGym"]);
Route::get("/laporanGym", [LaporanController::class, "laporanGym"]);

Route::get("/indexInstruktur", [LaporanController::class, "indexInstruktur"]);
Route::get("/laporanInstruktur", [LaporanController::class, "laporanInstruktur"]);




