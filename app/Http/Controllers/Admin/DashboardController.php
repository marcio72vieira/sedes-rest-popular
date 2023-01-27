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
    public function __construct()
    {
        //$this->middleware('auth', ['except' => ['index', 'show']]);
        $this->middleware(['auth', 'can:adm']);
    }

    public function index()
    {

        // Definindo mês para computo dos dados OK!
        $mes_corrente = date('m');
        $ano_corrente = date('Y');

        //Recuperando registros e seus totais para cards e menu de contexto do gráfico comparativo mês a mês
        $totEmpresas =  Empresa::all()->count();
        $totNutricionistas =  Nutricionista::all()->count();
        $totRestaurantes = Restaurante::all()->count();
        $totComprasGeral = Compra::all()->count();
        $totComprasMes = DB::table('compras')->whereMonth('data_ini', $mes_corrente)->whereYear('data_ini', $ano_corrente)->count();
        $regionais = Regional::select('id', 'nome')->get();     // $regionais = Regional::all();
        $totMunicipios =  Municipio::all()->count();
        $totComprasNormal =  DB::table('compras')->whereMonth('data_ini', $mes_corrente)->whereYear('data_ini', $ano_corrente)->sum('valor');
        $totComprasAf =  DB::table('compras')->whereMonth('data_ini', $mes_corrente)->whereYear('data_ini', $ano_corrente)->sum('valoraf');
        $totalValorCompras =  $totComprasNormal + $totComprasAf;
        $categorias = Categoria::select('id', 'nome')->get();
        $produtos = Produto::select('id', 'nome')->get();
        $totUsuarios =  User::all()->count();

        //Dados Produtos Para gráfico Principal com tradução
        $records = DB::select(DB::raw("SELECT produto_nome as nome, SUM(precototal) as totalcompra FROM bigtable_data WHERE MONTH(data_ini) = $mes_corrente  AND YEAR(data_ini) = $ano_corrente GROUP BY produto_id ORDER BY totalcompra ASC"));
        $dataRecords = [];

        //Ignite
        if(count($records) > 0){
            foreach($records as $value) {
                $dataRecords[$value->nome] =  $value->totalcompra;
            }
        }else{
            $dataRecords[''] =  0;
        }



        // TESTA AS REQUISIÇÕES AJAX
        //$records = DB::select(DB::raw('SELECT produto_id, data_ini, SUM(IF(af = "sim", precototal, 0)) AS totalcompraaf, SUM(IF(af = "nao", precototal, 0)) AS totalcompranormal FROM bigtable_data WHERE produto_id = 1 AND YEAR(data_ini) = 2022 GROUP BY MONTH(data_ini)'));
        //dd($records);

        //Dados Média de preco AF e NORMAL para grafico de linha prórpio (atual gráfico mês a mês de coluna)
        /*
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
        } */



        //Obtendo totais das compras AF e Normal Mês a Mês (Independente de qualquer cirtério de pesquisa, apenas ANO)
        $compras_af     = ['','','','','','','','','','','',''];    //  [0,0,0,0,0,0,0,0,0,0,0,0];
        $compras_norm   = ['','','','','','','','','','','',''];    //  [0,0,0,0,0,0,0,0,0,0,0,0];
        $ano_corrente   = date('Y');


        //Recuperando um produto(arroz) específico
        //$records = DB::select(DB::raw("SELECT produto_id, data_ini, SUM(IF(af = 'sim', precototal, 0)) AS totalcompraaf, SUM(IF(af = 'nao', precototal, 0)) AS totalcompranormal FROM bigtable_data WHERE produto_id = 1 AND YEAR(data_ini) = $ano_corrente GROUP BY MONTH(data_ini) ORDER BY MONTH(data_ini) ASC"));

        //Recuperando todas as compras Normal e AF independente de produto, regional, município etc...
        $records = DB::select(DB::raw("SELECT data_ini, SUM(IF(af = 'sim', precototal, 0)) AS totalcompraaf, SUM(IF(af = 'nao', precototal, 0)) AS totalcompranormal FROM bigtable_data WHERE YEAR(data_ini) = $ano_corrente GROUP BY MONTH(data_ini) ORDER BY MONTH(data_ini) ASC"));

        $numregsretorno = count($records);

        if($numregsretorno > 0){
            foreach($records as $value){
                $mesdoano = Str::substr($value->data_ini, 5, 2);        //recupera só a string correspondente ao mês
                $posicao = (int)$mesdoano;                              //transforma a string recuperada em um inteiro
                $compras_af[$posicao-1] =  $value->totalcompraaf;       //substitui o valor da posição atual 0 pelo devido valor
                $compras_norm[$posicao-1] =  $value->totalcompranormal; //idem
            }
        }else{
            // Se nada for retornado, todos os valores (correspondnte aos meses) serão 0 (zero)
            $compras_af     = ['','','','','','','','','','','',''];   //[0,0,0,0,0,0,0,0,0,0,0,0];
            $compras_norm   = ['','','','','','','','','','','',''];   //[0,0,0,0,0,0,0,0,0,0,0,0];
        }


        //Dados USUÁRIOS para preencher tabela Visualização Rápida na view
        $usuarios = $records = DB::select(DB::raw('SELECT id, nomecompleto, perfil FROM users ORDER BY nomecompleto ASC'));

        return view('admin.dashboard.index', compact('totEmpresas', 'totNutricionistas', 'totRestaurantes', 'totComprasGeral',
                        'totComprasMes', 'totalValorCompras', 'totComprasNormal', 'totComprasAf', 'totMunicipios',
                        'totUsuarios', 'regionais', 'categorias', 'produtos', 'dataRecords', 'usuarios',
                        'compras_af', 'compras_norm'));
    }


    public function ajaxrecuperadadosgrafico(Request $request)
    {
        $tipodados = $request->tipodados;

        $mes_corrente = date('m');
        $ano_corrente = date('Y');

        $data = [];
        $dataRecords = [];
        $records = "";

        switch($tipodados){
            case "Produtos":
                $records = $records = DB::select(DB::raw("SELECT produto_nome as nome, SUM(precototal) as totalcompra FROM bigtable_data WHERE MONTH(data_ini) = $mes_corrente AND YEAR(data_ini) = $ano_corrente GROUP BY produto_id ORDER BY totalcompra ASC"));
                $data['titulo'] = "COMPRAS POR PRODUTOS ";
            break;
            case "Categorias":
                $records = DB::select(DB::raw("SELECT categoria_nome as nome, SUM(precototal) as totalcompra FROM bigtable_data WHERE MONTH(data_ini) = $mes_corrente AND YEAR(data_ini) = $ano_corrente GROUP BY categoria_id ORDER BY totalcompra ASC"));
                $data['titulo'] = "COMPRAS POR CATEGORIAS";
            break;
            case "Regionais":
                $records = DB::select(DB::raw("SELECT regional_nome as nome, SUM(precototal) as totalcompra FROM bigtable_data WHERE MONTH(data_ini) = $mes_corrente AND YEAR(data_ini) = $ano_corrente GROUP BY regional_id ORDER BY totalcompra ASC"));
                $data['titulo'] = "COMPRAS POR REGIONAIS";
            break;
        }


        // foreach($records as $value) {
        //     $dataRecords[$value->nome] =  $value->totalcompra;
        // }

        if(count($records) > 0){
            foreach($records as $value) {
                $dataRecords[$value->nome] =  $value->totalcompra;
            }
        }else{
            $dataRecords[''] =  0;
        }


        $data['dados'] =  $dataRecords;

        return response()->json($data);
    }




    public function ajaxrecuperadadosgraficoempilhado(Request $request)
    {
        $tipodados = $request->tipodados;

        $mes_corrente = date('m');
        $ano_corrente = date('Y');


        $data = [];
        $dataEmpilhadoLabels = [];
        $dataEmpilhadoRecordsNormal = [];
        $dataEmpilhadoRecordsAf = [];
        $records = "";

        switch($tipodados){
            case "Produtos":
                $records = $records = DB::select(DB::raw("SELECT produto_nome as nome, af, SUM(IF(af = 'nao', precototal, 0)) as totalcompranormal, SUM(IF(af = 'sim', precototal, 0)) as totalcompraaf, SUM(precototal) as totalcompra FROM bigtable_data WHERE MONTH(data_ini) = $mes_corrente AND YEAR(data_ini) = $ano_corrente GROUP BY produto_id ORDER BY totalcompra ASC"));
                $data['titulo'] = "COMPRAS POR PRODUTOS (NORMAL x AF)";
            break;
            case "Categorias":
                $records = $records = DB::select(DB::raw("SELECT categoria_nome as nome, af, SUM(IF(af = 'nao', precototal, 0)) as totalcompranormal, SUM(IF(af = 'sim', precototal, 0)) as totalcompraaf, SUM(precototal) as totalcompra FROM bigtable_data WHERE MONTH(data_ini) = $mes_corrente AND YEAR(data_ini) = $ano_corrente GROUP BY categoria_id ORDER BY totalcompra ASC"));
                $data['titulo'] = "COMPRAS POR CATEGORIAS (NORMAL x AF)";
            break;
            case "Regionais":
                $records = $records = DB::select(DB::raw("SELECT regional_nome as nome, af, SUM(IF(af = 'nao', precototal, 0)) as totalcompranormal, SUM(IF(af = 'sim', precototal, 0)) as totalcompraaf, SUM(precototal) as totalcompra FROM bigtable_data WHERE MONTH(data_ini) = $mes_corrente AND YEAR(data_ini) = $ano_corrente GROUP BY regional_id ORDER BY totalcompra ASC"));
                $data['titulo'] = "COMPRAS POR REGIONAIS (NORMAL x AF)";
            break;
        }


        /* foreach($records as $value) {
            $dataEmpilhadoLabels[] = $value->nome;

            $dataEmpilhadoRecordsNormal[] = $value->totalcompranormal;
            $dataEmpilhadoRecordsAf[] = $value->totalcompraaf;
            //if($value->af == "sim"){$dataEmpilhadoRecordsAf[] = $value->totalcompraaf;}else{$dataEmpilhadoRecordsNormal[] = $value->totalcompranormal;}
        }

        $data['labels'] = $dataEmpilhadoLabels;
        $data['compranormal'] = $dataEmpilhadoRecordsNormal;
        $data['compraaf'] =  $dataEmpilhadoRecordsAf;
        $data['dados'] =  $records; */



        if(count($records) > 0){
            foreach($records as $value) {
                $dataEmpilhadoLabels[] = $value->nome;
                $dataEmpilhadoRecordsNormal[] = $value->totalcompranormal;
                $dataEmpilhadoRecordsAf[] = $value->totalcompraaf;
            }
        }else{
            $dataEmpilhadoLabels[] = "";
            $dataEmpilhadoRecordsNormal[] = 0;
            $dataEmpilhadoRecordsAf[] = 0;
        }

        $data['labels'] = $dataEmpilhadoLabels;
        $data['compranormal'] = $dataEmpilhadoRecordsNormal;
        $data['compraaf'] =  $dataEmpilhadoRecordsAf;
        $data['dados'] =  $records;


        return response()->json($data);
    }



    public function ajaxrecuperadadosgraficomesames(Request $request)
    {
        //Verifica se a requisição foi feita com sucesso via AJAX
        //if($request->ajax()){return $request->tipoentidade."-".$request->nomeregistroentidade."-".$request->idregistroentidade;}else{return "Não chegou nenhuma informação";}

        $tipoentidade = $request->tipoentidade;
        $nomeregistro = $request->nomeregistroentidade;
        $idregistro = $request->idregistroentidade;

        $compras_af     = ['','','','','','','','','','','',''];   //[0,0,0,0,0,0,0,0,0,0,0,0];
        $compras_norm   = ['','','','','','','','','','','',''];   //[0,0,0,0,0,0,0,0,0,0,0,0];

        $ano_corrente   = date('Y');

        $data = [];
        $records = "";

        switch($tipoentidade){
            case "Geral":
                $records = DB::select(DB::raw("SELECT data_ini, SUM(IF(af = 'sim', precototal, 0)) AS totalcompraaf, SUM(IF(af = 'nao', precototal, 0)) AS totalcompranormal FROM bigtable_data WHERE YEAR(data_ini) = $ano_corrente GROUP BY MONTH(data_ini) ORDER BY MONTH(data_ini) ASC"));
                $data['titulo'] = "GERAL";
            break;
            case "Regionais":
                $records = DB::select(DB::raw("SELECT regional_id, data_ini, SUM(IF(af = 'sim', precototal, 0)) AS totalcompraaf, SUM(IF(af = 'nao', precototal, 0)) AS totalcompranormal FROM bigtable_data WHERE regional_id = $idregistro AND YEAR(data_ini) = $ano_corrente GROUP BY MONTH(data_ini) ORDER BY MONTH(data_ini) ASC"));
                $data['titulo'] = "REGIONAL: ".$nomeregistro;
            break;
            case "Categorias":
                $records = DB::select(DB::raw("SELECT categoria_id, data_ini, SUM(IF(af = 'sim', precototal, 0)) AS totalcompraaf, SUM(IF(af = 'nao', precototal, 0)) AS totalcompranormal FROM bigtable_data WHERE categoria_id = $idregistro AND YEAR(data_ini) = $ano_corrente GROUP BY MONTH(data_ini) ORDER BY MONTH(data_ini) ASC"));
                $data['titulo'] = "CATEGORIA: ".$nomeregistro;
            break;
            case "Produtos":
                $records = DB::select(DB::raw("SELECT produto_id, data_ini, SUM(IF(af = 'sim', precototal, 0)) AS totalcompraaf, SUM(IF(af = 'nao', precototal, 0)) AS totalcompranormal FROM bigtable_data WHERE produto_id = $idregistro AND YEAR(data_ini) = $ano_corrente GROUP BY MONTH(data_ini) ORDER BY MONTH(data_ini) ASC"));
                $data['titulo'] = "PRODUTO: ".$nomeregistro;
            break;
        }

        $numregsretorno = count($records);

        if($numregsretorno > 0){
            foreach($records as $value){
                $mesdoano = Str::substr($value->data_ini, 5, 2);        //recupera só a string correspondente ao mês
                $posicao = (int)$mesdoano;                              //transforma a string recuperada em um inteiro
                $compras_af[$posicao-1] =  $value->totalcompraaf;       //substitui o valor da posição atual 0 pelo devido valor
                $compras_norm[$posicao-1] =  $value->totalcompranormal; //idem
            }
        }else{
            // Se nada for retornado, todos os valores (correspondnte aos meses) serão 0 (zero)
            $compras_af     = ['','','','','','','','','','','',''];   //[0,0,0,0,0,0,0,0,0,0,0,0];
            $compras_norm   = ['','','','','','','','','','','',''];   //[0,0,0,0,0,0,0,0,0,0,0,0];
        }

        $data['comprasAF'] = $compras_af;
        $data['comprasNORM'] = $compras_norm;

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
        $ano_corrente = date('Y');
        $data = [];


        //Obs: Fazer uma query do tipo JOIN, que envolva as tabelas "compra" e "compra_produto", a fim de substituir o campo "created_at" por "data_ini", uma vez que na tabela "compa_produto", não existe o campo "data_ini".

        //$fields = DB::select(DB::raw("SELECT produto_id, precototal, COUNT(IF(af = 'nao', 1, null)) as nvzcmpnorm, COUNT(IF(af = 'sim', 1, null)) as nvzcmpaaf, SUM(IF(af = 'nao', quantidade, null)) as qtdcmpnorm, SUM(IF(af = 'sim', quantidade, null)) as qtdcmpaf, SUM(IF(af = 'nao', precototal, null)) as prctotnorm, SUM(IF(af = 'sim', precototal, null)) as prctotaf FROM compra_produto WHERE produto_id = $id ORDER BY precototal ASC"));
        $fields = DB::select(DB::raw("SELECT produto_id, precototal, created_at, COUNT(IF(af = 'nao', 1, 0)) as nvzcmpnorm, COUNT(IF(af = 'sim', 1, 0)) as nvzcmpaaf, SUM(IF(af = 'nao', quantidade, 0)) as qtdcmpnorm, SUM(IF(af = 'sim', quantidade, 0)) as qtdcmpaf, SUM(IF(af = 'nao', precototal, 0)) as prctotnorm, SUM(IF(af = 'sim', precototal, 0)) as prctotaf FROM compra_produto WHERE produto_id = $id AND YEAR(created_at) = $ano_corrente  ORDER BY precototal ASC"));


        //$data['campos'] = $fields;
        if(count($fields) > 0){
            $data['campos'] = $fields;
        }else{
            $data['campos'] = "";
        }


        return response()->json($data);
    }



    public function ajaxrecuperamunicipiosregionais(Request $request)
    {
        $condicoes = [
            ['regional_id', '=', $request->idRegional],
        ];

        $data['municipios'] = Municipio::where($condicoes)->orderBy('nome', 'ASC')->get();
        return response()->json($data);
    }





    public function ajaxrecuperarestaurantesmunicipios(Request $request)
    {
        $condicoes = [
            ['municipio_id', '=', $request->idMunicipio],
        ];

        $data['restaurantes'] = Restaurante::where($condicoes)->orderBy('identificacao', 'ASC')->get();
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
