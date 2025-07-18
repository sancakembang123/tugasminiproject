<form action="/karyawan/update/{{ $karyawan->nik }}" method="POST" id="frmeditkaryawan" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-12">
            <div class="input-icon mb-3">
                <span class="input-icon-addon"></span>
                <input type="text" value="{{ $karyawan->nik }}" id="nik" class="form-control" name="nik" readonly>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="input-icon mb-3">
                <span class="input-icon-addon"></span>
                <input type="text" value="{{ $karyawan->nama_lengkap }}" id="nama_lengkap" class="form-control" name="nama_lengkap" placeholder="Nama Lengkap">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="input-icon mb-3">
                <span class="input-icon-addon"></span>
                <input type="text" id="jabatan" value="{{ $karyawan->jabatan }}" class="form-control" placeholder="Jabatan" name="jabatan">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="input-icon mb-3">
                <span class="input-icon-addon"></span>
                <input type="text" id="no_hp" value="{{ $karyawan->no_hp }}" class="form-control" placeholder="No. Hp" name="no_hp">
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <input type="file" name="foto" class="form-control">
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <select name="kode_dept" id="kode_dept" class="form-select">
                <option value="">Departemen</option>
                @foreach ($departemen as $d)
                    <option {{ $d->kode_dept == $karyawan->kode_dept ? 'selected' : '' }} value="{{ $d->kode_dept }}">{{ $d->nama_dept }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <button type="submit" class="btn btn-primary w-100">Update</button>
        </div>
    </div>
</form>
