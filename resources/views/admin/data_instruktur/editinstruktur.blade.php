@extends('/dashboard')
@section('container')
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<title>Go Fit</title>
<h1 style="margin:auto">Edit Data Instruktur</h1>


<form action="{{url('editinstruktur/'.$instruktur->ID_INSTRUKTUR)}}" method="post">
    @csrf
    @method('put')
    <div class="form-group-row">
        <label for="NAMA_INSTRUKTUR">Nama Instruktur</label>
        <input type="text" class="form-control" id="NAMA_INSTRUKTUR" placeholder="Masukkan Nama" name="NAMA_INSTRUKTUR" value="{{$instruktur->NAMA_INSTRUKTUR}}">
    </div>

    <div class="form-group-row">
          <label for="ALAMAT_INSTRUKTUR">Alamat</label>
          <input type="text" class="form-control" id="ALAMAT_INSTRUKTUR" placeholder="Masukkan Alamat"name="ALAMAT_INSTRUKTUR" value="{{$instruktur->ALAMAT_INSTRUKTUR}}">
      </div>

      <div class="form-group-row">
          <label for="TELEPON_INSTRUKTUR">No Telepon</label>
          <input type="text" class="form-control" id="TELEPON_INSTRUKTUR" placeholder="Masukkan No Telepon" name="TELEPON_INSTRUKTUR" value="{{$instruktur->TELEPON_INSTRUKTUR}}">
      </div>

      <div class="form-group-row">
          <label for="TANGGAL_LAHIR_INSTRUKTUR">Tanggal Lahir INSTRUKTUR</label>
          <input type="date" class="form-control" id="TANGGAL_LAHIR_INSTRUKTUR" placeholder="Masukkan Tanggal Lahir INSTRUKTUR" name="TANGGAL_LAHIR_INSTRUKTUR" value="{{$instruktur->TANNGAL_LAHIR_INSTRUKTUR}}">
      </div>

      <div class="form-group-row">
          <label for="EMAIL_INSTRUKTUR">Email</label>
          <input type="email" class="form-control" id="EMAIL_INSTRUKTUR" placeholder="Masukkan Email" name="EMAIL_INSTRUKTUR" value="{{$instruktur->EMAIL_INSTRUKTUR}}">
      </div>
      <div class="form-group-row">
          <label for="password">Password</label>
          <input type="password" class="form-control" id="password" placeholder="**********">
      </div>    
    <button type="submit" class="btn btn-primary" style="margin-top:10px">Simpan</button>
    <a href="\instruktur">
        <button class="btn btn-danger" style="margin-top:10px">Back</button>
    </a>
  </form>

@endsection
