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

use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {

        //$mes =  date('m');
        $mes =  date('m') -  1;

        $totEmpresas =  Empresa::all()->count();
        $totNutricionistas =  Nutricionista::all()->count();
        $totRestaurantes = Restaurante::all()->count();
        $totComprasGeral = Compra::all()->count();
        $totComprasMes = DB::table('compras')->whereMonth('data_ini', $mes)->count();
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

        $dataRecords = [];
        foreach($records as $value) {
            $dataRecords[$value->nome] =  $value->totalcompra;
        }


        //////////////////////////////////////////////////////////////////////
        //   INÍCIO     ESPAÇO RESERVADO PARA TESTE DE SOLICITAÇÕES AJAX    //
        //
        //$records = Produto::with(['categoria', 'compras'])->findOrFail(1);
        //dd($records);

        //$records = DB::select(DB::raw('SELECT produto_id, data_ini, SUM(IF(af = "sim", precototal, 0)) AS totalcompraaf, SUM(IF(af = "nao", precototal, 0)) AS totalcompranormal FROM bigtable_data WHERE produto_id = 1 AND YEAR(data_ini) = 2022 GROUP BY MONTH(data_ini)'));
        //dd($records);
        //
        //   FIM  ESPAÇO RESERVADO PARA TESTE DE SOLICITAÇÕES AJAX    //
        ////////////////////////////////////////////////////////////////


        //Dados Média de preco AF e NORMAL para grafico de linha prórpio
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



        // Dados evolução de compras Normal x AF mês a mês
        // especificando por uma regional
        // $records = DB::select(DB::raw('SELECT produto_id, data_ini, SUM(IF(af = "sim", precototal, 0)) AS totalcompraaf, SUM(IF(af = "nao", precototal, 0)) AS totalcompranormal FROM bigtable_data WHERE produto_id = 1 AND MONTH(data_ini) = 11 AND produto_id = 1 AND YEAR(data_ini) = 2022 GROUP by produto_id, semana_nome ORDER BY semana ASC, mdprcnorm ASC, mdprcaf ASC'));

        // especificando o ano todo independente de qualquer coisa, ou seja, todas os restaurantes, municípios e regionais e independente de unidade de medida. produto arroz = 1
        $jan_compraaf = []; $jan_compranormal = [];         $fev_compraaf = []; $fev_compranormal = [];
        $mar_compraaf = []; $mar_compranormal = [];         $abr_compraaf = []; $abr_compranormal = [];
        $mai_compraaf = []; $mai_compranormal = [];         $jun_compraaf = []; $jun_compranormal = [];
        $jul_compraaf = []; $jul_compranormal = [];         $ags_compraaf = []; $ags_compranormal = [];
        $set_compraaf = []; $set_compranormal = [];         $out_compraaf = []; $out_compranormal = [];
        $nov_compraaf = []; $nov_compranormal = [];         $dez_compraaf = []; $dez_compranormal = [];

        $compras_norm = [];
        $compras_af = [];


        $records = DB::select(DB::raw('SELECT produto_id, data_ini, SUM(IF(af = "sim", precototal, 0)) AS totalcompraaf, SUM(IF(af = "nao", precototal, 0)) AS totalcompranormal FROM bigtable_data WHERE produto_id = 1 AND YEAR(data_ini) = 2022 GROUP BY MONTH(data_ini) ORDER BY MONTH(data_ini) ASC'));
        foreach($records as $value){

            
            /* if(Str::substr($value->data_ini, 5, 2) == '01'){
                $jan_compraaf[] = $value->totalcompraaf;
                $jan_compranormal[] = $value->totalcompranormal;
            }
            if(Str::substr($value->data_ini, 5, 2) == '02'){
                $fev_compraaf[] = $value->totalcompraaf;
                $fev_compranormal[] = $value->totalcompranormal;
            }
            if(Str::substr($value->data_ini, 5, 2) == '03'){
                $mar_compraaf[] = $value->totalcompraaf;
                $mar_compranormal[] = $value->totalcompranormal;
            }
            if(Str::substr($value->data_ini, 5, 2) == '04'){
                $abr_compraaf[] = $value->totalcompraaf;
                $abr_compranormal[] = $value->totalcompranormal;
            }
            if(Str::substr($value->data_ini, 5, 2) == '05'){
                $mai_compraaf[] = $value->totalcompraaf;
                $mai_compranormal[] = $value->totalcompranormal;
            }
            if(Str::substr($value->data_ini, 5, 2) == '06'){
                $jun_compraaf[] = $value->totalcompraaf;
                $jun_compranormal[] = $value->totalcompranormal;
            }
            if(Str::substr($value->data_ini, 5, 2) == '07'){
                $jul_compraaf[] = $value->totalcompraaf;
                $jul_compranormal[] = $value->totalcompranormal;
            }
            if(Str::substr($value->data_ini, 5, 2) == '08'){
                $ags_compraaf[] = $value->totalcompraaf;
                $ags_compranormal[] = $value->totalcompranormal;
            }
            if(Str::substr($value->data_ini, 5, 2) == '09'){
                $set_compraaf[] = $value->totalcompraaf;
                $set_compranormal[] = $value->totalcompranormal;
            }
            if(Str::substr($value->data_ini, 5, 2) == '10'){
                $out_compraaf[] = $value->totalcompraaf;
                $out_compranormal[] = $value->totalcompranormal;
            }
            if(Str::substr($value->data_ini, 5, 2) == '11'){
                $nov_compraaf[] = $value->totalcompraaf;
                $nov_compranormal[] = $value->totalcompranormal;
            }
            if(Str::substr($value->data_ini, 5, 2) == '12'){
                $dez_compraaf[] = $value->totalcompraaf;
                $dez_compranormal[] = $value->totalcompranormal;
            }*/

            

            /* if(Str::substr($value->data_ini, 5, 2) == '01'){
                $compra_af[] = $value->totalcompraaf;
                $compra_nomr[] = $value->totalcompranormal;
            }

            if(Str::substr($value->data_ini, 5, 2) == '02'){
                $compra_af[] = $value->totalcompraaf;
                $compra_nomr[] = $value->totalcompranormal;
            }

            if(Str::substr($value->data_ini, 5, 2) == '03'){
                $compra_af[] = $value->totalcompraaf;
                $compra_nomr[] = $value->totalcompranormal;
            }

            if(Str::substr($value->data_ini, 5, 2) == '04'){
                $compra_af[] = $value->totalcompraaf;
                $compra_nomr[] = $value->totalcompranormal;
            }

            if(Str::substr($value->data_ini, 5, 2) == '05'){
                $compra_af[] = $value->totalcompraaf;
                $compra_nomr[] = $value->totalcompranormal;
            }

            if(Str::substr($value->data_ini, 5, 2) == '06'){
                $compra_af[] = $value->totalcompraaf;
                $compra_nomr[] = $value->totalcompranormal;
            }

            if(Str::substr($value->data_ini, 5, 2) == '07'){
                $compra_af[] = $value->totalcompraaf;
                $compra_nomr[] = $value->totalcompranormal;
            }

            if(Str::substr($value->data_ini, 5, 2) == '08'){
                $compra_af[] = $value->totalcompraaf;
                $compra_nomr[] = $value->totalcompranormal;
            }

            if(Str::substr($value->data_ini, 5, 2) == '09'){
                $compra_af[] = $value->totalcompraaf;
                $compra_nomr[] = $value->totalcompranormal;
            }

            if(Str::substr($value->data_ini, 5, 2) == '10'){
                $compra_af[] = $value->totalcompraaf;
                $compra_nomr[] = $value->totalcompranormal;
            }

            if(Str::substr($value->data_ini, 5, 2) == '11'){
                $compra_af[] = $value->totalcompraaf;
                $compra_nomr[] = $value->totalcompranormal;
            }

            if(Str::substr($value->data_ini, 5, 2) == '12'){
                $compra_af[] = $value->totalcompraaf;
                $compra_nomr[] = $value->totalcompranormal;
            } */
            
        }

        //$compra_af = [0,0,0,0,0,0,0,0,0,0,411.40,67.50];
        //$compra_nomr = [0,0,0,0,0,0,0,0,0,0,468.90,53.00];
        //dd($records);









        //Dados USUÁRIOS
        $usuarios = $records = DB::select(DB::raw('SELECT id, nomecompleto, perfil FROM users ORDER BY nomecompleto ASC'));



        return view('admin.dashboard.index', compact('totEmpresas', 'totNutricionistas', 'totRestaurantes', 'totComprasGeral', 'totComprasMes',
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





    //Recupera informaçõs para tabela de visualização
    public function ajaxrecuperadadosentidades(Request $request)
    {
        $entidade = $request->entidade;

        $data = [];
        $dataRecords = [];
        $records = "";

        switch($entidade){
            case "Usuários":
                $records = DB::select(DB::raw('SELECT id, nomecompleto as nome, perfil as ativo FROM users ORDER BY nomecompleto ASC'));
                $data['titulo'] = "USUÁRIOS";
            break;
            case "Empresas":
                $records = DB::select(DB::raw("SELECT id, nomefantasia as nome, ativo FROM empresas ORDER BY nomefantasia ASC"));
                $data['titulo'] = "EMPRESAS";
            break;
            case "Nutricionistas":
                $records = DB::select(DB::raw("SELECT id, nomecompleto as nome, ativo FROM nutricionistas ORDER BY nomecompleto ASC"));
                $data['titulo'] = "NUTRICIONISTAS";
            break;
            case "Regionais":
                $records = DB::select(DB::raw("SELECT id, nome as nome, ativo FROM regionais ORDER BY nome ASC"));
                $data['titulo'] = "REGIONAIS";
            break;
            case "Municípios":
                $records = DB::select(DB::raw("SELECT id, nome as nome, ativo FROM municipios ORDER BY nome ASC"));
                $data['titulo'] = "MUNICÍPIOS";
            break;
            case "Categorias":
                $records = DB::select(DB::raw("SELECT id, nome as nome, ativo FROM categorias ORDER BY nome ASC"));
                $data['titulo'] = "CATEGORIAS";
            break;
            case "Produtos":
                $records = DB::select(DB::raw("SELECT id, nome as nome, ativo FROM produtos ORDER BY nome ASC"));
                $data['titulo'] = "PRODUTOS";
            break;
        }

        $data['dados'] =  $records;

        return response()->json($data);
    }



    //Recupera informaçoes de um registro específico
    public function ajaxrecuperainformacoesregistro(Request $request)
    {
        $model = $request->entidade;
        $id = $request->idregistro;

        $data = [];
        $records = "";

        switch($model){
            case "Usuários":
                $records = User::with(['municipio', 'restaurante'])->findOrFail($id);
                $data['titulo'] = "USUÁRIOS";
            break;
            case "Empresas":
                $records = Empresa::with(['nutricionistas', 'restaurantes'])->findOrFail($id);
                $data['titulo'] = "EMPRESAS";
            break;
            case "Nutricionistas":
                $records = Nutricionista::with(['empresa', 'restaurante'])->findOrFail($id);
                $data['titulo'] = "NUTRICIONISTAS";
            break;
            case "Regionais":
                $records = Regional::with(['municipios', 'restaurantes'])->findOrFail($id);
                $data['titulo'] = "REGIONAIS";
            break;
            case "Municípios":
                $records = Municipio::with(['regional', 'bairros', 'restaurantes'])->findOrFail($id);
                $data['titulo'] = "MUNICÍPIOS";
            break;
            case "Categorias":
                $records = Categoria::with(['produtos'])->findOrFail($id);
                $data['titulo'] = "CATEGORIAS";
            break;
            case "Produtos":
                $records = Produto::with(['categoria', 'compras'])->findOrFail($id);
                $data['titulo'] = "PRODUTOS";
            break;
        }

        $data['dados'] =  $records;

        return response()->json($data);
    }



    //Recupera dados para subtabela informações
    public function ajaxrecuperacomprasdoproduto(Request $request)
    {
        $id = $request->idproduto;

        $data = [];

        //$records = DB::select(DB::raw("SELECT produto_id, precototal, COUNT(IF(af = 'nao', 1, null)) as nvzcmpnorm, COUNT(IF(af = 'sim', 1, null)) as nvzcmpaaf, SUM(IF(af = 'nao', quantidade, null)) as qtdcmpnorm, SUM(IF(af = 'sim', quantidade, null)) as qtdcmpaf, SUM(IF(af = 'nao', precototal, null)) as prctotnorm, SUM(IF(af = 'sim', precototal, null)) as prctotaf FROM compra_produto WHERE produto_id = $id ORDER BY precototal ASC"));
        //return response()->json($records);

        $fields = DB::select(DB::raw("SELECT produto_id, precototal, COUNT(IF(af = 'nao', 1, null)) as nvzcmpnorm, COUNT(IF(af = 'sim', 1, null)) as nvzcmpaaf, SUM(IF(af = 'nao', quantidade, null)) as qtdcmpnorm, SUM(IF(af = 'sim', quantidade, null)) as qtdcmpaf, SUM(IF(af = 'nao', precototal, null)) as prctotnorm, SUM(IF(af = 'sim', precototal, null)) as prctotaf FROM compra_produto WHERE produto_id = $id ORDER BY precototal ASC"));

        $data['campos'] = $fields;
        return response()->json($data);
    }





    /*******************************************************************
    //Requisição para geração de gráfico com vários datasets em um array
    /*
    public function ajaxrecuperadadosgraficoempilhadocategoriaproduto(Request $request)
    {
        $tipodados = $request->tipodadoscategoria;

        $mes = date('m') - 1;

        $data = [];

        switch($tipodados){
            case "Categorias":
                //$recordslabelsCat = DB::select(DB::raw("SELECT  DISTINCT categoria_id, categoria_nome as nomelabel FROM bigtable_data WHERE MONTH(data_ini) = $mes ORDER BY nomelabel ASC"));
                $recordslabelsProd = DB::select(DB::raw("SELECT categoria_nome as nomeprincipal, produto_nome as nomesecundario, SUM(precototal) as valorcompra FROM bigtable_data WHERE MONTH(data_ini) = $mes GROUP BY categoria_id, produto_id ORDER BY categoria_nome ASC, valorcompra ASC"));
                $data['titulo'] = "CATEGORIAS (PRODUTOS)";
            break;
        }

        foreach($recordslabelsProd as $prod){
            //Obtendo as categorias (irão vir duplicdas em função do Group By)
            $arrCat[] = $prod->nomeprincipal;
            //Obtendo os produtos
            $arrProd[] = $prod->nomesecundario;
            //Obtendo os valores dos produtos
            $arrValueProd[] = $prod->valorcompra;
        }

        //$data['labelsCat'] = collect($arrCat)->unique(); //$data['labelsCat'] = array_unique($arrCat);

        $data['labelsCat'] = $arrCat;
        $data['labelsProd'] = $arrProd;
        $data['valuesCompra'] = $arrValueProd;


        return response()->json($data);
    }
    ******************************************/



    /*****************************
    //Uma requisição personalizada
    /*
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
