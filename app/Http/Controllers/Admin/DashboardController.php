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
        $mesAtual =  date('m');

        $totEmpresas =  Empresa::all()->count();
        $totNutricionistas =  Nutricionista::all()->count();
        $totRestaurantes = Restaurante::all()->count();
        $totCompras = Compra::all()->count();
        $totRegionais = Regional::all()->count();
        $totMunicipios =  Municipio::all()->count();
        $totComprasNormal =  DB::table('compras')->whereMonth('data_ini', $mesAtual)->sum('valor');
        $totComprasAf =  DB::table('compras')->whereMonth('data_ini', $mesAtual)->sum('valoraf');
        $totalValorCompras =  $totComprasNormal + $totComprasAf;
        $totCategorias = Categoria::all()->count();
        $totProdutos =  Produto::all()->count();
        $totUsuarios =  User::all()->count();

        //$records = DB::select(DB::raw('SELECT categoria_id, categoria_nome, SUM(quantidade), SUM(precototal) FROM bigtable_data WHERE MONTH(data_ini) = 11 GROUP BY categoria_id'));
        //Obs:  O resultado de $records é um array, ou seja, uma collect, lido pela função dd(). Se eu quiser transformá-lo 
        //      em um Json que é lido pela função die(), eu coloco: json_encode($records). die(json_encode($records));

        //Dados Categoria
        //$records = DB::select(DB::raw('SELECT categoria_nome, SUM(precototal) as totalcompra FROM bigtable_data WHERE MONTH(data_ini) = 11 GROUP BY categoria_nome ORDER BY categoria_nome ASC'));
        //$dataRecords = [];
        //foreach($records as $value) {
        //    $dataRecords[$value->categoria_nome] =  $value->totalcompra;
        //}
        
        //Dados Produtos
        $records = DB::select(DB::raw('SELECT produto_nome, SUM(precototal) as totalcompra FROM bigtable_data WHERE MONTH(data_ini) = 11 GROUP BY produto_nome ORDER BY produto_nome ASC'));
        $dataRecords = [];
        foreach($records as $value) {
            $dataRecords[$value->produto_nome] =  $value->totalcompra;
        }

        //Dados Preço AF
        $records = DB::select(DB::raw('SELECT produto_nome, semana_nome, af, preco, data_ini FROM bigtable_data WHERE produto_id = 1 AND YEAR(data_ini) = 2022 ORDER BY data_ini ASC, preco ASC'));
        $dataRecordsAf = [];
        $dataRecordsNormal = [];
        foreach($records as $value) {
            if($value->af == "sim"){
                $dataRecordsAf[] = $value->preco ;
            }else{
                $dataRecordsNormal[] = $value->preco;
            }
        }

        //Dados Méida de preco AF e NORMAL
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
        
        

        //dd($records);
        //dd($dataRecords);
        //dd($dataRecordsNormal); 
        //dd($dataRecordsMediaPrecoAf);



        return view('admin.dashboard.index', compact('totEmpresas', 'totNutricionistas', 'totRestaurantes', 'totCompras',
                                            'totalValorCompras', 'totComprasNormal', 'totComprasAf', 'totRegionais',
                                            'totMunicipios', 'totCategorias', 'totProdutos', 'totUsuarios', 'dataRecords', 'dataRecordsAf', 'dataRecordsNormal', 'dataRecordsMediaPrecoAf', 'dataRecordsMediaPrecoNorm'));
    }
}
