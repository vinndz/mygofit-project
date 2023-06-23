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
                        <p>No Struk : {{ $transaksiUang->ID_TRANSAKSI_DEPOSIT_UANG }}</p>
                        <p>Tanggal : {{ $transaksiUang->TANGGAL_DEPOSIT_UANG }}</p>
                    </div>
                </div>
                <p> <b> Member </b> : {{ $transaksiUang->member->ID_MEMBER }} / {{ $transaksiUang->member->NAMA_MEMBER }} </p>
                <p>Deposit:Rp.{{$transaksiUang->JUMLAH_DEPOSIT}},-</p>
                <p>Bonus Deposit: {{ $transaksiUang->BONUS_DEPOSIT }},-</p>
                <p>Sisa Deposit: {{$transaksiUang->SISA_DEPOSIT}},-</p>
                <p>Total Deposit: {{$transaksiUang->TOTAL_DEPOSIT}},-</p>
                

                <p class="text-right">Kasir : P{{ $transaksiUang->pegawai->ID_PEGAWAI }}/{{ $transaksiUang->pegawai->NAMA_PEGAWAI }}</p>
            </div>
            <button type="submit" class="btn btn-info" value="print" onclick="window.print()">Print</button>
        </div>
    </div>
    @endsection
