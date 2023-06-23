@extends('dashboard')
@section('container')

<form method="post" action="{{url('/updateIzin/'.$izin->ID_IZIN_INSTRUKTUR)}}"  enctype="multipart/form-data">
    @csrf
    @method ('PUT')
    <div class="row">
      <div class="col-12">
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold txt-title">Form Konfirmasi Instruktur</h6>
          </div>
          <div class="card-body">

            <div class="form-group">
              <label for="ID_IZIN_INSTRUKTUR">Nama Instruktur</label>
              <input type="text" class="form-control" id="ID_IZIN_INSTRUKTUR" name="ID_IZIN_INSTRUKTUR" placeholder="Masukkan Nama Instruktur" value="{{$izin->instruktur->NAMA_INSTRUKTUR}}" disabled>
            </div>

            <div class="form-group">
              <label for="STATUS_IZIN">Status Konfirmasi</label>
              <input type="text" class="form-control" id="STATUS_IZIN" name="STATUS_IZIN" placeholder="Masukkan Status Konfirmasi">
            </div>

            </div> 
            <div class="card-footer">
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ url('izin') }}" class="btn btn-danger">Batal</a>
          </div>
        </div>
      </div>
    </div>
  </form>

@endsection