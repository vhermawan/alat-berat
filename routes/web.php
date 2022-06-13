<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Store\AdminController;
use App\Http\Controllers\Store\BiayaOperasionalController;
use App\Http\Controllers\Store\BiayaSewaController;
use App\Http\Controllers\Store\ProduktivitasController;
use App\Http\Controllers\Store\KebutuhanAlatController;
use App\Http\Controllers\Store\RekapitulasiController;
use App\Http\Controllers\Store\AlatBeratController;
use App\Http\Controllers\Store\VolumeController;
use App\Http\Controllers\Store\ProyekController;
use App\Http\Controllers\Auth\LoginController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return redirect('login');
});

Auth::routes();

Route::get('/admin',[AdminController::class, 'index']);
Route::get('/rekapitulasi',[RekapitulasiController::class, 'index']);
Route::get('/rekapitulasi-biaya-operasional',[RekapitulasiController::class, 'rekapBiayaOperasional'])->name('rekapitulasi.list');
Route::get('/rekapitulasi-keuntungan',[RekapitulasiController::class, 'rekapKeuntungan'])->name('rekapKeuntungan.list');
Route::get('/biaya-operasional',[BiayaOperasionalController::class, 'index']);
Route::get('/biaya-sewa',[BiayaSewaController::class, 'index']);
Route::get('/produktivitas',[ProduktivitasController::class, 'index']);
Route::get('/kebutuhan-alat',[KebutuhanAlatController::class, 'index']);
Route::get('/tipe-alat-berat',[AlatBeratController::class, 'indexTipe']);
Route::get('/jenis-alat-berat',[AlatBeratController::class, 'indexJenis']);
Route::get('/volume-pekerjaan',[VolumeController::class, 'index']);
Route::get('/proyek',[ProyekController::class, 'index']);


/*proyek */
Route::post('/create-proyek',[ProyekController::class, 'store'])->name('proyek.store');
Route::get('/all-proyek',[ProyekController::class, 'listProyek'])->name('proyek.list');
Route::delete('/delete-proyek/{id}',[ProyekController::class, 'destroy'])->name('proyek.destroy');
Route::put('/update-proyek/{id}',[ProyekController::class, 'update'])->name('proyek.update');

/*jenis alat */
Route::post('/create-jenis-alat',[AlatBeratController::class, 'storeJenisAlat'])->name('jenisAlat.store');
Route::get('/all-jenis-alat',[AlatBeratController::class, 'listJenisAlat'])->name('jenisAlat.list');
Route::delete('/delete-jenis-alat/{id}',[AlatBeratController::class, 'destroyJenisAlat'])->name('jenisAlat.destroy');
Route::put('/update-jenis-alat/{id}',[AlatBeratController::class, 'updateJenisAlat'])->name('jenisAlat.update');
Route::get('/filter-jenis-alat/{id}',[AlatBeratController::class, 'filterJenisAlat'])->name('jenisAlat.filter');

/*tipe alat */
Route::post('/create-tipe-alat',[AlatBeratController::class, 'storeTipeAlat'])->name('tipeAlat.store');
Route::get('/all-tipe-alat',[AlatBeratController::class, 'listTipeAlat'])->name('tipeAlat.list');
Route::delete('/delete-tipe-alat/{id}',[AlatBeratController::class, 'destroyTipeAlat'])->name('tipeAlat.destroy');
Route::put('/update-tipe-alat/{id}',[AlatBeratController::class, 'updateTipeAlat'])->name('tipeAlat.update');
Route::get('/filter-tipe-alat/{id}',[AlatBeratController::class, 'filterTipeAlat'])->name('tipeAlat.filter');

/*volume pekerjaan*/
Route::post('/create-volume-pekerjaan',[VolumeController::class, 'store'])->name('volumePekerjaan.store');
Route::get('/all-volume-pekerjaan',[VolumeController::class, 'listvolumePekerjaan'])->name('volumePekerjaan.list');
Route::delete('/delete-volume-pekerjaan/{id}',[VolumeController::class, 'destroy'])->name('volumePekerjaan.destroy');
Route::put('/update-volume-pekerjaan/{id}',[VolumeController::class, 'update'])->name('volumePekerjaan.update');

