@extends('/dashboard')
@section('container')
<h1>Edit Data Jadwal Umum</h1>

<form  method="post" action="{{url('editjadwalumum/'.$jadwal->ID_JADWAL_UMUM)}}">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="KELAS" class="form-label">Kelas</label>
        <div class="">
            <select class="form-control" name="ID_KELAS">
                <option hidden></option>
                @foreach ($kelas as $item)
                <option value=" {{$item->ID_KELAS}}"
                {{ $jadwal->ID_KELAS == $item->ID_KELAS ? 'selected' : '' }}>
                {{ $item->NAMA_KELAS }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="mb-3">
        <label for="INSTRUKTUR" class="form-label">Instruktur</label>
        <div class="">
            <select class="form-control" name="ID_INSTRUKTUR">
                <option hidden></option>
                @foreach ($instruktur as $iteminstruktur)
                <option value=" {{$iteminstruktur->ID_INSTRUKTUR}}"
                {{ $jadwal->ID_INSTRUKTUR == $iteminstruktur->ID_INSTRUKTUR ? 'selected' : '' }}>
                {{ $iteminstruktur->NAMA_INSTRUKTUR }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- <div class="form-group-row">
        <label for="TANGGAL_JADWAL">Tanggal Jadwal</label>
        <input type="date" class="form-control" placeholder="Masukkan Tanggal Jadwal"name="TANGGAL_JADWAL">
  </div> --}}

    <div class="form-group-row">
          <label for="SESI_JADWAL">Waktu Jadwal</label>
          <input type="text" class="form-control" placeholder="Masukkan Waktu Jadwal"name="SESI_JADWAL" value="{{$jadwal->SESI_JADWAL}}">
    </div>

    <div class="form-group-row mb-2">
        <label for="HARI_JADWAL">Hari Jadwal</label>
        <div class="">
        <select class="form-control" aria-label="Default select example" name="HARI_JADWAL">
            <option selected>Pilih Hari Jadwal</option>
            <option value="" hidden>Pilih Hari</option>
            @if ($jadwal->HARI_JADWAL == 'Monday')
                <option value="Monday" selected>Monday</option>
            @else
                <option value="Monday">Monday</option>
            @endif

            @if ($jadwal->HARI_JADWAL == 'Tuesday')
                <option value="Tuesday" selected>Tuesday</option>
            @else
                <option value="Tuesday">Tuesday</option>
            @endif

            @if ($jadwal->HARI_JADWAL == 'Wednesday')
                <option value="Wednesday" selected>Wednesday</option>
            @else
                <option value="Wednesday">Wednesday</option>
            @endif

            @if ($jadwal->HARI_JADWAL == 'Thursday')
                <option value="Thursday" selected>Thursday</option>
            @else
                <option value="Thursday">Thursday</option>
            @endif

            @if ($jadwal->HARI_JADWAL == 'Friday')
                <option value="Friday" selected>Friday</option>
            @else
                <option value="Friday">Friday</option>
            @endif

            @if ($jadwal->HARI_JADWAL == 'Saturday')
                <option value="Saturday" selected>Saturday</option>
            @else
                <option value="Saturday">Saturday</option>
            @endif

            @if ($jadwal->HARI_JADWAL == 'Sunday')
                <option value="Sunday" selected>Sunday</option>
            @else
                <option value="Sunday">Sunday</option>
            @endif
          </select>
        </div>
  </div>
      
    <button type="submit" class="btn btn-primary mt-3">Edit</button>

    {{-- <a href="\jadwalumum">
        <button class="btn btn-danger">Back</button>
    </a> --}}
  </form>

  @endsection


