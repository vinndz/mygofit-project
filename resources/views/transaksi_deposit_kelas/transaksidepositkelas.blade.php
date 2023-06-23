@extends('dashboard')
@section('container')

{{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script> --}}


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 mb-1">Transaksi Deposit Kelas</h1>
</div>

<form action="{{ url('/konfirmasidepositkelas') }}" method="get" enctype="multipart/form-data" class="ml-2 mr-2">
    
    <div class="form-group">
        <label>Member</label>
        <select class="form-control mb-3" aria-label="select member" name="ID_MEMBER">
            <option value="" hidden>Pilih Member</option>
            @if ($member->first() != null)
                @foreach ($member as $item_member)
                    <option value="{{ $item_member->ID_MEMBER }}">
                        {{ $item_member->NAMA_MEMBER }}</option>
                @endforeach
            @else
                <option value=""disabled>All member has been activated</option>
            @endif

        </select>

        <label for="" class="form-label">Pilih Kelas</label>
                                <select class="form-control" aria-label="Default select example" name="ID_KELAS">
                                    <option value="" hidden>Pilih Kelas</option>
                                    @if ($kelas->first() != null)
                                        @foreach ($kelas as $item)
                                            <option value="{{ $item->ID_KELAS }}">
                                                {{ $item->NAMA_KELAS }}</option>
                                        @endforeach
                                    @else
                                        <option value=""disabled>...</option>
                                    @endif
                                </select>
                            </div>
                            <div class="mt-3">
                                <label for="" class="form-label">Pilih Paket</label>
                                <select class="form-control mb-3" aria-label="Default select example"
                                    name="JUMLAH_DEPOSIT_KELAS">
                                    <option value="" hidden>Jumlah Paket</option>
                                    <option value="5">5 Kelas</option>
                                    <option value="10">10 Kelas</option>
                                </select>
                            </div>
        <button type="submit" class="btn btn-primary mb-2">Submit</button>

</form>

<div class="table-responsive">
<table class="table table-striped table-sm text-center" style="border-style:solid; border-color:#4e73df">
    <thead style="border-style:solid">
        <tr style="background-color:#4e73df; color:white; border-style:solid; border-color:#4e73df;:center">
        <th scope="col" style="vertical-align: middle">ID Transaksi Paket</th>
        <th scope="col" style="vertical-align: middle">ID PROMO</th>
        <th scope="col" style="vertical-align: middle">NAMA MEMBER</th>
        <th scope="col" style="vertical-align: middle">NAMA_KELAS</th>
        <th scope="col" style="vertical-align: middle">Jumlah Deposit Kelas</th>
        <th scope="col" style="vertical-align: middle">Tanggal Deposit Kelas</th>
        <th scope="col" style="vertical-align: middle">Bonus Deposit Kelas</th>
        <th scope="col" style="vertical-align: middle">Total Deposit Kelas</th>
        <th scope="col" style="vertical-align: middle">Jumlah Pembayaran</th>
        <th scope="col" colspan="4" style="vertical-align: middle">Aksi</th>
    </tr>
</thead>
<tbody >
    @foreach ($transaksiKelas as $item)
    <tr style="border-style:solid">
        
        <td>{{$item->ID_TRANSAKSI_PAKET}}</td>
        <td>{{$item->promo->NAMA_PROMO}}</td>
        <td>{{$item->member->NAMA_MEMBER}}</td>
        <td>{{$item->kelas->NAMA_KELAS}}</td>
        <td>{{$item->JUMLAH_DEPOSIT_KELAS}}</td>
        <td>{{$item->TANGGAL_DEPOSIT_KELAS}}</td>
        <td>{{$item->BONUS_DEPOSIT_KELAS}}</td> 
        <td>{{$item->TOTAL_DEPOSIT_KELAS}}</td>
        <td>{{$item->JUMLAH_PEMBAYARAN}}</td>
        <td>
            
            <a href="{{url ('/cetakdepositkelas/'. $item->ID_TRANSAKSI_PAKET)}}" class="text-primary">
                <button type="submit" class="btn btn-info btn-xs" style="width:80px">
                    <span class="glyphicon glyphicon-remove"></span> Cetak
                </button>
        </td>   
    </tr>
            @endforeach
        </tbody>
    </table>
    {{ $transaksiKelas->links() }}
</div>
@endsection
