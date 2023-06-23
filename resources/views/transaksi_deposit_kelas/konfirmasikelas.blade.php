@extends('dashboard')
@section('container')
    <div class="card bg-body rounded d-flex justify-content-center align-items-center" style="min-height: 100vh">
        <div class="card overflow-hidden" style="width: 50rem;">
            <div class="ml-2 p-4">
                <form action="{{ url('/storedepokelas') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group col-md-12">
                        <p>ID : {{ $member->ID_MEMBER }}</p>
                        <p>NAMA : {{ $member->NAMA_MEMBER }}</p>
                        <p>NAMA KELAS : {{ $NAMA_KELAS }}</p>
        
                    </div>
        
                    <div class="form-row mb-2">
                        <div class="form-group col-md-6">
                            <input type='text' class="form-control mb-3"name="ID_MEMBER"
                                    placeholder="Input date of birth member" autocomplete="off" value="{{ $member->ID_MEMBER }}"
                                    hidden />
        
                            <input type='text' class="form-control mb-3"name="ID_KELAS"
                                    placeholder="Input date of birth member" autocomplete="off" value="{{ $ID_KELAS }}"
                                    hidden />
        
                            <label class="font-weight-bold mb-2"><b>Deposit Class Amount</b></label>
                                <input type='number' class="form-control mb-3"name="JUMLAH_DEPOSIT_KELAS"
                                    placeholder="Input Deposit Amount" autocomplete="off"
                                    value="{{ $JUMLAH_DEPOSIT_KELAS }}" readonly />
        
                            <label class="font-weight-bold mb-2">Date of Transaction</label>
                             <input type='text' class="form-control mb-3"name="TANGGAL_DEPOSIT_KELAS"
                                    placeholder="" autocomplete="off"
                                    value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" disabled />

                                <label class="font-weight-bold mb-2">Total Pembayaran</label>
                             <input type='text' class="form-control mb-3"name="TANGGAL_DEPOSIT_KELAS"
                                    placeholder="" autocomplete="off"
                                    value="{{ $BIAYA }}" disabled />
        
                             <label class="font-weight-bold mb-2 mt-2"><b>Payment Money</b> </label>
                                <input type='text' class="form-control mb-3"name="JUMLAH_UANG" placeholder="Input your money"
                                autocomplete="off" />
                            </div>
                    </div>
                        @error('JUMLAH_UANG')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
        
                        @error('JUMLAH_DEPOSIT_KELAS')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
        
                    <a href="{{ url('/transaksiDepositKelas') }}" class="btn btn-danger">
                        Cancel
                    </a>
                    <button class="btn btn-primary" type="submit">
                        Save
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endsection
