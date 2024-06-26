<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AcessoController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MonitorController;
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
use App\Http\Controllers\Admin\RegistroconsultacompraController; //RegistroconsultaController

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



//=============================================
//ROTA DO DASHBOARD (SEM SER DO TIPO RESOURCE)
//=============================================
// Dashboard
Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard')->middleware(['auth']);

//=============================================
//ROTA DO MONITOR (SEM SER DO TIPO RESOURCE)
//=============================================
// Monitor
Route::get('monitor/{tipo}', [MonitorController::class, 'index'])->name('admin.monitor')->middleware(['auth']);
Route::get('ajaxgetRecordsEmpty',[MonitorController::class,'ajaxgetRecordsEmpty'])->name('admin.ajaxgetRecordsEmpty')->middleware(['auth']);
Route::get('ajaxgetRegionaisComprasMensais',[MonitorController::class,'ajaxgetRegionaisComprasMensais'])->name('admin.ajaxgetRegionaisComprasMensais')->middleware(['auth']);
Route::get('ajaxgetMunicipiosComprasMensais',[MonitorController::class,'ajaxgetMunicipiosComprasMensais'])->name('admin.ajaxgetMunicipiosComprasMensais')->middleware(['auth']);
Route::get('ajaxgetRestaurantesComprasMensais',[MonitorController::class,'ajaxgetRestaurantesComprasMensais'])->name('admin.ajaxgetRestaurantesComprasMensais')->middleware(['auth']);
Route::get('ajaxgetCategoriasComprasMensais',[MonitorController::class,'ajaxgetCategoriasComprasMensais'])->name('admin.ajaxgetCategoriasComprasMensais')->middleware(['auth']);
Route::get('ajaxgetProdutosComprasMensais',[MonitorController::class,'ajaxgetProdutosComprasMensais'])->name('admin.ajaxgetProdutosComprasMensais')->middleware(['auth']);
Route::get('ajaxgetProdutosDaCategoriaComprasMensais',[MonitorController::class,'ajaxgetProdutosDaCategoriaComprasMensais'])->name('admin.ajaxgetProdutosDaCategoriaComprasMensais')->middleware(['auth']);
Route::get('ajaxgetCategoriasPorEntidadeComprasMensais',[MonitorController::class,'ajaxgetCategoriasPorEntidadeComprasMensais'])->name('admin.ajaxgetCategoriasPorEntidadeComprasMensais')->middleware(['auth']);
Route::get('ajaxgetProdutosPorEntidadeComprasMensais',[MonitorController::class,'ajaxgetProdutosPorEntidadeComprasMensais'])->name('admin.ajaxgetProdutosPorEntidadeComprasMensais')->middleware(['auth']);
Route::get('ajaxgetCarregaRegistrosDaEntidade',[MonitorController::class,'ajaxgetCarregaRegistrosDaEntidade'])->name('admin.ajaxgetCarregaRegistrosDaEntidade')->middleware(['auth']);
Route::get('ajaxgetComprasPorCategoriasOuProdutos',[MonitorController::class,'ajaxgetComprasPorCategoriasOuProdutos'])->name('admin.ajaxgetComprasPorCategoriasOuProdutos')->middleware(['auth']);
Route::get('admin/monitor/{identidade}/{idcategoria?}/{idproduto?}/{idano}/pdf/relpdfmonitorgeral', [MonitorController::class, 'relpdfmonitorgeral'])->name('admin.monitor.relpdfmonitorgeral')->middleware(['auth']);
Route::get('admin/monitor/{identidade}/{idcategoria?}/{idproduto?}/{idmes}/{idano}/pdf/relpdfmonitorgeralmensal', [MonitorController::class, 'relpdfmonitorgeralmensal'])->name('admin.monitor.relpdfmonitorgeralmensal')->middleware(['auth']);
Route::get('admin/monitor/{identidade}/{idregistro}/{idtipopesquisa}/{idano}/pdf/relpdfmonitorespecifico', [MonitorController::class, 'relpdfmonitorespecifico'])->name('admin.monitor.relpdfmonitorespecifico')->middleware(['auth']);
Route::get('admin/monitor/{identidade}/{idregistro}/{idtipopesquisa}/{idmes}/{idano}/pdf/relpdfmonitorespecificomensal', [MonitorController::class, 'relpdfmonitorespecificomensal'])->name('admin.monitor.relpdfmonitorespecificomensal')->middleware(['auth']);
Route::get('admin/monitor/{identidade}/{idregistro}/{idcategoria?}/{idproduto?}/{idano}/pdf/relpdfmonitorgeralsubgrupo', [MonitorController::class, 'relpdfmonitorgeralsubgrupo'])->name('admin.monitor.relpdfmonitorgeralsubgrupo')->middleware(['auth']);

