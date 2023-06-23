@extends('dashboard')

@section('container')
    <div class=" card my-5 p-3 bg-body rounded shadow-lg w-50 mx-auto no-print">
        <h3 class="card-title text-center">SET LAPORAN KELAS</h3>
        <form action="{{ url('/laporanKelas') }}" method="get" enctype="multipart/form-data">
            @csrf
            <div class="form-row mb-2">
                <div class="form-group col-md-12">
                    <label class="font-weight-bold mb-2">Manajer Operasional</label>
                    <input type='text' class="form-control mb-3"name="ID_PEGAWAI"
                        placeholder="Input date of birth member" autocomplete="off"
                        value="P{{ $user->ID_PEGAWAI }} / {{ $user->NAMA_PEGAWAI }}" disabled />
                </div>
                <div class="form-group col-md-6">
                    <label class="font-weight-bold mb-2">Year</label>
                    <select class="form-control mb-3" aria-label="Default select example" name="year_filter">
                        <option value="" hidden>Select Year</option>
                        @php
                            $year = \Carbon\Carbon::now()->addYears(1);
                        @endphp
                        @for ($i = 0; $i < 3; $i++)
                            @php
                                $year->subYears(1);
                            @endphp
                            <option value={{ $year->format('Y') }}>
                                {{ $year->format('Y') }}</option>
                        @endfor
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold mb-2">Month</label>
                    <select class="form-control mb-3" aria-label="Default select example" name="month_filter">
            
                        {{-- <option value="" hidden>Select Month</option> --}}
                        @php
                            $month = \Carbon\Carbon::create();
                        @endphp
                        @for ($i = 0; $i < 12; $i++)
                            <option value={{ $month->format('m') }}>
                                {{ $month->format('F') }}</option>
                            @php
                                $month->addMonth(1);
                            @endphp
                        @endfor
                   

                        {{-- @php
                            $month = \Carbon\Carbon::now()->month();
                        @endphp
                        @for ($i = 0; $i < 12; $i++)
                            @php
                                $month->addMonth(1);
                            @endphp
                            <option value={{ $month->format('m') }}>
                                {{ $month->format('F') }}</option>
                        @endfor --}}
                    </select>
                </div>

              



                <button type="submit" class="btn btn-primary btn-block mb-4">Search</button>
            </div>
        </form>
    </div>
    @if (!Session::get('print'))
        {{-- <div class="alert alert-danger">
            Data report not found. Please input month and year!
        </div> --}}
    @else
        @php
            $data_class_activity = Session::get('data_class_activity');
        @endphp
       

        <div class=" card my-1 p-3 bg-body rounded shadow-sm mt-3">

            <h3>GoFit</h3>
            <p>Jl. Centralpark No.10 Yogyakarta</p>
            <h3>LAPORAN AKTIVITAS KELAS BULANAN</h3>
            <div class="d-flex">
                <p class="ms-3">Bulan:{{ \Carbon\Carbon::now()->month(Session::get('month')) ->translatedformat('F') }} </p>
                
            </div>
            <p> Periode: {{ Session::get('year') }}</p>
            <p>Tanggal cetak: {{ \Carbon\Carbon::now()->translatedformat('d M Y') }}</p>

            <hr style="width: 100%; color: black; height: 1px; background-color:black;" />

            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="col-md-2">Kelas</th>
                        <th class="col-md-2">Instruktur</th>
                        <th class="col-md-2">Jumlah Peserta</th>
                        <th class="col-md-2">Jumlah Libur</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data_class_activity as $item)
                        <tr>
                            <td>{{ $item->kelas }}</td>
                            <td>{{ $item->instruktur }}</td>
                            <td>{{ $item->jumlah_peserta_kelas }}</td>
                            <td>{{ $item->jumlah_libur }}</td>
                        </tr>
                    @empty
                        <div class="alert alert-danger">
                            Data report empty
                        </div>
                    @endforelse
                </tbody>
            </table>

            <div class="card"style="background-color:#4E73DF; color:white">
                <div class="pb-3 ps-3 pe-3 pt-3 d-flex justify-content-between">
                    <h3 class="card-title ml-2">LAPORAN AKTIVITAS KELAS TAHUN {{ Session::get('year') }}</h3>
                    @if ($data_class_activity)
                        <button type="button" class="btn bg-info text-black no-print mr-2" onclick="window.print()" style="color:white"> <i
                                class="fas fa-solid fa-print fa-fw me-3"></i>Print Report</button>
                    @endif
    
                </div>
            </div>
    @endif
@endsection