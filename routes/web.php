<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AcessoController;
use App\Http\Controllers\Admin\EmpresaController;
use App\Http\Controllers\Admin\NutricionistaController;
//  use App\Http\Controllers\Admin\CompanhiaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MunicipioController;
use App\Http\Controllers\Admin\BairroController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\ProdutoController;
use App\Http\Controllers\Admin\MedidaController;
use App\Models\Nutricionista;

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

/* Route::get('/', function () {
    return view('template.templateadmin');
}); */


//==========================================================
//REDIRECIONA PARA A PÁGINA DE LOGIN AO ACESSAR RAIZ DO SITE
//==========================================================
Route::get('/', function () {
    return redirect()->route('acesso.login');
});


//==================================
//ROTAS DE LOGIN/LOGOUT/AUTENTICAÇÃO
//==================================
Route::get('/acesso/login', [AcessoController::class, 'login'])->name('acesso.login');
Route::post('/acesso/check', [AcessoController::class, 'check'])->name('acesso.check');
Route::get('/acesso/logout', [AcessoController::class, 'logout'])->name('acesso.logout');


// =====================
// RECURSOS - RESOURCES
// =====================
Route::prefix('admin')->name('admin.')->group(function() {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['auth']);

    // Companhia
    // Route::post('getbairros',[CompanhiaController::class, 'getbairros'])->name('getbairros');
    // Route::resource('companhia', CompanhiaController::class);

    // Empresa
    Route::post('getbairros',[EmpresaController::class, 'getbairros'])->name('getbairros');
    Route::resource('empresa', EmpresaController::class);

    // Nutricionista (Rota aninhada) fica do tipo: empresa/1/nutricionista.
    Route::resource('empresa.nutricionista', NutricionistaController::class);

    // Municipio
    Route::post('getamountbairros',[MunicipioController::class, 'getamountbairros'])->name('getamountbairros');
    Route::resource('municipio', MunicipioController::class);

    Route::resource('bairro', BairroController::class);
    Route::resource('categoria', CategoriaController::class);
    Route::resource('produto', ProdutoController::class);
    Route::resource('medida', MedidaController::class);

    

    // Users
    Route::resource('user', UserController::class);
    Route::get('user/{id}/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::put('/user/{id}/updateprofile', [UserController::class, 'updateprofile'])->name('user.updateprofile');

});
