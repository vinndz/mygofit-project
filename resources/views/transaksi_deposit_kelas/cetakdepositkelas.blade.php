@extends('dashboard')
@section('container')
    <div class="card bg-body rounded d-flex justify-content-center align-items-center" style="min-height: 100vh">
        <div class="card overflow-hidden" style="width: 50rem;">
            <div class="ml-2 p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <b>Go-Fit</b>
                        <p>Jl. Centralpark No.10 Yogyakarta</p>
                    </div>
                    <div>
                        <p>No Struk : {{ $transaksiKelas->ID_TRANSAKSI_PAKET }}</p>
                        <p>Tanggal : {{ $transaksiKelas->TANGGAL_DEPOSIT_KELAS }}</p>
                    </div>
                </div>
                <p> <b> Member </b> : {{ $transaksiKelas->member->ID_MEMBER }} / {{ $transaksiKelas->member->NAMA_MEMBER }} </p>
                <p>Deposit(bayar 5 gratis 1):Rp.{{$transaksiKelas->JUMLAH_PEMBAYARAN}},- ({{$transaksiKelas->JUMLAH_DEPOSIT_KELAS}} x Rp.150.000)</p>
                <p> Jenis Kelas: {{ $transaksiKelas->kelas->NAMA_KELAS }}</p>
                <p>Total Deposit Kelas: {{$transaksiKelas->TOTAL_DEPOSIT_KELAS}}</p>
                <p>Berlaku sampai dengan: {{$transaksiKelas->MASA_BERLAKU_KELAS}}</p>
                

                <p class="text-right">Kasir : P{{ $transaksiKelas->pegawai->ID_PEGAWAI }}/{{ $transaksiKelas->pegawai->NAMA_PEGAWAI }}</p>
            </div>
            <button type="submit" class="btn btn-info" value="print" onclick="window.print()">Print</button>
        </div>
    </div>
    @endsection
