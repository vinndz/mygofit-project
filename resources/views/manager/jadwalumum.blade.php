@extends('dashboard')
@section('container')
<!-- Font Awesome Icons -->
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

<div class="card">
    <h2 style="text-align:center"><b>Jadwal Kelas</h2>
    <a href="/tambahjadwalumum">
        <button type="button" class="btn btn-primary float-right mb-2 mr-2">Tambah Jadwal</button>
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
                    <th style ="background-color:#4e73df; color:white; vertical-align:middle">MONDAY
                    @foreach ($jadwalUmum as $items)
                        @if($items->HARI_JADWAL == 'Monday')
                        <td>
                            <span style ="background-color:#4e73df" class=" padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">{{ $items->instruktur->NAMA_INSTRUKTUR }}</span>
                            {{-- <div class="margin-10px-top font-size14">{{ $items->TANGGAL_JADWAL }}</div> --}}
                            <div class="margin-10px-top font-size14">{{ $items->SESI_JADWAL }}</div>
                            <div class="margin-10px-top font-size14">{{ $items->kelas->NAMA_KELAS }}</div>
                            <div class="d-flex align-items-between justify-content-center">
                                <a href='{{ url('/editjadwalumumpage/' . $items->ID_JADWAL_UMUM) }}'
                                    class="btn btn-success btn-sm rounded circle mr-2"><i class="fas fa-pencil"></i></a>
                                <form onsubmit="return confirm('Apakah anda ingin menghapus jadwal kelas?');"
                                    action="{{ url('/deletejadwalumum/' .$items->ID_JADWAL_UMUM) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm rounded circle ml-2"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                        @endif
                    @endforeach
                    </th>
                </tr>

                <tr>
                    <th style ="background-color:#4e73df; color:white; vertical-align:middle">Tuesday
                    @foreach ($jadwalUmum as $items)
                        @if($items->HARI_JADWAL == 'Tuesday')
                        <td>
                            <span style ="background-color:#4e73df" class="padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">{{ $items->instruktur->NAMA_INSTRUKTUR }}</span>
                            {{-- <div class="margin-10px-top font-size14">{{ $items->TANGGAL_JADWAL }}</div> --}}
                            <div class="margin-10px-top font-size14">{{ $items->SESI_JADWAL }}</div>
                            <div class="margin-10px-top font-size14">{{ $items->kelas->NAMA_KELAS }}</div>
                            <div class="d-flex align-items-between justify-content-center">
                                <a href='{{ url('/editjadwalumumpage/'. $items->ID_JADWAL_UMUM) }}'
                                    class="btn btn-success btn-sm rounded circle mr-2"><i class="fas fa-pencil"></i>
                                </a>
                                <form onsubmit="return confirm('Apakah anda ingin menghapus jadwal kelas?');"
                                    action="{{ url('/deletejadwalumum/'.$items->ID_JADWAL_UMUM) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm rounded circle ml-2"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                        @endif
                    @endforeach
                    </th>
                </tr>

                <tr>
                    <th style ="background-color:#4e73df; color:white; vertical-align:middle">Wednesday
                    @foreach ($jadwalUmum as $items)
                        @if($items->HARI_JADWAL == 'Wednesday')
                        <td>
                            <span style ="background-color:#4e73df" class=" padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">{{ $items->instruktur->NAMA_INSTRUKTUR }}</span>
                            {{-- <div class="margin-10px-top font-size14">{{ $items->TANGGAL_JADWAL }}</div> --}}
                            <div class="margin-10px-top font-size14">{{ $items->SESI_JADWAL }}</div>
                            <div class="margin-10px-top font-size14">{{ $items->kelas->NAMA_KELAS }}</div>
                            <div class="d-flex align-items-between justify-content-center">
                                <a href='{{ url('/editjadwalumumpage/' . $items->ID_JADWAL_UMUM) }}'
                                    class="btn btn-success btn-sm rounded circle mr-2"><i class="fas fa-pencil"></i></a>
                                <form onsubmit="return confirm('Apakah anda ingin menghapus jadwal kelas?');"
                                    action="{{ url('/deletejadwalumum/' .$items->ID_JADWAL_UMUM) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm rounded circle ml-2"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                        @endif
                    @endforeach
                    </th>
                </tr>

                <tr>
                    <th style ="background-color:#4e73df; color:white; vertical-align:middle">Thursday
                    @foreach ($jadwalUmum as $items)
                        @if($items->HARI_JADWAL == 'Thursday')
                        <td>
                            <span style ="background-color:#4e73df" class=" padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">{{ $items->instruktur->NAMA_INSTRUKTUR }}</span>
                            {{-- <div class="margin-10px-top font-size14">{{ $items->TANGGAL_JADWAL }}</div> --}}
                            <div class="margin-10px-top font-size14">{{ $items->SESI_JADWAL }}</div>
                            <div class="margin-10px-top font-size14">{{ $items->kelas->NAMA_KELAS }}</div>
                            <div class="d-flex align-items-between justify-content-center">
                                <a href='{{ url('/editjadwalumumpage/' . $items->ID_JADWAL_UMUM) }}'
                                    class="btn btn-success btn-sm rounded circle mr-2"><i class="fas fa-pencil"></i></a>
                                <form onsubmit="return confirm('Apakah anda ingin menghapus jadwal kelas?');"
                                    action="{{ url('/deletejadwalumum/' .$items->ID_JADWAL_UMUM) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm rounded circle ml-2"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                        @endif
                    @endforeach
                    </th>
                </tr>
              
                <tr>
                    <th style ="background-color:#4e73df; color:white; vertical-align:middle">Friday
                    @foreach ($jadwalUmum as $items)
                        @if($items->HARI_JADWAL == 'Friday')
                        <td>
                            <span style ="background-color:#4e73df" class=" padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">{{ $items->instruktur->NAMA_INSTRUKTUR }}</span>
                            {{-- <div class="margin-10px-top font-size14">{{ $items->TANGGAL_JADWAL }}</div> --}}
                            <div class="margin-10px-top font-size14">{{ $items->SESI_JADWAL }}</div>
                            <div class="margin-10px-top font-size14">{{ $items->kelas->NAMA_KELAS }}</div>
                            <div class="d-flex align-items-between justify-content-center">
                                <a href='{{ url('/editjadwalumumpage/' . $items->ID_JADWAL_UMUM) }}'
                                    class="btn btn-success btn-sm rounded circle mr-2"><i class="fas fa-pencil"></i></a>
                                <form onsubmit="return confirm('Apakah anda ingin menghapus jadwal kelas?');"
                                    action="{{ url('/deletejadwalumum/' .$items->ID_JADWAL_UMUM) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm rounded circle ml-2"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                        @endif
                    @endforeach
                    </th>
                </tr>
                
                <tr>
                    <th style ="background-color:#4e73df; color:white; vertical-align:middle">Saturday
                    @foreach ($jadwalUmum as $items)
                        @if($items->HARI_JADWAL == 'Saturday')
                        <td>
                            <span style ="background-color:#4e73df" class=" padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">{{ $items->instruktur->NAMA_INSTRUKTUR }}</span>
                            {{-- <div class="margin-10px-top font-size14">{{ $items->TANGGAL_JADWAL }}</div> --}}
                            <div class="margin-10px-top font-size14">{{ $items->SESI_JADWAL }}</div>
                            <div class="margin-10px-top font-size14">{{ $items->kelas->NAMA_KELAS }}</div>
                            <div class="d-flex align-items-between justify-content-center">
                                <a href='{{ url('/editjadwalumumpage/' . $items->ID_JADWAL_UMUM) }}'
                                    class="btn btn-success btn-sm rounded circle mr-2"><i class="fas fa-pencil"></i></a>
                                <form onsubmit="return confirm('Apakah anda ingin menghapus jadwal kelas?');"
                                    action="{{ url('/deletejadwalumum/' .$items->ID_JADWAL_UMUM) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm rounded circle ml-2"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                        @endif
                    @endforeach
                    </th>
                </tr>

                <tr>
                    <th style ="background-color:#4e73df; color:white; vertical-align:middle">Sunday
                    @foreach ($jadwalUmum as $items)
                        @if($items->HARI_JADWAL == 'Sunday')
                        <td>
                            <span style ="background-color:#4e73df" class=" padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">{{ $items->instruktur->NAMA_INSTRUKTUR }}</span>
                            {{-- <div class="margin-10px-top font-size14">{{ $items->TANGGAL_JADWAL }}</div> --}}
                            <div class="margin-10px-top font-size14">{{ $items->SESI_JADWAL }}</div>
                            <div class="margin-10px-top font-size14">{{ $items->kelas->NAMA_KELAS }}</div>
                            <div class="d-flex align-items-between justify-content-center">
                                <a href='{{ url('/editjadwalumumpage/' . $items->ID_JADWAL_UMUM) }}'
                                    class="btn btn-success btn-sm rounded circle mr-2"><i class="fas fa-pencil"></i></a>
                                <form onsubmit="return confirm('Apakah anda ingin menghapus jadwal kelas?');"
                                    action="{{ url('/deletejadwalumum/' .$items->ID_JADWAL_UMUM) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm rounded circle ml-2"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                        @endif
                    @endforeach
                    </th>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</div>

@endsection