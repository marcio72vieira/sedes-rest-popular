<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\MunicipioController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\ProdutoController;
use App\Http\Controllers\Admin\MedidaController;


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


Route::get('/', function () {
    return view('login');
});

Route::get('/login', function () {
    return view('login');
});



// =====================
// RECURSOS - RESOURCES
// =====================
Route::prefix('admin')->name('admin.')->group(function() {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['auth']);

    Route::resource('municipio', MunicipioController::class);
    Route::resource('categoria', CategoriaController::class);
    Route::resource('produto', ProdutoController::class);
    Route::resource('medida', MedidaController::class);

});
