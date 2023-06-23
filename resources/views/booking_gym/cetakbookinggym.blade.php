@extends('dashboard')
@section('container')
    <section>
        {{-- <h2 class="text-center">RECEIPT</h2> --}}
        <div class="card my-3 p-3 bg-body rounded shadow-sm mx-auto"style="width: 35rem;">
            <div class="card-content">
                <h3><b>GoFit</b></h3>
                <p>Jl. Centralpark No.101 Yogyakarta</p>

                
                <h3><b>STRUK PRESENSI GYM</b></h3>
                <p>No Struk: {{ $bookings->KODE_BOOKING_GYM }} </p>
                    <p>Tanggal :
                        {{ \Carbon\Carbon::parse($bookings->WAKTU_PRESENSI_GYM)->format('d/m/Y H:i:s') }}
                    </p>

                
                <p><b>Member : </b>{{ $bookings->ID_MEMBER }} / {{ $bookings->member->NAMA_MEMBER }}</p>
                <p>Slot Waktu :{{ $bookings->SLOT_WAKTU_GYM }}</p>

            </div>
            <div>
                <button type="submit" class="btn btn-info" value="print" onclick="window.print()">Print</button>
                <a href="\presensigym">
                    <button class="btn btn-danger"">Back</button>
                </a>  
            </div>
        </div>
    </section>
@endsection