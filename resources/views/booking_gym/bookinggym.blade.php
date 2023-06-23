@extends('dashboard')
@section('container')

{{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script> --}}
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 mb-1">Data Konfirmasi Gym</h1>
</div>
<div class="table-responsive">
<table class="table table-striped table-sm text-center" style="border-style:solid; border-color:#4e73df">
    <thead style="border-style:solid">
        <tr style="background-color:#4e73df; color:white; border-style:solid; border-color:#4e73df;:center">
        <th scope="col" style="vertical-align: middle">ID Booking</th>
        <th scope="col" style="vertical-align: middle">Nama</th>
        <th scope="col" style="vertical-align: middle">Slot Waktu</th>
        <th scope="col" style="vertical-align: middle">Tanggal Gym</th>
        <th scope="col" style="vertical-align: middle">Tanggal Booking</th>
        <th scope="col" style="vertical-align: middle">Waktu Konfirmasi</th>
        <th scope="col" style="vertical-align: middle">Status</th>
        <th scope="col" style="vertical-align: middle">Aksi</th>
    </tr>
</thead>
<tbody >
    @foreach ($booking_gym as $item)
    <tr style="border-style:solid">
        
        <td>{{$item->KODE_BOOKING_GYM}}</td>
        <td>{{$item->member->NAMA_MEMBER}}</td>
        <td>{{$item->SLOT_WAKTU_GYM}}</td>
        <td>{{$item->TANGGAL_MELAKUKAN_BOOK_GYM}}</td>
        <td>{{$item->TANGGAL_BOOK_GYM}}</td>
        <td>{{$item->WAKTU_PRESENSI_GYM}}</td>
        <td>{{$item->STATUS_PRESENSI_GYM}}</td> 
        <td>
            <a href="{{ url('/konfirmasigym/'.$item->KODE_BOOKING_GYM)}}" class="text-primary" >
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                  </svg>
                </td>
            
            </td>
            
            </tr>
            @endforeach
        </tbody>
    </table>
    {{-- {{ $member->links() }} --}}
</div>




<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 mb-1">Data Booking Gym</h1>
</div>
<div class="table-responsive">
<table class="table table-striped table-sm text-center" style="border-style:solid; border-color:#4e73df">
    <thead style="border-style:solid">
        <tr style="background-color:#4e73df; color:white; border-style:solid; border-color:#4e73df;:center">
        <th scope="col" style="vertical-align: middle">ID Booking</th>
        <th scope="col" style="vertical-align: middle">Nama</th>
        <th scope="col" style="vertical-align: middle">Slot Waktu</th>
        <th scope="col" style="vertical-align: middle">Tanggal Gym</th>
        <th scope="col" style="vertical-align: middle">Tanggal Booking</th>
        <th scope="col" style="vertical-align: middle">Waktu Konfirmasi</th>
        <th scope="col" style="vertical-align: middle">Status</th>
        <th scope="col" style="vertical-align: middle">Aksi</th>
    </tr>
</thead>
<tbody >
    @foreach ($booking_gym_setelah as $item)
    <tr style="border-style:solid">
        
        <td>{{$item->KODE_BOOKING_GYM}}</td>
        <td>{{$item->member->NAMA_MEMBER}}</td>
        <td>{{$item->SLOT_WAKTU_GYM}}</td>
        <td>{{$item->TANGGAL_MELAKUKAN_BOOK_GYM}}</td>
        <td>{{$item->TANGGAL_BOOK_GYM}}</td>
        <td>{{$item->WAKTU_PRESENSI_GYM}}</td>
        <td>{{$item->STATUS_PRESENSI_GYM}}</td> 
        <td>
            <a href="{{ url('/cetakpresensigym/'.$item->KODE_BOOKING_GYM)}}" class="text-primary" >
                <button type="submit" class="btn btn-info btn-xs" style="width:80px">
                    <span class="glyphicon glyphicon-remove"></span> Cetak Presensi
                </button>
            </td>
            
            </tr>
            @endforeach
        </tbody>
    </table>
    {{-- {{ $member->links() }} --}}
</div>
@endsection

@section('search-container')
<form action ="{{url ('/searchmember')}}" method="get"
    class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
    <div class="input-group">
        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
            aria-label="Search" aria-describedby="basic-addon2" name="search">
        <div class="input-group-append">
            <button class="btn btn-primary" type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                <i class="fas fa-search fa-sm"></i>
            </button>
        </div>
    </div>
</form>
@endsection