@extends('dashboard')
@section('container')

{{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script> --}}


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 mb-1">Deaktivasi Member</h1>
</div>
<a href="{{ url('/deaktivasiall') }}"class="btn btn-danger float-right mb-2">Deactivate Member</a>
<div class="table-responsive">
<table class="table table-striped table-sm text-center" style="border-style:solid; border-color:#4e73df">
    <thead style="border-style:solid">
        <tr style="background-color:#4e73df; color:white; border-style:solid; border-color:#4e73df;:center">
        <th scope="col" style="vertical-align: middle">ID Member</th>
        <th scope="col" style="vertical-align: middle">Nama</th>
        <th scope="col" style="vertical-align: middle">Alamat</th>
        <th scope="col" style="vertical-align: middle">No Telepon</th>
        <th scope="col" style="vertical-align: middle">Tanggal Lahir</th>
        <th scope="col">Sisa Deposit Kelas</th>
        <th scope="col">Sisa Deposit Member</th>
        <th scope="col" style="vertical-align: middle">Masa Aktivasi</th>
    </tr>
</thead>
<tbody >
    @foreach ($member as $datamember)
    <tr style="border-style:solid">
        
        <td>{{$datamember->ID_MEMBER}}</td>
        <td>{{$datamember->NAMA_MEMBER}}</td>
        <td>{{$datamember->ALAMAT_MEMBER}}</td>
        <td>{{$datamember->TELEPON_MEMBER}}</td>
        <td>{{$datamember->TANGGAL_LAHIR_MEMBER}}</td>
        <td class="text-center">
            @if ($datamember->SISA_DEPOSIT_KELAS === null)
                0
            @else
                {{ $datamember->SISA_DEPOSIT_KELAS }}
            @endif
        </td>
        <td class="text-center">
            @if ($datamember->SISA_DEPOSIT_MEMBER === null)
                0
            @else
                {{ $datamember->SISA_DEPOSIT_MEMBER }}
            @endif
        </td>
        <td class="text-center ">{{ $datamember->MASA_AKTIVASI }}</td>
        
                
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