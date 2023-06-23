@extends('dashboard')
@section('container')

{{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script> --}}


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 mb-1">Transaksi Aktivasi</h1>
</div>

<form action="{{ url('/konfirmasiAktivasi') }}" method="get" enctype="multipart/form-data" class="ml-2 mr-2">
    <div class="form-group">
        <label>Member</label>
        <select class="form-control mb-3" aria-label="select member" name="ID_MEMBER">
            <option value="" hidden>Pilih Member</option>
            @if ($members->first() != null)
                @foreach ($members as $item_member)
                    <option value="{{ $item_member->ID_MEMBER }}">
                        {{ $item_member->NAMA_MEMBER }}</option>
                @endforeach
            @else
                <option value=""disabled>All member has been activated</option>
            @endif

        </select>
        <label class="font-weight-bold mb-2">Activation Date</label>
        <input type='text' class="form-control mb-3"name="TANGGAL_TRANSAKSI_AKTIVASI"
            placeholder="Input date of birth member" autocomplete="off"
            value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" disabled />

        <label class="font-weight-bold mb-2">Expired Date</label>
        <input type='text' class="form-control mb-3"name="TANGGAL_EXPIRED" placeholder="Input date of birth member"
            autocomplete="off" value="{{ Carbon\Carbon::now()->addYears(1)->format('Y-m-d') }}" disabled />

        <button type="submit" class="btn btn-info">Submit</button>
    </div>
</form>

<div class="table-responsive">
<table class="table table-striped table-sm text-center" style="border-style:solid; border-color:#4e73df">
    <thead style="border-style:solid">
        <tr style="background-color:#4e73df; color:white; border-style:solid; border-color:#4e73df;:center">
        <th scope="col" style="vertical-align: middle">ID Transaksi Aktivasi</th>
        <th scope="col" style="vertical-align: middle">Nama Member</th>
        <th scope="col" style="vertical-align: middle">Nama Kasir</th>
        <th scope="col" style="vertical-align: middle">Tanggal Transaksi</th>
        <th scope="col" style="vertical-align: middle">Tanggal Expired</th>
        <th scope="col" style="vertical-align: middle">Status</th>
        <th scope="col" style="vertical-align: middle">Biaya</th>
        <th scope="col" colspan="4" style="vertical-align: middle">Aksi</th>
    </tr>
</thead>
<tbody >
    @foreach ($aktivasi as $item)
    <tr style="border-style:solid">
        
        <td>{{$item->ID_TRANSAKSI_AKTIVASI}}</td>
        <td>{{$item->member->NAMA_MEMBER}}</td>
        <td>{{$item->pegawai->NAMA_PEGAWAI}}</td>
        <td>{{$item->TANGGAL_TRANSAKSI_AKTIVASI}}</td>
        <td>{{$item->TANGGAL_EXPIRED}}</td>
        <td>{{$item->STATUS}}</td>
        <td>{{$item->BIAYA_AKTIVASI}}</td>
        
        <td>
            {{-- cetak transaksi aktivasi --}}
            <a href="{{url ('/cetaktransaksiaktivasi/'. $item->ID_TRANSAKSI_AKTIVASI)}}" class="text-primary">
                <button type="submit" class="btn btn-info btn-xs" style="width:80px">
                    <span class="glyphicon glyphicon-remove"></span> Cetak
                </button>
            </td>   
    </tr>
            @endforeach
        </tbody>
    </table>
    {{ $aktivasi->links() }}
</div>
@endsection
