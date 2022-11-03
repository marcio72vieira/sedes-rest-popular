<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AcessoController;
use App\Http\Controllers\Admin\EmpresaController;
use App\Http\Controllers\Admin\RestauranteController;
use App\Http\Controllers\Admin\NutricionistaController;
use App\Http\Controllers\Admin\CompraController;
//  use App\Http\Controllers\Admin\CompanhiaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RegionalController;
use App\Http\Controllers\Admin\MunicipioController;
use App\Http\Controllers\Admin\BairroController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\ComprovanteController;
use App\Http\Controllers\Admin\ProdutoController;
use App\Http\Controllers\Admin\MedidaController;
use App\Http\Controllers\Admin\RegistrocompraController; //RegistroconsultaController

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
    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['auth']);
    // Companhia
    // Route::post('getbairros',[CompanhiaController::class, 'getbairros'])->name('getbairros');
    // Route::resource('companhia', CompanhiaController::class);

    // Restaurante
    Route::post('getbairrosrestaurante',[RestauranteController::class, 'getbairrosrestaurante'])->name('getbairrosrestaurante')->middleware(['auth']);
    Route::post('getnutricionistasempresas',[RestauranteController::class, 'getnutricionistasempresas'])->name('getnutricionistasempresas')->middleware(['auth']);
    Route::resource('restaurante', RestauranteController::class)->middleware(['auth']);

    // Empresa
    Route::post('getbairros',[EmpresaController::class, 'getbairros'])->name('getbairros')->middleware(['auth']);
    Route::resource('empresa', EmpresaController::class)->middleware(['auth']);
    Route::get('empresa/{id}/listarnutricionistas', [EmpresaController::class, 'listarnutricionistas'])->name('empresa.listarnutricionistas')->middleware(['auth']);

    // Nutricionista (Rota aninhada) fica do tipo: empresa/1/nutricionista.
    Route::resource('empresa.nutricionista', NutricionistaController::class)->middleware(['auth']);

    // Compra (Rota aninhada) fica do tipo: restaurante/1/Compra.
    Route::resource('restaurante.compra', CompraController::class)->middleware(['auth']);

    // Comprovante (Rota aninhada) fica do tipo: compra/1/comprovante
    Route::resource('compra.comprovante', ComprovanteController::class)->except(['show', 'edit', 'update'])->middleware(['auth']);


    // Regional
    Route::resource('regional', RegionalController::class)->middleware(['auth']);
    Route::get('regional/{id}/listarmunicipios', [RegionalController::class, 'listarmunicipios'])->name('regional.listarmunicipios')->middleware(['auth']);


    // Municipio
    // Impede a exclusão de um município, no caso de haver algum bairro associado a ele através da rota 'getmountbairros'
    Route::post('getamountbairros',[MunicipioController::class, 'getamountbairros'])->name('getamountbairros')->middleware(['auth']);
    Route::resource('municipio', MunicipioController::class)->middleware(['auth']);
    Route::get('municipio/{id}/listarbairros', [MunicipioController::class, 'listarbairros'])->name('municipio.listarbairros')->middleware(['auth']);

    // Categorias
    Route::resource('categoria', CategoriaController::class)->middleware(['auth']);
    Route::get('categoria/{id}/listarprodutos', [CategoriaController::class, 'listarprodutos'])->name('categoria.listarprodutos')->middleware(['auth']);



    Route::resource('bairro', BairroController::class)->middleware(['auth']);
    Route::resource('produto', ProdutoController::class)->middleware(['auth']);
    Route::resource('medida', MedidaController::class)->middleware(['auth']);


    // Users
    Route::resource('user', UserController::class)->middleware(['auth']);
    Route::get('user/{id}/profile', [UserController::class, 'profile'])->name('user.profile')->middleware(['auth']);
    Route::put('/user/{id}/updateprofile', [UserController::class, 'updateprofile'])->name('user.updateprofile')->middleware(['auth']);

});



/***********************************************/
/*   ROTAS PARA REGISTRO E CONSULTA DE COMPRAS */
/***********************************************/
//Compras :Registros e Consultas
Route::get('admin/registrocompra', [RegistrocompraController::class, 'index'])->name('admin.registrocompra.index')->middleware(['auth']);
Route::get('admin/registroconsulta', [RegistrocompraController::class, 'search'])->name('admin.registroconsulta.search')->middleware(['auth']);

