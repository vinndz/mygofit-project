@extends('dashboard')
@section('container')

{{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script> --}}


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 mb-1">Transaksi Deposit Uang</h1>
</div>


<form action="{{ url('/konfirmasideposituang') }}" method="get" enctype="multipart/form-data" class="ml-2 mr-2">
    <div class="form-group">
        <label>Member</label>
        <select class="form-control mb-3" aria-label="select member" name="ID_MEMBER">
            <option value="" hidden>Select Member</option>
            @if ($member->first() != null)
                @foreach ($member as $item_member)
                    <option value="{{ $item_member->ID_MEMBER }}">
                        {{ $item_member->NAMA_MEMBER }}</option>
                @endforeach
            @else
                <option value=""disabled>All member has been activated</option>
            @endif

        </select>

        <label class="font-weight-bold mb-2">Input Nominal Deposit</label>
        <input type='text' class="form-control mb-3"name="JUMLAH_DEPOSIT"
            placeholder="Input Nominal" autocomplete="off" />

        <label class="font-weight-bold mb-2">Activation Date</label>
        <input type='text' class="form-control mb-3"name="TANGGAL_DEPOSIT_UANG"
            placeholder="Input date of birth member" autocomplete="off"
            value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" disabled />

        
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>


<div class="table-responsive">
<table class="table table-striped table-sm text-center" style="border-style:solid; border-color:#4e73df">
    <thead style="border-style:solid">
        <tr style="background-color:#4e73df; color:white; border-style:solid; border-color:#4e73df;:center">
        <th scope="col" style="vertical-align: middle">ID Transaksi Deposit Uang</th>
        <th scope="col" style="vertical-align: middle">NAMA PROMO</th>
        <th scope="col" style="vertical-align: middle">NAMA MEMBER</th>
        <th scope="col" style="vertical-align: middle">NAMA PEGAWAI</th>
        <th scope="col" style="vertical-align: middle">Jumlah Deposit</th>
        <th scope="col" style="vertical-align: middle">Bonus Deposit Kelas</th>
        <th scope="col" style="vertical-align: middle">Sisa Deposit</th>
        <th scope="col" style="vertical-align: middle">Total Deposit Kelas</th>
        <th scope="col" style="vertical-align: middle">Tanggal Deposit Uang</th>
        <th scope="col" colspan="4" style="vertical-align: middle">Aksi</th>
    </tr>
</thead>
<tbody >
    @foreach ($transaksiUang as $item)
    <tr style="border-style:solid">
        
        <td>{{$item->ID_TRANSAKSI_DEPOSIT_UANG}}</td>
            @if ($item->ID_PROMO != null)
                <td class="col-md-1">{{ $item->promo->NAMA_PROMO }}</td>
            @else
                <td class="col-md-1">-</td>
        @endif  
        <td>{{$item->member->NAMA_MEMBER}}</td>
        <td>{{$item->pegawai->NAMA_PEGAWAI}}</td>
        <td>{{$item->JUMLAH_DEPOSIT}}</td>
        <td>{{$item->BONUS_DEPOSIT}}</td>
        <td>{{$item->SISA_DEPOSIT}}</td>
        <td>{{$item->TOTAL_DEPOSIT}}</td>
        <td>{{$item->TANGGAL_DEPOSIT_UANG}}</td>
        <td>
            
            <a href="{{url ('/cetakdeposituang/'. $item->ID_TRANSAKSI_DEPOSIT_UANG)}}" class="text-primary">
                <button type="submit" class="btn btn-info btn-xs" style="width:80px">
                    <span class="glyphicon glyphicon-remove"></span> Cetak
                </button>
        </td>   
    </tr>
            @endforeach
        </tbody>
    </table>
    {{ $transaksiUang->links() }}
</div>
@endsection
