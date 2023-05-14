<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BacaanController;
use App\Http\Controllers\TataibadahController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\JadwalkegiatanController;
use App\Http\Controllers\RenunganController;
use App\Http\Controllers\PetugasController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('bacaan',BacaanController::class);
    Route::resource('tataibadah',TataibadahController::class);
    Route::resource('pengumuman',PengumumanController::class);
    Route::resource('jadwalkegiatan',JadwalkegiatanController::class);
    Route::resource('renungan',RenunganController::class);
    Route::resource('petugas',PetugasController::class);
});

require __DIR__.'/auth.php';
