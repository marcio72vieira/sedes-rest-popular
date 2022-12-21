<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Empresa;
use App\Models\Nutricionista;
use App\Models\Restaurante;
use App\Models\Compra;
use App\Models\Regional;
use App\Models\Municipio;
use App\Models\Categoria;
use App\Models\Produto;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        //$mes =  date('m');
        $mes =  date('m') -  1;

        $totEmpresas =  Empresa::all()->count();
        $totNutricionistas =  Nutricionista::all()->count();
        $totRestaurantes = Restaurante::all()->count();
        $totCompras = Compra::all()->count();
        $totRegionais = Regional::all()->count();
        $totMunicipios =  Municipio::all()->count();
        $totComprasNormal =  DB::table('compras')->whereMonth('data_ini', $mes)->sum('valor');
        $totComprasAf =  DB::table('compras')->whereMonth('data_ini', $mes)->sum('valoraf');
        $totalValorCompras =  $totComprasNormal + $totComprasAf;
        $totCategorias = Categoria::all()->count();
        $totProdutos =  Produto::all()->count();
        $totUsuarios =  User::all()->count();

        //Dados Produtos Para gráfico Principal com tradução
        $records = DB::select(DB::raw("SELECT produto_nome as nome, SUM(precototal) as totalcompra FROM bigtable_data WHERE MONTH(data_ini) = $mes GROUP BY produto_id ORDER BY totalcompra ASC"));
        

        //PARA TESTE DE EXIBIÇÃO DE DADOS EM REQUISIÇÕES AJAX
        //$records = $records = DB::select(DB::raw("SELECT produto_nome as nome, af, SUM(IF(af = 'sim', precototal, 0)) as totalcompraaf, SUM(IF(af = 'nao', precototal, 0)) as totalcompranormal, SUM(precototal) as totalcompra FROM bigtable_data WHERE MONTH(data_ini) = $mes GROUP BY produto_nome ORDER BY totalcompra ASC"));
        //dd($records);


        $dataRecords = [];
        foreach($records as $value) {
            $dataRecords[$value->nome] =  $value->totalcompra;
        }


        //Dados Méida de preco AF e NORMAL para grafico de linha prórpio
        $records = DB::select(DB::raw('SELECT regional_nome, produto_id, semana, semana_nome, preco, af, AVG(IF(af = "sim", preco, NULL)) AS mdprcaf, AVG(IF(af = "nao", preco, NULL)) AS mdprcnorm FROM bigtable_data WHERE regional_id = 1 AND MONTH(data_ini) = 11 AND produto_id = 1 AND YEAR(data_ini) = 2022 GROUP by produto_id, semana_nome ORDER BY semana ASC, mdprcnorm ASC, mdprcaf ASC'));
        $dataRecordsMediaPrecoAf = [];
        $dataRecordsMediaPrecoNorm = [];
        foreach($records as $value) {
            if($value->semana == 1){
                $dataRecordsMediaPrecoAf[] = $value->mdprcaf;
                $dataRecordsMediaPrecoNorm[] = $value->mdprcnorm;
            }
            if($value->semana == 2){
                $dataRecordsMediaPrecoAf[] = $value->mdprcaf;
                $dataRecordsMediaPrecoNorm[] = $value->mdprcnorm;
            }
            if($value->semana == 3){
                $dataRecordsMediaPrecoAf[] = $value->mdprcaf;
                $dataRecordsMediaPrecoNorm[] = $value->mdprcnorm;
            }
            if($value->semana == 4){
                $dataRecordsMediaPrecoAf[] = $value->mdprcaf;
                $dataRecordsMediaPrecoNorm[] = $value->mdprcnorm;
            }
            if($value->semana == 5){
                $dataRecordsMediaPrecoAf[] = $value->mdprcaf;
                $dataRecordsMediaPrecoNorm[] = $value->mdprcnorm;
            }
        }

        //Dados USUÁRIOS
        $usuarios = $records = DB::select(DB::raw('SELECT id, nomecompleto, perfil FROM users ORDER BY nomecompleto ASC'));



        return view('admin.dashboard.index', compact('totEmpresas', 'totNutricionistas', 'totRestaurantes', 'totCompras',
                                            'totalValorCompras', 'totComprasNormal', 'totComprasAf', 'totRegionais',
                                            'totMunicipios', 'totCategorias', 'totProdutos', 'totUsuarios', 'dataRecords', 'dataRecordsMediaPrecoAf', 'dataRecordsMediaPrecoNorm', 'usuarios'));
    }


    public function ajaxrecuperadadosgrafico(Request $request)
    {
        $tipodados = $request->tipodados;

        $mes = date('m') - 1;

        $data = [];
        $dataRecords = [];
        $records = "";

        switch($tipodados){
            case "Produtos":
                $records = $records = DB::select(DB::raw("SELECT produto_nome as nome, SUM(precototal) as totalcompra FROM bigtable_data WHERE MONTH(data_ini) = $mes GROUP BY produto_id ORDER BY totalcompra ASC"));
                $data['titulo'] = "COMPRAS POR PRODUTOS ";
            break;
            case "Categorias":
                $records = DB::select(DB::raw("SELECT categoria_nome as nome, SUM(precototal) as totalcompra FROM bigtable_data WHERE MONTH(data_ini) = $mes  GROUP BY categoria_id ORDER BY totalcompra ASC"));
                $data['titulo'] = "COMPRAS POR CATEGORIAS";
            break;
            case "Regionais":
                $records = DB::select(DB::raw("SELECT regional_nome as nome, SUM(precototal) as totalcompra FROM bigtable_data WHERE MONTH(data_ini) = $mes  GROUP BY regional_id ORDER BY totalcompra ASC"));
                $data['titulo'] = "COMPRAS POR REGIONAIS";
            break;
        }


        foreach($records as $value) {
            $dataRecords[$value->nome] =  $value->totalcompra;
        }

        $data['dados'] =  $dataRecords;

        return response()->json($data);
    }




    public function ajaxrecuperadadosgraficoempilhado(Request $request)
    {
        $tipodados = $request->tipodados;

        $mes = date('m') - 1;

        $data = [];
        $dataEmpilhadoLabels = [];
        $dataEmpilhadoRecordsNormal = [];
        $dataEmpilhadoRecordsAf = [];
        $records = "";

        switch($tipodados){
            case "Produtos":
                $records = $records = DB::select(DB::raw("SELECT produto_nome as nome, af, SUM(IF(af = 'nao', precototal, 0)) as totalcompranormal, SUM(IF(af = 'sim', precototal, 0)) as totalcompraaf, SUM(precototal) as totalcompra FROM bigtable_data WHERE MONTH(data_ini) = $mes GROUP BY produto_id ORDER BY totalcompra ASC"));
                $data['titulo'] = "COMPRAS POR PRODUTOS (NORMAL x AF)";
            break;
            case "Categorias":
                $records = $records = DB::select(DB::raw("SELECT categoria_nome as nome, af, SUM(IF(af = 'nao', precototal, 0)) as totalcompranormal, SUM(IF(af = 'sim', precototal, 0)) as totalcompraaf, SUM(precototal) as totalcompra FROM bigtable_data WHERE MONTH(data_ini) = $mes GROUP BY categoria_id ORDER BY totalcompra ASC"));
                $data['titulo'] = "COMPRAS POR CATEGORIAS (NORMAL x AF)";
            break;
            case "Regionais":
                $records = $records = DB::select(DB::raw("SELECT regional_nome as nome, af, SUM(IF(af = 'nao', precototal, 0)) as totalcompranormal, SUM(IF(af = 'sim', precototal, 0)) as totalcompraaf, SUM(precototal) as totalcompra FROM bigtable_data WHERE MONTH(data_ini) = $mes GROUP BY regional_id ORDER BY totalcompra ASC"));
                $data['titulo'] = "COMPRAS POR REGIONAIS (NORMAL x AF)";
            break;
        }


        foreach($records as $value) {
            $dataEmpilhadoLabels[] = $value->nome;
            
            $dataEmpilhadoRecordsNormal[] = $value->totalcompranormal;
            $dataEmpilhadoRecordsAf[] = $value->totalcompraaf;
            //if($value->af == "sim"){$dataEmpilhadoRecordsAf[] = $value->totalcompraaf;}else{$dataEmpilhadoRecordsNormal[] = $value->totalcompranormal;}
        }

        $data['labels'] = $dataEmpilhadoLabels;
        $data['compranormal'] = $dataEmpilhadoRecordsNormal;
        $data['compraaf'] =  $dataEmpilhadoRecordsAf;
        $data['dados'] =  $records;

        return response()->json($data);
    }


    /*****************************
    //Uma requisição personalizada
    public function ajaxgraficodadoscategoria(Request $request)
    {
        $mes = date('m') - 1;
        $records = DB::select(DB::raw("SELECT categoria_nome, SUM(precototal) as totalcompra FROM bigtable_data WHERE MONTH(data_ini) = $mes  GROUP BY categoria_nome ORDER BY totalcompra ASC"));
        $dataRecords = [];

        foreach($records as $value) {
            $dataRecords[$value->categoria_nome] =  $value->totalcompra;
        }

        $data['titulo'] = "GASTOS EM CATEGORIAS (R$)";
        $data['dados'] =  $dataRecords;

        return response()->json($data);
    }
    *******************************/

}
