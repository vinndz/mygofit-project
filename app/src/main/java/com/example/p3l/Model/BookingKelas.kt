package com.example.p3l.Model

class BookingKelas(
    var KODE_BOOKING_KELAS: String,
    var NAMA_KELAS: String,
    var TANGGAL_JADWAL_HARIAN:String?, //datetime
    var TANGGAL_MELAKUKAN_BOOKING:String?, //datetime
    var STATUS_PRESENSI_KELAS:String,
    var WAKTU_PRESENSI_KELAS:String?, //time
){

}