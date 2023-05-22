<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controller\UsermobileController;
use App\Http\Controller\TataibadahController;
use App\Http\Controller\JadwalkegiatanController;
use App\Http\Controller\RenunganController;
use App\Http\Controller\BacaanController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login','UsermobileController@login');
Route::post('/register','UsermobileController@register');
Route::post('/usermobileUpdate','UsermobileController@userUpdate');
Route::get('/usermobileDetail/{id}','UsermobileController@userDetail');

//tataibadah mobile
Route::get('/listtataibadah','TataibadahController@listtataibadahapi');
Route::get('/tataibadahdetail/{id}','TataibadahController@apidetail');

//jadwalkegiatan
Route::get('/listjadwalkegiatan','JadwalkegiatanController@listjadwalkegiatan');

//bacaan mobile
Route::get('/listbacaan','BacaanController@listbacaan');
Route::get('/bacaandetail/{id}','BacaanController@bacaandetail');

//pengumuman mobile
Route::get('/listpengumuman','PengumumanController@listpengumuman');
Route::get('/pengumumandetail/{id}','PengumumanController@pengumumandetail');

//renungan mobile
Route::get('/listrenungan','RenunganController@listrenungan');
Route::get('/renungandetail/{id}','RenunganController@renungandetail');

//petugas mobile
Route::get('/listpetugas','PetugasController@listpetugas');
Route::get('/petugasdetail/{id}','PetugasController@petugasdetail');