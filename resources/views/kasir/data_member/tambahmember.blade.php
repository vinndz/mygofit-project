@extends('/dashboard')
@section('container')
<h1>Tambah Data Member</h1>

<form action="{{url('/storeMember')}}" method="post">
    @csrf
    <div class="form-group-row">
        <label for="NAMA_MEMBER">Nama Member</label>
        <input type="text" class="form-control" id="NAMA_MEMBER" placeholder="Masukkan Nama" name="NAMA_MEMBER">
    </div>

    <div class="form-group-row">
          <label for="ALAMAT_MEMBER">Alamat</label>
          <input type="text" class="form-control" id="ALAMAT_MEMBER" placeholder="Masukkan Alamat"name="ALAMAT_MEMBER">
      </div>

      <div class="form-group-row">
          <label for="TELEPON_MEMBER">No Telepon</label>
          <input type="text" class="form-control" id="TELEPON_MEMBER" placeholder="Masukkan No Telepon" name="TELEPON_MEMBER">
      </div>

      <div class="form-group-row">
          <label for="TANGGAL_LAHIR_MEMBER">Tanggal Lahir Member</label>
          <input type="date" class="form-control" id="TANGGAL_LAHIR_MEMBER" placeholder="Masukkan Tanggal Lahir Member" name="TANGGAL_LAHIR_MEMBER">
      </div>

      <div class="form-group-row">
          <label for="EMAIL_MEMBER">Email</label>
          <input type="email" class="form-control" id="EMAIL_MEMBER" placeholder="Masukkan Email" name="EMAIL_MEMBER">
      </div>
      <div class="form-group-row">
          <label for="password">Password</label>
          <input type="password" class="form-control" id="password" placeholder="**********" name="password">
      </div>
      
    <button type="submit" class="btn btn-primary mt-2" style="width:80px">Tambah</button>
    <a href="\member">
        <button class="btn btn-danger mt-2 ml-2" style="width:80px">Back</button>
    </a>
  </form>

  @endsection


