@extends('dashboard')
@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 mb-1">Data Instruktur</h1>
</div>
<div class="" display=flex>
    <a href="/tambahinstruktur">
        <button type="button" class="btn btn-primary float-right mb-3">Tambah Instruktur</button>
    </a>
</div>
<div class="table-responsive" >
<table class="table table-striped table-sm text-center" style="border-style:solid; border-color:#4e73df">
    <thead style="border-style:solid">
    <tr style="background-color:#4e73df; color:white; border-style:solid; border-color:#4e73df;:center">
        <th scope="col">ID INSTRUKTUR</th>
        <th scope="col" style="vertical-align: middle">Nama</th>
        <th scope="col" style="vertical-align: middle">Alamat</th>
        <th scope="col" style="vertical-align: middle">No Telepon</th>
        <th scope="col">Tanggal Lahir</th>
        <th scope="col" style="vertical-align: middle">Email</th>
        <th scope="col" style="vertical-align: middle">Password</th>
        <th scope="col" colspan="3" style="vertical-align: middle">Aksi</th>
    </tr>
    </thead>
    <tbody>
        @foreach ($instruktur as $datainstruktur)
    <tr style="border-style:solid">
        <td>{{$datainstruktur->ID_INSTRUKTUR}}</td>
        <td>{{$datainstruktur->NAMA_INSTRUKTUR}}</td>
        <td>{{$datainstruktur->ALAMAT_INSTRUKTUR}}</td>
        <td>{{$datainstruktur->TELEPON_INSTRUKTUR}}</td>
        <td>{{$datainstruktur->TANGGAL_LAHIR_INSTRUKTUR}}</td>
        <td>{{$datainstruktur->EMAIL_INSTRUKTUR}}</td>
        <td>{{$datainstruktur->password}}</td>
        <td>
            {{-- edit memmber--}}
            <span class="mdi mdi-delete-alert"></span>
            <a href="{{ url("editinstrukturpage/".$datainstruktur->ID_INSTRUKTUR)}}" class="text-primary">
                <button type="submit" class="btn btn-success btn-xs" style="width:80px">
                    <span class="glyphicon glyphicon-remove"></span> Edit
                </button>
            </span></a></i>
        </td>

        <td>
            {{-- delete member --}}
            <form form onsubmit="return confirm('Apakah anda ingin menghapus data instruktur?');"
                action="{{ url('/deleteinstruktur/' . $datainstruktur->ID_INSTRUKTUR) }}" method="POST">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-danger btn-xs" style="width:80px">
                    <span class="glyphicon glyphicon-remove"></span> Delete
                </button>
            </form>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
{{ $instruktur->links('pagination::bootstrap-5') }}
</div>

@endsection

@section('search-container')
<form action ="{{url ('/searchinstruktur')}}" method="get"
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