/*produktivitas */
Route::post('/create-produktivitas',[ProduktivitasController::class, 'store'])->name('produktivitas.store');
Route::get('/all-produktivitas',[ProduktivitasController::class, 'listProduktivitas'])->name('produktivitas.list');
Route::delete('/delete-produktivitas/{id}',[ProduktivitasController::class, 'destroy'])->name('produktivitas.destroy');
Route::put('/update-produktivitas/{id}',[ProduktivitasController::class, 'update'])->name('produktivitas.update');
Route::get('/filter-tipe-produktivitas/{id}',[ProduktivitasController::class, 'filterProduktivitas'])->name('produktivitas.filter');
Route::get('/filter-tipe-produktivitas-by-jenis-id/{id}',[ProduktivitasController::class, 'filterKebutuhanAlatbyTipeAlat'])->name('produktivitasbyTipeAlat.filter');


/*kebutuhan alat */
Route::post('/create-kebutuhan-alat',[KebutuhanAlatController::class, 'store'])->name('kebutuhanAlat.store');
Route::get('/all-kebutuhan-alat',[KebutuhanAlatController::class, 'listkebutuhanAlat'])->name('kebutuhanAlat.list');
Route::delete('/delete-kebutuhan-alat/{id}',[KebutuhanAlatController::class, 'destroy'])->name('kebutuhanAlat.destroy');
Route::put('/update-kebutuhan-alat/{id}',[KebutuhanAlatController::class, 'update'])->name('kebutuhanAlat.update');
Route::get('/filter-kebutuhan-alat/{id}',[KebutuhanAlatController::class, 'filterkebutuhanAlat'])->name('kebutuhanAlat.filter');
Route::get('/filter-kebutuhan-alat-by-jenis-id/{id}',[KebutuhanAlatController::class, 'filterKebutuhanAlatbyTipeAlat'])->name('kebutuhanAlatbyTipeAlat.filter');

/*biaya operasional */
Route::post('/create-biaya-operasional',[BiayaOperasionalController::class, 'store'])->name('biayaOperasional.store');
Route::get('/all-biaya-operasional',[BiayaOperasionalController::class, 'listBiayaOperasional'])->name('biayaOperasional.list');
Route::delete('/delete-biaya-operasional/{id}',[BiayaOperasionalController::class, 'destroy'])->name('biayaOperasional.destroy');
Route::put('/update-biaya-operasional/{id}',[BiayaOperasionalController::class, 'update'])->name('biayaOperasional.update');
Route::get('/filter-biaya-operasional/{id}',[BiayaOperasionalController::class, 'filterBiayaOperasional'])->name('biayaOperasional.filter');
Route::get('/filter-biaya-operasional-by-jenis-alat/{id}',[BiayaOperasionalController::class, 'filterBiayaOperasionalbyJenisAlat'])->name('biayaOperasionalbyJenisAlat.filter');

/*biaya sewa*/
Route::post('/create-biaya-sewa',[BiayaSewaController::class, 'store'])->name('biayaSewa.store');
Route::get('/all-biaya-sewa',[BiayaSewaController::class, 'listBiayaSewa'])->name('biayaSewa.list');
Route::delete('/delete-biaya-sewa/{id}',[BiayaSewaController::class, 'destroy'])->name('biayaSewa.destroy');
Route::put('/update-biaya-sewa/{id}',[BiayaSewaController::class, 'update'])->name('biayaSewa.update');
Route::get('/filter-biaya-sewa/{id}',[BiayaSewaController::class, 'filterBiayaSewa'])->name('biayaSewa.filter');
Route::get('/filter-biaya-sewa-by-jenis-alat/{id}',[BiayaSewaController::class, 'filterBiayaSewabyJenisAlat'])->name('biayaSewabyJenisAlat.filter');

/*admin */
Route::post('/create-admin',[AdminController::class, 'store'])->name('admin.store');
Route::get('/admins',[AdminController::class, 'listAdmin'])->name('admin.list');
Route::delete('/delete-admin/{id}',[AdminController::class, 'destroy'])->name('admin.destroy');
Route::put('/update-admin/{id}',[AdminController::class, 'update'])->name('admin.update');

Route::get('/home', function () {
  return redirect('/rekapitulasi');
});
