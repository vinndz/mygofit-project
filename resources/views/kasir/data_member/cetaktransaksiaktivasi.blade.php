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
                        <p>No Struk : {{ $aktivasi->ID_TRANSAKSI_AKTIVASI }}</p>
                        <p>Tanggal Aktivasi : {{ $aktivasi->TANGGAL_TRANSAKSI_AKTIVASI }}</p>
                    </div>
                </div>
                <p> <b> Member </b> : {{ $aktivasi->member->ID_MEMBER }} / {{ $aktivasi->member->NAMA_MEMBER }} </p>
                <p> Aktivasi Tahunan : {{ $aktivasi->BIAYA_AKTIVASI }}</p>
                <p> Masa Aktif Member : {{ $aktivasi->TANGGAL_EXPIRED }} </p>

                <p class="text-right">Kasir : {{ $aktivasi->pegawai->NAMA_PEGAWAI }}</p>
            </div>
            <button type="submit" class="btn btn-info" value="print" onclick="window.print()">Print</button>
        </div>
    </div>
    @endsection
