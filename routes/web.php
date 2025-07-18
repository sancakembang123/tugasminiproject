<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;

Route::middleware(['guest:karyawan'])->group(function() {
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');
    Route::post('/proseslogin', [AuthController::class, 'proseslogin']);
});


Route::middleware(['guest:user'])->group(function() {
    Route::get('/panel', function () {
        return view('auth.loginadmin');
    })->name('loginadmin');

    Route::post('/prosesloginadmin', [AuthController::class, 'prosesloginadmin']);
});






Route::middleware(['auth:karyawan'])->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/proseslogout', [AuthController::class, 'proseslogout']);

     //Presensi
     Route::get('/presensi/create', [PresensiController::class, 'create']);
     Route::post('/presensi/store', [PresensiController::class, 'store']);

     //Edit Profile
     Route::get('/editprofile', [PresensiController::class, 'editprofile']);
     Route::post('/presensi/{nik}/updateprofile', [PresensiController::class, 'updateprofile']);

     //Histori
     Route::get('/presensi/histori', [PresensiController::class, 'histori']);
     Route::post('/gethistori', [PresensiController::class, 'gethistori']);

     //Izin

     Route::get('/presensi/izin', [PresensiController::class, 'izin']);
     Route::get('/presensi/buatizin', [PresensiController::class, 'buatizin']);
     Route::post('/presensi/storeizin', [PresensiController::class, 'storeizin']);
});

Route::middleware(['auth:user'])->group(function(){
    Route::get('/proseslogoutadmin', [AuthController::class, 'proseslogoutadmin']);
    Route::get('/panel/dashboardadmin', [DashboardController::class, 'dashboardadmin']);

    //karyawan
    Route::get('/karyawan', [KaryawanController::class, 'index']);
     Route::post('/karyawan/store', [KaryawanController::class, 'store']);
     Route::post('/karyawan/edit', [KaryawanController::class, 'edit']);
     Route::match(['post', 'put'], '/karyawan/update/{nik}', [KaryawanController::class, 'update'])->name('karyawan.update');
});

