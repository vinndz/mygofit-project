@extends('/dashboard')
@section('container')
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<title>Go Fit</title>
<h1 style="margin:auto">Edit Data Member</h1>


<form action="{{url('editmember/'.$member->ID_MEMBER)}}" method="post">
    @csrf
    @method('PUT')
    <div class="form-group-row">
        <label for="NAMA_MEMBER">Nama Member</label>
        <input type="text" class="form-control" id="NAMA_MEMBER" placeholder="Masukkan Nama" name="NAMA_MEMBER" value="{{$member->NAMA_MEMBER}}">
    </div>

    <div class="form-group-row">
          <label for="ALAMAT_MEMBER">Alamat</label>
          <input type="text" class="form-control" id="ALAMAT_MEMBER" placeholder="Masukkan Alamat"name="ALAMAT_MEMBER" value="{{$member->ALAMAT_MEMBER}}">
      </div>

      <div class="form-group-row">
          <label for="TELEPON_MEMBER">No Telepon</label>
          <input type="text" class="form-control" id="TELEPON_MEMBER" placeholder="Masukkan No Telepon" name="TELEPON_MEMBER" value="{{$member->TELEPON_MEMBER}}">
      </div>

      <div class="form-group-row">
          <label for="TANGGAL_LAHIR_MEMBER">Tanggal Lahir Member</label>
          <input type="date" class="form-control" id="TANGGAL_LAHIR_MEMBER" placeholder="Masukkan Tanggal Lahir Member" name="TANGGAL_LAHIR_MEMBER" value="{{$member->TANNGAL_LAHIR_MEMBER}}">
      </div>

      <div class="form-group-row">
          <label for="EMAIL_MEMBER">Email</label>
          <input type="email" class="form-control" id="EMAIL_MEMBER" placeholder="Masukkan Email" name="EMAIL_MEMBER" value="{{$member->EMAIL_MEMBER}}">
      </div>
      <div class="form-group-row">
          <label for="password">Password</label>
          <input type="password" class="form-control" id="password" placeholder="**********">
      </div>    
    <button type="submit" class="btn btn-primary" style="margin-top:10px">Simpan</button>
    <a href="\member">
        <button class="btn btn-danger" style="margin-top:10px">Back</button>
    </a>
  </form>
@endsection