Route::get('admin/monitor/{identidade}/{idcategoria?}/{idproduto?}/{idano}/pdf/relpdfmonitorgeralprimeirosemestre', [MonitorController::class, 'relpdfmonitorgeralprimeirosemestre'])->name('admin.monitor.relpdfmonitorgeralprimeirosemestre')->middleware(['auth']);

// =====================
// RECURSOS - RESOURCES
// =====================
Route::prefix('admin')->name('admin.')->group(function() {

    // Dashboard
    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['auth']);
    // Companhia
    // Route::post('getbairros',[CompanhiaController::class, 'getbairros'])->name('getbairros');
    // Route::resource('companhia', CompanhiaController::class);


    // Dashboard
    // Dashboard sendo a rota como do tipo resource
    // Route::resource('dashboard', DashboardController::class)->except(['create', 'show', 'edit', 'update'])->middleware(['auth']);


    // Restaurante
    Route::post('getbairrosrestaurante',[RestauranteController::class, 'getbairrosrestaurante'])->name('getbairrosrestaurante')->middleware(['auth']);
    Route::post('getnutricionistasempresas',[RestauranteController::class, 'getnutricionistasempresas'])->name('getnutricionistasempresas')->middleware(['auth']);
    Route::resource('restaurante', RestauranteController::class)->middleware(['auth']);
    Route::get('ajaxgetRestaurantes',[RestauranteController::class,'ajaxgetRestaurantes'])->name('ajaxgetRestaurantes');    // Rota Ajax para datatable com paginação dinâmica


    // Empresa
    Route::post('getbairros',[EmpresaController::class, 'getbairros'])->name('getbairros')->middleware(['auth']);
    Route::resource('empresa', EmpresaController::class)->middleware(['auth']);
    Route::get('empresa/{id}/listarnutricionistas', [EmpresaController::class, 'listarnutricionistas'])->name('empresa.listarnutricionistas')->middleware(['auth']);

    // Nutricionista (Rota aninhada) fica do tipo: empresa/1/nutricionista.
    Route::resource('empresa.nutricionista', NutricionistaController::class)->middleware(['auth']);
    // Rota para remanejar nutricionista de uma empresa para outra
    Route::put('/nutricionista/{idempresa}/{idnutricionista}/remaneja', [NutricionistaController::class, 'remaneja'])->name('nutricionista.remaneja')->middleware(['auth']);

    // Compra (Rota aninhada) fica do tipo: restaurante/1/Compra. So acessa essa rota se estiver autenticado e for administrador ou proprietario.
    // Route::resource('restaurante.compra', CompraController::class)->middleware(['auth','comprarestrita']); Só utilize este middleware quando não utilizar o HELP mrc_encryp_decrypt
    Route::resource('restaurante.compra', CompraController::class)->middleware(['auth']);

    // Comprovante (Rota aninhada) fica do tipo: compra/1/comprovante. So acessa essa rota se estiver autenticado e for administrador ou proprietario.
    //Route::resource('compra.comprovante', ComprovanteController::class)->except(['show', 'edit', 'update'])->middleware(['auth', 'comprovanterestrito']); ; Só utilize este middleware quando não utilizar o HELP mrc_encryp_decrypt
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
Route::get('admin/registroconsultacompra/registro', [RegistroconsultacompraController::class, 'index'])->name('admin.registroconsultacompra.index')->middleware(['auth']);
Route::get('admin/registroconsultacompra/consulta', [RegistroconsultacompraController::class, 'search'])->name('admin.registroconsultacompra.search')->middleware(['auth']);
Route::get('admin/registroconsultacompra/producaorestmesano',[RegistroconsultacompraController::class, 'producaorestmesano'])->name('admin.consulta.producaorestmesano')->middleware(['auth']);
Route::get('admin/registroconsultacompra/comprasemanalmensalrestaurante',[RegistroconsultacompraController::class, 'comprasemanalmensalrestaurante'])->name('admin.consulta.comprasemanalmensalrestaurante')->middleware(['auth']);
Route::get('admin/registroconsultacompra/compramensalmunicipio',[RegistroconsultacompraController::class, 'compramensalmunicipio'])->name('admin.consulta.compramensalmunicipio')->middleware(['auth']);
Route::get('admin/registroconsultacompra/compramensalregionalproduto',[RegistroconsultacompraController::class, 'compramensalregionalproduto'])->name('admin.consulta.compramensalregionalproduto')->middleware(['auth']);
Route::get('admin/registroconsultacompra/compramensalmunicipiovalor',[RegistroconsultacompraController::class, 'compramensalmunicipiovalor'])->name('admin.consulta.compramensalmunicipiovalor')->middleware(['auth']);
Route::get('admin/registroconsultacompra/ajaxgetdetalhecompra',[RegistroconsultacompraController::class, 'ajaxgetdetalhecompra'])->name('admin.consulta.ajaxgetdetalhecompra')->middleware(['auth']);
Route::get('admin/registroconsultacompra/compramensalregiaovalor',[RegistroconsultacompraController::class, 'compramensalregiaovalor'])->name('admin.consulta.compramensalregiaovalor')->middleware(['auth']);
Route::get('admin/registroconsultacompra/ajaxgetdetalhecompramensalregiaovalor',[RegistroconsultacompraController::class, 'ajaxgetdetalhecompramensalregiaovalor'])->name('admin.consulta.ajaxgetdetalhecompramensalregiaovalor')->middleware(['auth']);
Route::get('admin/registroconsultacompra/mapamensalprodutorestaurante',[RegistroconsultacompraController::class, 'mapamensalprodutorestaurante'])->name('admin.consulta.mapamensalprodutorestaurante')->middleware(['auth']);
Route::get('admin/registroconsultacompra/mapamensalprodutomunicipio',[RegistroconsultacompraController::class, 'mapamensalprodutomunicipio'])->name('admin.consulta.mapamensalprodutomunicipio')->middleware(['auth']);
Route::get('admin/registroconsultacompra/mapamensalprodutoregional',[RegistroconsultacompraController::class, 'mapamensalprodutoregional'])->name('admin.consulta.mapamensalprodutoregional')->middleware(['auth']);
Route::get('admin/registroconsultacompra/mapamensalgeralproduto',[RegistroconsultacompraController::class, 'mapamensalgeralproduto'])->name('admin.consulta.mapamensalgeralproduto')->middleware(['auth']);
Route::get('admin/registroconsultacompra/mapamensalcategoriarestaurante',[RegistroconsultacompraController::class, 'mapamensalcategoriarestaurante'])->name('admin.consulta.mapamensalcategoriarestaurante')->middleware(['auth']);
Route::get('admin/registroconsultacompra/mapamensalcategoriamunicipio',[RegistroconsultacompraController::class, 'mapamensalcategoriamunicipio'])->name('admin.consulta.mapamensalcategoriamunicipio')->middleware(['auth']);
Route::get('admin/registroconsultacompra/mapamensalcategoriaregional',[RegistroconsultacompraController::class, 'mapamensalcategoriaregional'])->name('admin.consulta.mapamensalcategoriaregional')->middleware(['auth']);
Route::get('admin/registroconsultacompra/mapamensalgeralcategoria',[RegistroconsultacompraController::class, 'mapamensalgeralcategoria'])->name('admin.consulta.mapamensalgeralcategoria')->middleware(['auth']);

Route::get('admin/registroconsultacompra/ajaxgetmedidaproduto', [RegistroconsultacompraController::class, 'ajaxgetmedidaproduto'])->name('admin.registroconsultacompra.ajaxgetmedidaproduto')->middleware(['auth']);
Route::get('admin/registroconsultacompra/comparativomensalprodutomunicipio',[RegistroconsultacompraController::class, 'comparativomensalprodutomunicipio'])->name('admin.consulta.comparativomensalprodutomunicipio')->middleware(['auth']);
Route::get('admin/registroconsultacompra/comparativomensalprodutoregional',[RegistroconsultacompraController::class, 'comparativomensalprodutoregional'])->name('admin.consulta.comparativomensalprodutoregional')->middleware(['auth']);
Route::get('admin/registroconsultacompra/comparativomensalgeralproduto',[RegistroconsultacompraController::class, 'comparativomensalgeralproduto'])->name('admin.consulta.comparativomensalgeralproduto')->middleware(['auth']);

Route::get('admin/registroconsultacompra/ajaxgetmedidacategoria', [RegistroconsultacompraController::class, 'ajaxgetmedidacategoria'])->name('admin.registroconsultacompra.ajaxgetmedidacategoria')->middleware(['auth']);
Route::get('admin/registroconsultacompra/comparativomensalcategoriamunicipio',[RegistroconsultacompraController::class, 'comparativomensalcategoriamunicipio'])->name('admin.consulta.comparativomensalcategoriamunicipio')->middleware(['auth']);
Route::get('admin/registroconsultacompra/comparativomensalcategoriaregional',[RegistroconsultacompraController::class, 'comparativomensalcategoriaregional'])->name('admin.consulta.comparativomensalcategoriaregional')->middleware(['auth']);
Route::get('admin/registroconsultacompra/comparativomensalgeralcategoria',[RegistroconsultacompraController::class, 'comparativomensalgeralcategoria'])->name('admin.consulta.comparativomensalgeralcategoria')->middleware(['auth']);




/***********************************************/
/*   ROTAS PARA DADOS DOS GRÁFICOS VIA AJAX    */
/***********************************************/
//Compras :Registros e Consultas
//Route::get('admin/dashboard/ajaxgraficodadosproduto', [DashboardController::class, 'ajaxgraficodadosproduto'])->name('admin.dashboard.ajaxgraficodadosproduto')->middleware(['auth']);
//Route::get('admin/dashboard/ajaxgraficodadoscategoria', [DashboardController::class, 'ajaxgraficodadoscategoria'])->name('admin.dashboard.ajaxgraficodadoscategoria')->middleware(['auth']);
//Route::get('admin/dashboard/ajaxgraficodadosregional', [DashboardController::class, 'ajaxgraficodadosregional'])->name('admin.dashboard.ajaxgraficodadosregional')->middleware(['auth']);
Route::get('admin/dashboard/ajaxrecuperadadosgrafico', [DashboardController::class, 'ajaxrecuperadadosgrafico'])->name('admin.dashboard.ajaxrecuperadadosgrafico')->middleware(['auth']);
Route::get('admin/dashboard/ajaxrecuperadadosgraficomesesanospesquisa', [DashboardController::class, 'ajaxrecuperadadosgraficomesesanospesquisa'])->name('admin.dashboard.ajaxrecuperadadosgraficomesesanospesquisa')->middleware(['auth']);
Route::get('admin/dashboard/ajaxrecuperadadosgraficoempilhado', [DashboardController::class, 'ajaxrecuperadadosgraficoempilhado'])->name('admin.dashboard.ajaxrecuperadadosgraficoempilhado')->middleware(['auth']);
Route::get('admin/dashboard/ajaxrecuperadadosgraficoempilhadocategoriaproduto', [DashboardController::class, 'ajaxrecuperadadosgraficoempilhadocategoriaproduto'])->name('admin.dashboard.ajaxrecuperadadosgraficoempilhadocategoriaproduto')->middleware(['auth']);

Route::get('admin/dashboard/ajaxrecuperadadosgraficomesames', [DashboardController::class, 'ajaxrecuperadadosgraficomesames'])->name('admin.dashboard.ajaxrecuperadadosgraficomesames')->middleware(['auth']);

// Rotas para recuperação dinâmica dos Selects para Municípios e Restaurantes a partir das Regionais mês a mês MONITOR
Route::get('admin/dashboard/ajaxrecuperamunicipiosregionais',[DashboardController::class, 'ajaxrecuperamunicipiosregionais'])->name('admin.dashboard.ajaxrecuperamunicipiosregionais')->middleware(['auth']);
Route::get('admin/dashboard/ajaxrecuperarestaurantesmunicipios',[DashboardController::class, 'ajaxrecuperarestaurantesmunicipios'])->name('admin.dashboard.ajaxrecuperarestaurantesmunicipios')->middleware(['auth']);
Route::get('admin/dashboard/ajaxrecuperadadosgraficomesamesmonitor', [DashboardController::class, 'ajaxrecuperadadosgraficomesamesmonitor'])->name('admin.dashboard.ajaxrecuperadadosgraficomesamesmonitor')->middleware(['auth']);

// Rota para recuperar produtos específicos de uma categoria escolhida no mês e ano corrente
Route::get('admin/dashboard/ajaxgetprodutosdacategoriamesano', [DashboardController::class, 'ajaxgetprodutosdacategoriamesano'])->name('admin.dashboard.ajaxgetprodutosdacategoriamesano')->middleware(['auth']);
Route::get('admin/dashboard/ajaxrecuperadadosgraficoproduto', [DashboardController::class, 'ajaxrecuperadadosgraficoproduto'])->name('admin.dashboard.ajaxrecuperadadosgraficoproduto')->middleware(['auth']);

/**************************************************/
/*   ROTAS PARA DADOS DAS ENTIDADES VISÃO RÁPIDA  */
/**************************************************/
Route::get('admin/dashboard/ajaxrecuperadadosentidades', [DashboardController::class, 'ajaxrecuperadadosentidades'])->name('admin.dashboard.ajaxrecuperadadosentidades')->middleware(['auth']);
Route::get('admin/dashboard/ajaxrecuperainformacoesregistro', [DashboardController::class, 'ajaxrecuperainformacoesregistro'])->name('admin.dashboard.ajaxrecuperainformacoesregistro')->middleware(['auth']);
Route::get('admin/dashboard/ajaxrecuperacomprasdoproduto', [DashboardController::class, 'ajaxrecuperacomprasdoproduto'])->name('admin.dashboard.ajaxrecuperacomprasdoproduto')->middleware(['auth']);




/***********************************************/
/*   ROTAS PARA RELATÓRIOS PDF's, Excel e CSV  */
/***********************************************/
// RELATÓRIOS USUÁRIOS
Route::get('admin/user/pdf/relpdfuser', [UserController::class, 'relpdfuser'])->name('admin.user.relpdfuser')->middleware(['auth']);


// RELATÓRIOS EMPRESAS
Route::get('admin/empresa/pdf/relpdfempresa', [EmpresaController::class, 'relpdfempresa'])->name('admin.empresa.relpdfempresa')->middleware(['auth']);
Route::get('admin/empresa/{id}/pdf/relpdfempresanutricionistas', [EmpresaController::class, 'relpdfempresanutricionistas'])->name('admin.empresa.relpdfempresanutricionistas')->middleware(['auth']);


// RELATÓRIOS RESTAURANTES
Route::get('admin/restaurante/pdf/relpdfrestaurante', [RestauranteController::class, 'relpdfrestaurante'])->name('admin.restaurante.relpdfrestaurante')->middleware(['auth']);


// RELATÓRIOS REGIONAIS
Route::get('admin/regional/pdf/relpdfregional', [RegionalController::class, 'relpdfregional'])->name('admin.regional.relpdfregional')->middleware(['auth']);
Route::get('admin/regional/{id}/pdf/relpdfregionalmunicipios', [RegionalController::class, 'relpdfregionalmunicipios'])->name('admin.regional.relpdfregionalmunicipios')->middleware(['auth']);
Route::get('admin/regional/{id}/pdf/relpdfregionalrestaurantes', [RegionalController::class, 'relpdfregionalrestaurantes'])->name('admin.regional.relpdfregionalrestaurantes')->middleware(['auth']);


// RELATÓRIOS MUNICÍPIOS
Route::get('admin/municipio/pdf/relpdfmunicipio', [MunicipioController::class, 'relpdfmunicipio'])->name('admin.municipio.relpdfmunicipio')->middleware(['auth']);
Route::get('admin/municipio/{id}/pdf/relpdfmunicipiobairros', [MunicipioController::class, 'relpdfmunicipiobairros'])->name('admin.municipio.relpdfmunicipiobairros')->middleware(['auth']);
Route::get('admin/municipio/{id}/pdf/relpdfmunicipiorestaurantes', [MunicipioController::class, 'relpdfmunicipiorestaurantes'])->name('admin.municipio.relpdfmunicipiorestaurantes')->middleware(['auth']);



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


// RELATÓRIOS REGISTROCONSULTACOMPRA
Route::get('admin/registroconsultacompra/{idrest}/{semana}/{mes}/{ano}/pdf/relpdfcomprassemana', [RegistroconsultacompraController::class, 'relpdfcomprassemana'])->name('admin.registroconsultacompra.comprassemana.relpdfcomprassemana')->middleware(['auth']);
Route::get('admin/registroconsultacompra/{idrest}/{mes}/{ano}/pdf/relpdfcomprasmes', [RegistroconsultacompraController::class, 'relpdfcomprasmes'])->name('admin.registroconsultacompra.comprasmes.relpdfcomprasmes')->middleware(['auth']);
Route::get('admin/registroconsultacompra/{idrest}/{mes}/{ano}/pdf/relpdfproducaorestaurantemesano', [RegistroconsultacompraController::class, 'relpdfproducaorestaurantemesano'])->name('admin.registroconsultacompra.relpdfproducaorestaurantemesano')->middleware(['auth']);
Route::get('admin/registroconsultacompra/{idmun}/{mes}/{ano}/pdf/relpdfcompramensalmunicipio', [RegistroconsultacompraController::class, 'relpdfcompramensalmunicipio'])->name('admin.registroconsultacompra.relpdfcompramensalmunicipio')->middleware(['auth']);
Route::get('admin/registroconsultacompra/{idreg}/{mes}/{ano}/pdf/relpdfcompramensalregionalproduto', [RegistroconsultacompraController::class, 'relpdfcompramensalregionalproduto'])->name('admin.registroconsultacompra.relpdfcompramensalregionalproduto')->middleware(['auth']);
Route::get('admin/registroconsultacompra/{idmun}/{mes}/{ano}/pdf/relpdfcompramensalmunicipiovalor', [RegistroconsultacompraController::class, 'relpdfcompramensalmunicipiovalor'])->name('admin.registroconsultacompra.relpdfcompramensalmunicipiovalor')->middleware(['auth']);
Route::get('admin/registroconsultacompra/{idreg}/{mes}/{ano}/pdf/relpdfcompramensalregiaovalor', [RegistroconsultacompraController::class, 'relpdfcompramensalregiaovalor'])->name('admin.registroconsultacompra.relpdfcompramensalregiaovalor')->middleware(['auth']);
Route::get('admin/registroconsultacompra/{idrest}/{mes}/{ano}/pdf/relpdfmapamensalprodutorestaurante', [RegistroconsultacompraController::class, 'relpdfmapamensalprodutorestaurante'])->name('admin.registroconsultacompra.relpdfmapamensalprodutorestaurante')->middleware(['auth']);
Route::get('admin/registroconsultacompra/{idmun}/{mes}/{ano}/pdf/relpdfmapamensalprodutomunicipio', [RegistroconsultacompraController::class, 'relpdfmapamensalprodutomunicipio'])->name('admin.registroconsultacompra.relpdfmapamensalprodutomunicipio')->middleware(['auth']);
Route::get('admin/registroconsultacompra/{idreg}/{mes}/{ano}/pdf/relpdfmapamensalprodutoregional', [RegistroconsultacompraController::class, 'relpdfmapamensalprodutoregional'])->name('admin.registroconsultacompra.relpdfmapamensalprodutoregional')->middleware(['auth']);
Route::get('admin/registroconsultacompra/{mes}/{ano}/pdf/relpdfmapamensalgeralproduto', [RegistroconsultacompraController::class, 'relpdfmapamensalgeralproduto'])->name('admin.registroconsultacompra.relpdfmapamensalgeralproduto')->middleware(['auth']);
Route::get('admin/registroconsultacompra/{idrest}/{mes}/{ano}/pdf/relpdfmapamensalcategoriarestaurante', [RegistroconsultacompraController::class, 'relpdfmapamensalcategoriarestaurante'])->name('admin.registroconsultacompra.relpdfmapamensalcategoriarestaurante')->middleware(['auth']);
Route::get('admin/registroconsultacompra/{idmun}/{mes}/{ano}/pdf/relpdfmapamensalcategoriamunicipio', [RegistroconsultacompraController::class, 'relpdfmapamensalcategoriamunicipio'])->name('admin.registroconsultacompra.relpdfmapamensalcategoriamunicipio')->middleware(['auth']);
Route::get('admin/registroconsultacompra/{idreg}/{mes}/{ano}/pdf/relpdfmapamensalcategoriaregional', [RegistroconsultacompraController::class, 'relpdfmapamensalcategoriaregional'])->name('admin.registroconsultacompra.relpdfmapamensalcategoriaregional')->middleware(['auth']);
Route::get('admin/registroconsultacompra/{mes}/{ano}/pdf/relpdfmapamensalgeralcategoria', [RegistroconsultacompraController::class, 'relpdfmapamensalgeralcategoria'])->name('admin.registroconsultacompra.relpdfmapamensalgeralcategoria')->middleware(['auth']);

Route::get('admin/registroconsultacompra/{idprod}/{idmedi}/{idmun}/{mes}/{ano}/pdf/relpdfcomparativomensalprodutomunicipio', [RegistroconsultacompraController::class, 'relpdfcomparativomensalprodutomunicipio'])->name('admin.registroconsultacompra.relpdfcomparativomensalprodutomunicipio')->middleware(['auth']);
Route::get('admin/registroconsultacompra/{idprod}/{idmedi}/{idreg}/{mes}/{ano}/pdf/relpdfcomparativomensalprodutoregional', [RegistroconsultacompraController::class, 'relpdfcomparativomensalprodutoregional'])->name('admin.registroconsultacompra.relpdfcomparativomensalprodutoregional')->middleware(['auth']);
Route::get('admin/registroconsultacompra/{idprod}/{idmedi}/{mes}/{ano}/pdf/relpdfcomparativomensalgeralproduto', [RegistroconsultacompraController::class, 'relpdfcomparativomensalgeralproduto'])->name('admin.registroconsultacompra.relpdfcomparativomensalgeralproduto')->middleware(['auth']);

Route::get('admin/registroconsultacompra/{idcateg}/{idmedi}/{idmun}/{mes}/{ano}/pdf/relpdfcomparativomensalcategoriamunicipio', [RegistroconsultacompraController::class, 'relpdfcomparativomensalcategoriamunicipio'])->name('admin.registroconsultacompra.relpdfcomparativomensalcategoriamunicipio')->middleware(['auth']);
Route::get('admin/registroconsultacompra/{idcateg}/{idmedi}/{idreg}/{mes}/{ano}/pdf/relpdfcomparativomensalcategoriaregional', [RegistroconsultacompraController::class, 'relpdfcomparativomensalcategoriaregional'])->name('admin.registroconsultacompra.relpdfcomparativomensalcategoriaregional')->middleware(['auth']);
Route::get('admin/registroconsultacompra/{idcateg}/{idmedi}/{mes}/{ano}/pdf/relpdfcomparativomensalgeralcategoria', [RegistroconsultacompraController::class, 'relpdfcomparativomensalgeralcategoria'])->name('admin.registroconsultacompra.relpdfcomparativomensalgeralcategoria')->middleware(['auth']);

// Relatorio EXCEL
Route::get('admin/dashboard/gerarexcel', [DashboardController::class, 'gerarexcel'])->name('admin.dashboard.gerarexcel')->middleware(['auth']);
