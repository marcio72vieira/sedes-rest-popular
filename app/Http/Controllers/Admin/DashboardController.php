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

        $records = DB::select(DB::raw('SELECT categoria_nome, SUM(precototal) as totalcompra FROM bigtable_data WHERE MONTH(data_ini) = 11 GROUP BY categoria_nome ORDER BY categoria_nome ASC'));
        //dd($records);

        $dataRecords = [];
        foreach($records as $value) {
            $dataRecords[$value->categoria_nome] =  $value->totalcompra;
        }
        //dd($dataRecords);



        return view('admin.dashboard.index', compact('totEmpresas', 'totNutricionistas', 'totRestaurantes', 'totCompras',
                                            'totalValorCompras', 'totComprasNormal', 'totComprasAf', 'totRegionais',
                                            'totMunicipios', 'totCategorias', 'totProdutos', 'totUsuarios', 'dataRecords'));
    }
}
