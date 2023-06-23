@extends('/dashboard')
@section('container')
<h1>Tambah Data Instruktur</h1>

<form action="{{url('/storeInstruktur')}}" method="post">
    @csrf
    <div class="form-group-row">
        <label for="NAMA_INSTRUKTUR">Nama Instruktur</label>
        <input type="text" class="form-control" id="NAMA_INSTRUKTUR" placeholder="Masukkan Nama" name="NAMA_INSTRUKTUR">
    </div>

    <div class="form-group-row">
          <label for="ALAMAT_INSTRUKTUR">Alamat Instruktur</label>
          <input type="text" class="form-control" id="ALAMAT_INSTRUKTUR" placeholder="Masukkan Alamat"name="ALAMAT_INSTRUKTUR">
      </div>

      <div class="form-group-row">
          <label for="TELEPON_INSTRUKTUR">Telepon Instruktur</label>
          <input type="text" class="form-control" id="TELEPON_INSTRUKTUR" placeholder="Masukkan No Telepon" name="TELEPON_INSTRUKTUR">
      </div>

      <div class="form-group-row">
          <label for="TANGGAL_LAHIR_INSTRUKTUR">Tanggal Lahir Instruktur</label>
          <input type="date" class="form-control" id="TANGGAL_LAHIR_INSTRUKTUR" placeholder="Masukkan Tanggal Lahir INSTRUKTUR" name="TANGGAL_LAHIR_INSTRUKTUR">
      </div>

      <div class="form-group-row">
          <label for="EMAIL_INSTRUKTUR">Email</label>
          <input type="email" class="form-control" id="EMAIL_INSTRUKTUR" placeholder="Masukkan Email" name="EMAIL_INSTRUKTUR">
      </div>
      <div class="form-group-row">
          <label for="password">Password</label>
          <input type="password" class="form-control" id="password" placeholder="**********" name="password">
      </div>
      
    <button type="submit" class="btn btn-primary mt-2">Tambah</button>

    <a href="\instruktur">
        <button class="btn btn-danger mt-2 ml-2" style="width:80px">Back</button>
    </a>
  </form>

  @endsection