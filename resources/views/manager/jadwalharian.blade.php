@extends('dashboard')
@section('container')
<!-- Font Awesome Icons -->
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

<div class="card">
    <h2 style="text-align:center"><b>Jadwal Harian</h2>
    <a href="/aturjadwalharian">
        <button type="button" class="btn btn-primary float-right mb-2 mr-2">Generate</button>
    </a>
<div class="container">
    <link href="../css/jadwalumum.css" rel="stylesheet">
    <div class="timetable-img text-center">
        <img src="img/content/timetable.png" alt="">
    </div>
    <div class="table-responsive">
        <table class="table table-bordered text-center">
            <thead>
                <tr class="bg-light-gray" style="background-color:#4e73df; color:white">
                    <th class="text-uppercase">Day</th>
                    <th class="text-uppercase" colspan="100">TIME</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        @if ($hari_jadwal != null)
                            <div> {{ $hari_jadwal->TANGGAL_JADWAL_HARIAN->format('l') }}</div>
                            <div> {{ $hari_jadwal->TANGGAL_JADWAL_HARIAN->format('Y M d')}}</div>
                        @endif
                    </td>
                    @foreach ($jadwals as $item)
                        @if($item->jadwal->HARI_JADWAL == $hari_jadwal->TANGGAL_JADWAL_HARIAN->format('l'))
                        <td>
                            <div>{{ $item->TANGGAL_JADWAL_HARIAN->format('H:i:s') }}</div>
                            <div>{{ $item->jadwal->kelas->NAMA_KELAS }}</div>
                            <div>{{ $item->instruktur->NAMA_INSTRUKTUR }}</div>
                            <div>({{ $item->KETERANGAN }})</div>
                            <div>
                                <a href='{{ url('/editjadwalharian/' . $item->TANGGAL_JADWAL_HARIAN) }}'
                                    class="btn btn-success"> <i class="fas fa-pencil"></i>
                                </a>
                            </div>
                        </td>
                        @endif
                    @endforeach
                </tr>

                <tr>
                    <td>
                        @if ($hari_jadwal != null)
                            <div>{{ $hari_jadwal->TANGGAL_JADWAL_HARIAN->addDays(1)->format('l') }}</div>
                            <div>{{ $hari_jadwal->TANGGAL_JADWAL_HARIAN->addDays(1)->format('Y M d') }}</div>
                        @endif
                    </td>
                    @foreach ($jadwals as $item)
                        @if($item->jadwal->HARI_JADWAL == $hari_jadwal->TANGGAL_JADWAL_HARIAN->addDays(1)->format('l'))
                        <td>
                            <div> {{ $item->TANGGAL_JADWAL_HARIAN->format('H:i:s') }}</div>
                            <div>{{ $item->jadwal->kelas->NAMA_KELAS }}</div>
                            <div>{{ $item->instruktur->NAMA_INSTRUKTUR }}</div>
                            <div>({{ $item->KETERANGAN }})</div>
                            <div>
                                <a href='{{ url('/editjadwalharian/' . $item->TANGGAL_JADWAL_HARIAN) }}'
                                    class="btn btn-success"> <i class="fas fa-pencil"></i></a>
                            </div>
                        </td>
                        @endif
                    @endforeach              
                </tr>

                <tr>
                    <td>
                        @if ($hari_jadwal != null)
                            <div>{{ $hari_jadwal->TANGGAL_JADWAL_HARIAN->addDays(2)->format('l') }}</div>
                            <div>{{ $hari_jadwal->TANGGAL_JADWAL_HARIAN->addDays(2)->format('Y M d') }}</div>
                        @endif
                    </td>

              
                    @foreach ($jadwals as $item)
                        @if($item->jadwal->HARI_JADWAL == $hari_jadwal->TANGGAL_JADWAL_HARIAN->addDays(2)->format('l'))
                        <td>
                            <div> {{ $item->TANGGAL_JADWAL_HARIAN->format('H:i:s') }}</div>
                            <div>{{ $item->jadwal->kelas->NAMA_KELAS }}</div>
                            <div>{{ $item->instruktur->NAMA_INSTRUKTUR }}</div>
                            <div>({{ $item->KETERANGAN }})</div>
                            <div>
                                <a href='{{ url('/editjadwalharian/' . $item->TANGGAL_JADWAL_HARIAN) }}'
                                    class="btn btn-success"> <i class="fas fa-pencil"></i></a>
                            </div>
                        </td>
                        @endif
                    @endforeach
                    
                </tr>

                <tr>
                    <td>
                        @if ($hari_jadwal != null)
                            <div>{{ $hari_jadwal->TANGGAL_JADWAL_HARIAN->addDays(3)->format('l') }}</div>
                            <div>{{ $hari_jadwal->TANGGAL_JADWAL_HARIAN->addDays(3)->format('Y M d') }}</div>
                        @endif
                    </td>

              
                    @foreach ($jadwals as $item)
                        @if($item->jadwal->HARI_JADWAL == $hari_jadwal->TANGGAL_JADWAL_HARIAN->addDays(3)->format('l'))
                        <td>
                            <div> {{ $item->TANGGAL_JADWAL_HARIAN->format('H:i:s') }}</div>
                            <div>{{ $item->jadwal->kelas->NAMA_KELAS }}</div>
                            <div>{{ $item->instruktur->NAMA_INSTRUKTUR }}</div>
                            <div>({{ $item->KETERANGAN }})</div>
                            <div>
                                <a href='{{ url('/editjadwalharian/' . $item->TANGGAL_JADWAL_HARIAN) }}'
                                    class="btn btn-success"> <i class="fas fa-pencil"></i></a>
                            </div>
                        </td>
                        @endif
                    @endforeach
                    
                </tr>
              
                <tr>
                    <td>
                        @if ($hari_jadwal != null)
                            <div>{{ $hari_jadwal->TANGGAL_JADWAL_HARIAN->addDays(4)->format('l') }}</div>
                            <div>{{ $hari_jadwal->TANGGAL_JADWAL_HARIAN->addDays(4)->format('Y M d') }}</div>
                        @endif
                    </td>

              
                    @foreach ($jadwals as $item)
                        @if($item->jadwal->HARI_JADWAL == $hari_jadwal->TANGGAL_JADWAL_HARIAN->addDays(4)->format('l'))
                        <td>
                            <div> {{ $item->TANGGAL_JADWAL_HARIAN->format('H:i:s') }}</div>
                            <div>{{ $item->jadwal->kelas->NAMA_KELAS }}</div>
                            <div>{{ $item->instruktur->NAMA_INSTRUKTUR }}</div>
                            <div>({{ $item->KETERANGAN }})</div>
                            <div>
                                <a href='{{ url('/editjadwalharian/' . $item->TANGGAL_JADWAL_HARIAN) }}'
                                    class="btn btn-success"> <i class="fas fa-pencil"></i></a>
                            </div>
                        </td>
                        @endif
                    @endforeach
                    
                </tr>
                
                <tr>
                    <td>
                        @if ($hari_jadwal != null)
                            <div>{{ $hari_jadwal->TANGGAL_JADWAL_HARIAN->addDays(5)->format('l') }}</div>
                            <div>{{ $hari_jadwal->TANGGAL_JADWAL_HARIAN->addDays(5)->format('Y M d') }}</div>
                        @endif
                    </td>

              
                    @foreach ($jadwals as $item)
                        @if($item->jadwal->HARI_JADWAL == $hari_jadwal->TANGGAL_JADWAL_HARIAN->addDays(5)->format('l'))
                        <td>
                            <div> {{ $item->TANGGAL_JADWAL_HARIAN->format('H:i:s') }}</div>
                            <div>{{ $item->jadwal->kelas->NAMA_KELAS }}</div>
                            <div>{{ $item->instruktur->NAMA_INSTRUKTUR }}</div>
                            <div>({{ $item->KETERANGAN }})</div>
                            <div>
                                <a href='{{ url('/editjadwalharian/' . $item->TANGGAL_JADWAL_HARIAN) }}'
                                    class="btn btn-success"> <i class="fas fa-pencil"></i></a>
                            </div>
                        </td>
                        @endif
                    @endforeach
                    
                </tr>

                <tr>
                    <td>
                        @if ($hari_jadwal != null)
                            <div>{{ $hari_jadwal->TANGGAL_JADWAL_HARIAN->addDays(6 )->format('l') }}</div>
                            <div>{{ $hari_jadwal->TANGGAL_JADWAL_HARIAN->addDays(6)->format('Y M d') }}</div>
                        @endif
                    </td>

              
                    @foreach ($jadwals as $item)
                        @if($item->jadwal->HARI_JADWAL == $hari_jadwal->TANGGAL_JADWAL_HARIAN->addDays(6)->format('l'))
                        <td>
                            <div> {{ $item->TANGGAL_JADWAL_HARIAN->format('H:i:s') }}</div>
                            <div>{{ $item->jadwal->kelas->NAMA_KELAS }}</div>
                            <div>{{ $item->instruktur->NAMA_INSTRUKTUR }}</div>
                            <div>({{ $item->KETERANGAN }})</div>
                            <div>
                                <a href='{{ url('/editjadwalharian/' . $item->TANGGAL_JADWAL_HARIAN) }}'
                                    class="btn btn-success"> <i class="fas fa-pencil"></i></a>
                            </div>
                        </td>
                        @endif
                    @endforeach
                    
                </tr>
            </tbody>
        </table>
    </div>
</div>
</div>

@endsection

@section('search-container')
<form action ="{{url ('/carijadwal')}}" method="get"
    class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
    <div class="input-group">
        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
            aria-label="Search" aria-describedby="basic-addon2" name="search">
        <div class="input-group-append">
            <button class="btn btn-primary" type="submit">
                <i class="fas fa-search fa-sm"></i>
            </button>
        </div>
    </div>
</form>
@endsection