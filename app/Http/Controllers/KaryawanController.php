<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {

        $query = Karyawan::query();
        $query->select('karyawan.*', 'nama_dept');
        $query->join('departemen', 'karyawan.kode_dept', '=', 'departemen.kode_dept');
        $query->orderBy('nama_lengkap');
        if(!empty($request->nama_karyawan)) {
            $query->where('nama_lengkap', 'like', '%' .$request->nama_karyawan. '%');
        }
        if(!empty($request->kode_dept)) {
            $query->where('karyawan.kode_dept', $request->kode_dept);
        }
        $karyawan = $query->paginate(10);
        $departemen = DB::table('departemen')->get();
        return view('karyawan.index', compact('karyawan', 'departemen'));
    }

   public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'nik' => 'required|unique:karyawan,nik',
        'nama_lengkap' => 'required|string|max:100',
        'jabatan' => 'required|string|max:50',
        'no_hp' => 'required|string|max:15',
        'kode_dept' => 'required|exists:departemen,kode_dept',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $nik = $request->nik;
    $foto = null;

    // Jika ada upload foto
    if ($request->hasFile('foto')) {
        $foto = $nik . '.' . $request->file('foto')->getClientOriginalExtension();
    }

    try {
        $data = [
            'nik' => $nik,
            'nama_lengkap' => $request->nama_lengkap,
            'jabatan' => $request->jabatan,
            'no_hp' => $request->no_hp,
            'kode_dept' => $request->kode_dept,
            'foto' => $foto,
            'password' => Hash::make('12345') // bisa diganti Str::random(8)
        ];

        $simpan = DB::table('karyawan')->insert($data);

        if ($simpan && $foto) {
            $request->file('foto')->storeAs('public/uploads/karyawan/', $foto);
        }

        return Redirect::back()->with(['success' => 'Data Berhasil Disimpan']);
    } catch (\Exception $e) {
        return Redirect::back()->with(['warning' => 'Data Gagal Disimpan: ' . $e->getMessage()]);
    }
}

public function edit(Request $request)
{
    $nik = $request->nik;
    $departemen = DB::table('departemen')->get();
    $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
    return view('karyawan.edit', compact('departemen', 'karyawan'));
}

public function update(Request $request, $nik) {
    $request->validate([
        'nama_lengkap' => 'required|string|max:100',
        'jabatan' => 'required|string|max:50',
        'no_hp' => 'required|string|max:15',
        'kode_dept' => 'required|exists:departemen,kode_dept',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $data = [
        'nama_lengkap' => $request->nama_lengkap,
        'jabatan' => $request->jabatan,
        'no_hp' => $request->no_hp,
        'kode_dept' => $request->kode_dept,
    ];

    if ($request->hasFile('foto')) {
        $foto = $nik . '.' . $request->file('foto')->getClientOriginalExtension();
        $request->file('foto')->storeAs('public/uploads/karyawan/', $foto);
        $data['foto'] = $foto;
    }

    DB::table('karyawan')->where('nik', $nik)->update($data);

    return redirect::back()->with('success', 'Data berhasil diupdate');
}


}
