@extends('dashboard')



@section('container')
    <section>
        {{-- <h2 class="text-center">RECEIPT</h2> --}}

        <div class="card my-3 p-3 bg-body rounded shadow-sm mx-auto"style="width: 35rem;">
            <div class="card-content">
                <h3><b>GoFit</b></h3>
                <p>Jl. Centralpark No.101 Yogyakarta</p>

                
                <h3><b>STRUK PRESENSI KELAS</b></h3>
                <p>No Struk: {{ $presensies->KODE_BOOKING_KELAS }} </p>
                @if ($presensies->WAKTU_PRESENSI_KELAS != null)
                    <p>Tanggal :
                        {{ \Carbon\Carbon::parse($presensies->WAKTU_PRESENSI_KELAS)->format('d/m/Y H:i:s') }}
                    </p>
                @else
                    <p>Tanggal : Belum dikonfirmasi </p>
                @endif

                
                <p><b>Member :</b> {{ $presensies->ID_MEMBER }} / {{ $presensies->NAMA_MEMBER }}</p>
                <p>Kelas : {{ $presensies->NAMA_KELAS }}</p>
                <p>Instruktur : {{ $presensies->NAMA_INSTRUKTUR }}</p>
                @if ($presensies->TARIF_KELAS != 1)
                    <p>Tarif : Rp.{{ $presensies->TARIF_KELAS }}</p>
                    <p>Sisa deposit : Rp.{{ $presensies->SISA_DEPOSIT_MEMBER }}</p>
                @else
                    <p>Sisa Deposit: {{ $presensies2->SISA_DEPO }}x</p>
                    <p>Berlaku Sampai: {{ \Carbon\Carbon::parse($presensies2->MASA_BERLAKU)->format('d/m/Y H:i:s') }}</p>
                @endif


            </div>
            <div>
                <button type="submit" class="btn btn-info" value="print" onclick="window.print()">Print</button>
                <a href="\presensikelas">
                    <button class="btn btn-danger"">Back</button>
                </a>            
            </div>
        </div>
    </section>
@endsection