<?php
  
use Illuminate\Support\Facades\Route;
  

  
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
  
//Route::get('/', function () {
//    return view('welcome');
//});
//php artisan optimize:clear
//untuk clear view
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('beranda');
Auth::routes();
  
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
  
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::resource('products', App\Http\Controllers\ProductController::class);
    Route::resource('provinces', App\Http\Controllers\ProvinceController::class);
    Route::resource('jeniskunjungans', App\Http\Controllers\JenisKunjunganController::class);
    Route::resource('jenisperawatans', App\Http\Controllers\JenisPerawatanController::class);
    Route::resource('specialities', App\Http\Controllers\SpecialityController::class);
    Route::resource('cities', App\Http\Controllers\CityController::class);
    Route::resource('districts', App\Http\Controllers\DistrictController::class);
    Route::resource('koderekenings', App\Http\Controllers\KodeRekeningController::class);
    Route::resource('jurnals', App\Http\Controllers\JurnalController::class);
    Route::resource('medicalrecords', App\Http\Controllers\RekamMedisController::class);
    Route::get('medicalrecords/{rekammedis}/penanggungjawab', [App\Http\Controllers\RekamMedisController::class,'penanggung_jawab'])->name('medicalrecords.penanggungjawab');
    Route::resource('doctors', App\Http\Controllers\DokterController::class);
    Route::resource('doctor_schedules', App\Http\Controllers\JadwalDokterController::class);
    Route::resource('doctorfees', App\Http\Controllers\JasaDokterController::class);
    Route::resource('serviceunits', App\Http\Controllers\ServiceUnitController::class);
    Route::resource('grouplayanans', App\Http\Controllers\GroupLayananController::class);
    Route::resource('layanans', App\Http\Controllers\LayananController::class);
    Route::resource('layananunits', App\Http\Controllers\LayananUnitServiceController::class);
    Route::resource('rooms', App\Http\Controllers\RuangController::class);
    Route::resource('appointments', App\Http\Controllers\AppointmentController::class);
    //Route::resource('registrations', KunjunganPasienController::class);
    Route::get('lain',[App\Http\Controllers\RekamMedisController::class,'index_lain'])->name('lain');
    Route::get('keuangan/kunjungan/pasien',[App\Http\Controllers\KeuanganController::class,'kunjungan'])->name('keuangan.kunjungan.pasien');
    Route::get('keuangan/{kunjungan}/transaksi',[App\Http\Controllers\KeuanganController::class,'index'])->name('keuangan.transaksi');
    Route::get('keuangan/{kunjungan}/pembayaran',[App\Http\Controllers\KeuanganController::class,'create'])->name('keuangan.pembayaran');
    Route::post('keuangan/{kunjungan}/pembayaran/create',[App\Http\Controllers\KeuanganController::class,'store'])->name('keuangan.pembayaran.create');

    Route::get('farmasi/kunjungan/pasien',[App\Http\Controllers\FarmasiController::class,'kunjungan'])->name('farmasi.kunjungan.pasien');
    Route::get('farmasi/{kunjungan}/transaksi',[App\Http\Controllers\FarmasiController::class,'index'])->name('farmasi.transaksi');
    Route::get('farmasi/{kunjungan}/transaksi/addmedicine',[App\Http\Controllers\FarmasiController::class,'add_medicine'])->name('farmasi.transaksi.addmedicine');
    Route::get('farmasi/{kunjungan}/transaksi/delete',[App\Http\Controllers\FarmasiController::class,'destroy'])->name('farmasi.transaksi.delete');
    Route::post('farmasi/{kunjungan}/transaksi/savemedicine',[App\Http\Controllers\FarmasiController::class,'save_medicine'])->name('farmasi.transaksi.savemedicine');
    Route::get('registrations',[App\Http\Controllers\KunjunganPasienController::class,'index'])->name('registrations.index');
    Route::post('registrations/store',[App\Http\Controllers\KunjunganPasienController::class,'store'])->name('registrations.store');
    Route::get('registrations/patient/search',[App\Http\Controllers\KunjunganPasienController::class,'patients_search'])->name('registrations.patient.search');
    Route::get('registrations/{rekammedis}/doctor/search',[App\Http\Controllers\KunjunganPasienController::class,'doctors_search'])->name('registrations.doctors.search');
    //Route::get('registrations/{rekammedis}/{jadwal}/create',[KunjunganPasienController::class,'create'])->name('registrations.create');
    Route::get('registrations/{rekammedis}/create',[App\Http\Controllers\KunjunganPasienController::class,'create_registration'])->name('registrations.create');
    Route::get('registrations/create',[App\Http\Controllers\KunjunganPasienController::class,'create'])->name('registrations.registration');
    Route::get('registrations/online',[App\Http\Controllers\KunjunganPasienController::class,'konsultasi_online'])->name('registrations.online');
    Route::get('registrations/create/online',[App\Http\Controllers\KunjunganPasienController::class,'create_konsultasi_online'])->name('registrations.create.online');
    Route::get('registrations/store/online',[App\Http\Controllers\KunjunganPasienController::class,'create_registration_online'])->name('registrations.store.online');
    Route::get('registrations/update/online',[App\Http\Controllers\KunjunganPasienController::class,'create_registration_online'])->name('registrations.update.online');
});