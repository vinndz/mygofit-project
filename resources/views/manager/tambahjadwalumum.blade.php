,@extends('/dashboard')
@section('container')
<h1>Tambah Data Jadwal Umum</h1>

<form action="{{url('/storejadwalumum')}}" method="post">
    @csrf
    <div class="mb-3">
        <label for="KELAS" class="form-label">Kelas</label>
        <div style="">
            <select class="form-control" name="ID_KELAS">
                <option value="" selected hidden>Pilih Kelas</option>
                @foreach ($kelas as $item)
                    <option value="{{ $item->ID_KELAS }}">{{ $item->NAMA_KELAS }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="mb-3">
        <label for="KELAS" class="form-label">Instruktur</label>
        <div class="">
            <select class="form-control" name="ID_INSTRUKTUR">
                <option value="" selected hidden>Pilih Instruktur</option>
                @foreach ($instruktur as $item)
                    <option value="{{ $item->ID_INSTRUKTUR }}">{{ $item->NAMA_INSTRUKTUR }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group-row">
        <label for="SESI_JADWAL">Waktu Jadwal</label>
        <input type="text" class="form-control" placeholder="Masukkan Waktu Jadwal"name="SESI_JADWAL">
  </div>

    <div class="form-group-row">
          <label for="TANGGAL_JADWAL">Tanggal Jadwal</label>
          <input type="date" class="form-control" placeholder="Masukkan Tanggal Jadwal"name="TANGGAL_JADWAL">
    </div>

    <div class="form-group-row">
        <label for="HARI_JADWAL mt-2">Hari Jadwal</label>
        <div class="">
        <select class="form-control" aria-label="Default select example" name="HARI_JADWAL">
            <option selected>Pilih Hari Jadwal</option>
            <option value="Monday">Monday</option>
            <option value="Tuesday">Tuesday</option>
            <option value="Wednesday">Wednesday</option>
            <option value="Thursday">Thursday</option>
            <option value="Friday">Friday</option>
            <option value="Saturday">Saturday</option>
            <option value="Sunday">Sunday</option>
          </select>
        </div>
  </div>
      
    <button type="submit" class="btn btn-primary mt-3">Tambah</button>

    {{-- <a href="\jadwalumum">
        <button class="btn btn-danger mt-3 ml-2" style="width:80px">Back</button>
    </a> --}}
  </form>

  @endsection