Route::get('admin/registrocompra/producaorestmesano',[RegistrocompraController::class, 'producaorestmesano'])->name('admin.consulta.producaorestmesano')->middleware(['auth']);



/***********************************************/
/*   ROTAS PARA RELATÓRIOS PDF's, Excel e CSV  */
/***********************************************/
// RELATÓRIOS EMPRESAS
Route::get('admin/empresa/pdf/relpdfempresa', [EmpresaController::class, 'relpdfempresa'])->name('admin.empresa.relpdfempresa')->middleware(['auth']);
Route::get('admin/empresa/{id}/pdf/relpdfempresanutricionistas', [EmpresaController::class, 'relpdfempresanutricionistas'])->name('admin.empresa.relpdfempresanutricionistas')->middleware(['auth']);


// RELATÓRIOS RESTAURANTES
Route::get('admin/restaurante/pdf/relpdfrestaurante', [RestauranteController::class, 'relpdfrestaurante'])->name('admin.restaurante.relpdfrestaurante')->middleware(['auth']);


// RELATÓRIOS REGIONAIS
Route::get('admin/regional/pdf/relpdfregional', [RegionalController::class, 'relpdfregional'])->name('admin.regional.relpdfregional')->middleware(['auth']);
Route::get('admin/regional/{id}/pdf/relpdfregionalmunicipios', [RegionalController::class, 'relpdfregionalmunicipios'])->name('admin.regional.relpdfregionalmunicipios')->middleware(['auth']);



// RELATÓRIOS MUNICÍPIOS
Route::get('admin/municipio/pdf/relpdfmunicipio', [MunicipioController::class, 'relpdfmunicipio'])->name('admin.municipio.relpdfmunicipio')->middleware(['auth']);
Route::get('admin/municipio/{id}/pdf/relpdfmunicipiobairros', [MunicipioController::class, 'relpdfmunicipiobairros'])->name('admin.municipio.relpdfmunicipiobairros')->middleware(['auth']);



// RELATÓRIOS BAIRROS
Route::get('admin/bairro/pdf/relpdfbairro', [BairroController::class, 'relpdfbairro'])->name('admin.bairro.relpdfbairro')->middleware(['auth']);



// RELATÓRIOS CATEGORIAS
Route::get('admin/categoria/pdf/relpdfcategoria', [CategoriaController::class, 'relpdfcategoria'])->name('admin.categoria.relpdfcategoria')->middleware(['auth']);
Route::get('admin/categoria/{id}/pdf/relpdfcategoriaprodutos', [CategoriaController::class, 'relpdfcategoriaprodutos'])->name('admin.categoria.relpdfcategoriaprodutos')->middleware(['auth']);



// RELATÓRIOS PRODUTOS
Route::get('admin/produto/pdf/relpdfproduto', [ProdutoController::class, 'relpdfproduto'])->name('admin.produto.relpdfproduto')->middleware(['auth']);



// RELATÓRIOS MEDIDAS
Route::get('admin/medida/pdf/relpdfmedida', [MedidaController::class, 'relpdfmedida'])->name('admin.medida.relpdfmedida')->middleware(['auth']);




// RELATÓRIOS COMPRAS
//Route::get('admin/compra/pdf/{id}/relpdfcompra', [CompraController::class, 'relpdfcompra'])->name('admin.compra.relpdfcompra')->middleware(['auth']);
Route::get('admin/restaurante/{idrest}/compra/{idcompra}/pdf/relpdfcompra', [CompraController::class, 'relpdfcompra'])->name('admin.restaurante.compra.relpdfcompra')->middleware(['auth']);


// RELATÓRIOS REGISTROSCOMPRA - REGISTROCONSULTA
Route::get('admin/registrocompra/{idrest}/mes/pdf/relpdfcomprasmes', [RegistrocompraController::class, 'relpdfcomprasmes'])->name('admin.registrocompra.comprasmes.relpdfcomprasmes')->middleware(['auth']);
