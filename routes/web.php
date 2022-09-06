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

Route::get('/', function () {
    return view('template.templateadmin');
});



// =====================
// RECURSOS - RESOURCES
// =====================
Route::prefix('admin')->name('admin.')->group(function() {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['auth']);

    /*
    // Users
    Route::resource('user', UserController::class);
    Route::get('user/{id}/profile', [UserController::class, 'profile'])->name('user.profile')->middleware(['auth']);
    Route::put('/user/{id}/updateprofile', [UserController::class, 'updateprofile'])->name('user.updateprofile')->middleware(['auth']);

    // Municipio
    Route::post('getamountbairros',[MunicipioController::class, 'getamountbairros'])->name('getamountbairros');
    Route::resource('municipio', MunicipioController::class);

    // Bairro
    Route::resource('bairro', BairroController::class)->middleware(['auth']);

    // Banco
    Route::resource('banco', BancoController::class)->middleware(['auth']);

    // Empresa
    Route::post('getbairros',[EmpresaController::class, 'getbairros'])->name('getbairros');
    Route::resource('empresa', EmpresaController::class);
    */
});
