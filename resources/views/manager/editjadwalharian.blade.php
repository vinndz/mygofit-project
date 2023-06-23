@extends('dashboard')
@section('container')
    <div class="p-5 m-5 h-100" style="background-color: #4e73df; ">
        <h4 class="text-white">Edit Jadwal Harian</h4>
        <form action="{{ url('/updatejadwalharian/' . $jadwalHarian->TANGGAL_JADWAL_HARIAN) }}
            "method="post"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3" style="color:white">
                <label for="exampleInputEmail1" class="form-label">Instruktur</label>
                <select class="form-control" id="ID_INSTRUKTUR" name="ID_INSTRUKTUR">
                    <option value="" hidden>Pilih Instruktur</option>
                    @foreach ($instruktur as $itemInstruktur)
                        <option value="{{ $itemInstruktur->ID_INSTRUKTUR }}"
                            {{ $jadwalHarian->ID_INSTRUKTUR == $itemInstruktur->ID_INSTRUKTUR ? 'selected' : '' }}>
                            {{ $itemInstruktur->NAMA_INSTRUKTUR }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3" style="color:white">
                <label for="status" class="form-label">Status Jadwal Harian</label>
                <input type="text" class="form-control" name="KETERANGAN" placeholder="(-/Libur)"
                    value="{{ $jadwalHarian->KETERANGAN}}" />
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-success" name="add">Save</button>
            </div>
        </form>
    </div>
@endsection