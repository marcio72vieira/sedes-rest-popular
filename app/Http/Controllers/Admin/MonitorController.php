<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurante;
use App\Models\Regional;
use App\Models\Monitor;
use App\Models\Municipio;
use Cron\MonthField;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class MonitorController extends Controller
{
    public function __construct()
    {
        // O usuário logado deve está autenticado e possui autorização para executar os métodos deste controle
        $this->middleware(['auth', 'can:adm']);
    }


    public function index(Request $request)
    {
        /*
        // primeira maneira válida
        return view('admin.monitor.index');
        */

        /*
        // segunda maneira válida
        $restaurantes = Restaurante::orderBy('identificacao', 'ASC')->get();
        return view('admin.monitor.index', compact('restaurantes'));
        */

        /*
        // terceira maneira válida
        // Obtendo apenas as Categorias e Produtos que foram efetivamente comprados (independnete do ano).
        $categorias =  DB::table('bigtable_data')->select('categoria_id', 'categoria_nome')->distinct('categoria_id')->orderBy('categoria_nome')->get();
        $produtos =  DB::table('bigtable_data')->select('produto_id', 'produto_nome')->distinct('produto_id')->orderBy('produto_nome')->get();

        // Transformando as coleções retornada acima, em arrays JSON(javascript) e enviando-os para a view
        $categoriaJSON =  json_encode($categorias);
        $produtosJSON =  json_encode($produtos);

        return view('admin.monitor.index', compact('categoriaJSON', 'produtosJSON'));
        */

        /*
        // Obtendo apenas as Categorias que foram efetivamente compradas (independnete do ano).
        $categorias =  DB::table('bigtable_data')->select('categoria_id', 'categoria_nome')->distinct('categoria_id')->orderBy('categoria_nome')->get();
        // Transformando a coleção retornada acima, em array JSON(javascript) e enviando-a para a view
        $categoriaJSON =  json_encode($categorias);
        return view('admin.monitor.index', compact('categoriaJSON'));
        */

        if($request->tipo == "g"){
            // Obtendo apenas as Categorias que foram efetivamente compradas (independnete do ano).
            $categorias =  DB::table('bigtable_data')->select('categoria_id', 'categoria_nome')->distinct('categoria_id')->orderBy('categoria_nome')->get();
            // Transformando a coleção retornada acima, em array JSON(javascript) e enviando-a para a view
            $categoriaJSON =  json_encode($categorias);

            return view('admin.monitor.monitorgeral', compact('categoriaJSON'));
        }else if($request->tipo == "e"){
            return view('admin.monitor.monitorespecifico');
        }else{
            Auth::logout();
	        return redirect()->route('acesso.login');
        }

    }


    // Monitor Registros Vazios
    public function ajaxgetRecordsEmpty(Request $request){

        ## Read value
        $draw = $request->get('draw');

        $totalRecords = 0;
        $totalRecordswithFilter = 0;

        $data_arr[] = array(
            "id" => " ", "nomeentidade" => " ",
            "jannormal" => " ", "janaf" => " ", "fevnormal" => " ", "fevaf" => " ", "marnormal" => " ", "maraf" => " ",
            "abrnormal" => " ", "abraf" => " ", "mainormal" => " ", "maiaf" => " ", "junnormal" => " ", "junaf" => " ",
            "julnormal" => " ", "julaf" => " ", "agsnormal" => " ", "agsaf" => " ", "setnormal" => " ", "setaf" => " ",
            "outnormal" => " ", "outaf" => " ", "novnormal" => " ", "novaf" => " ", "deznormal" => " ", "dezaf" => " ",
            "totalnormal" => " ", "totalaf" => " ", "totalgeral" => " ", "percentagemnormal" => " ", "percentagemaf" => " "
        );

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        echo json_encode($response);
        exit;
    }


    // Monitor Compras Mensais por Regionais
    public function ajaxgetRegionaisComprasMensais(Request $request){

        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value


        //dd($request);
        // Obtendo o ano de referência (ano atual)
        // $anoRef = date("Y");
        $anoRef =  $request->periodo;

        // Obtendo o total de registros de acordo com os critérios de pesquia (fitro)
        $totalRecords = DB::table("bigtable_data")->select('regional_id')->whereYear("data_ini", "=",  $anoRef)->distinct('regional_id')->count();
        $totalRecordswithFilter =  DB::table('bigtable_data')
        ->select("count(*) as allcount")
        ->whereYear("data_ini", "=",  $anoRef)
        ->distinct('bigtable_data.regional_id')
        ->where('bigtable_data.regional_nome', 'like', '%' .$searchValue . '%')
        ->count();

        // Obtendo os valores das compras por mês (1 a 12), se da agricultura familiar ou não (normal ou af) no ano de referência
        // por meio de SUBQUERY utilizando a mesma tabela (bigtable_data) através do "joinSub"
        $valoresmeses = DB::table('bigtable_data')
        ->select(DB::RAW("data_ini, af, precototal, regional_id, regional_nome,
                SUM(IF(MONTH(data_ini) = 01 AND af = 'nao', precototal, 0.00)) AS mesjannormal,
                SUM(IF(MONTH(data_ini) = 01 AND af = 'sim', precototal, 0.00)) AS mesjanaf,
                SUM(IF(MONTH(data_ini) = 02 AND af = 'nao', precototal, 0.00)) AS mesfevnormal,
                SUM(IF(MONTH(data_ini) = 02 AND af = 'sim', precototal, 0.00)) AS mesfevaf,
                SUM(IF(MONTH(data_ini) = 03 AND af = 'nao', precototal, 0.00)) AS mesmarnormal,
                SUM(IF(MONTH(data_ini) = 03 AND af = 'sim', precototal, 0.00)) AS mesmaraf,
                SUM(IF(MONTH(data_ini) = 04 AND af = 'nao', precototal, 0.00)) AS mesabrnormal,
                SUM(IF(MONTH(data_ini) = 04 AND af = 'sim', precototal, 0.00)) AS mesabraf,
                SUM(IF(MONTH(data_ini) = 05 AND af = 'nao', precototal, 0.00)) AS mesmainormal,
                SUM(IF(MONTH(data_ini) = 05 AND af = 'sim', precototal, 0.00)) AS mesmaiaf,
                SUM(IF(MONTH(data_ini) = 06 AND af = 'nao', precototal, 0.00)) AS mesjunnormal,
                SUM(IF(MONTH(data_ini) = 06 AND af = 'sim', precototal, 0.00)) AS mesjunaf,
                SUM(IF(MONTH(data_ini) = 07 AND af = 'nao', precototal, 0.00)) AS mesjulnormal,
                SUM(IF(MONTH(data_ini) = 07 AND af = 'sim', precototal, 0.00)) AS mesjulaf,
                SUM(IF(MONTH(data_ini) = 08 AND af = 'nao', precototal, 0.00)) AS mesagsnormal,
                SUM(IF(MONTH(data_ini) = 08 AND af = 'sim', precototal, 0.00)) AS mesagsaf,
                SUM(IF(MONTH(data_ini) = 09 AND af = 'nao', precototal, 0.00)) AS messetnormal,
                SUM(IF(MONTH(data_ini) = 09 AND af = 'sim', precototal, 0.00)) AS messetaf,
                SUM(IF(MONTH(data_ini) = 10 AND af = 'nao', precototal, 0.00)) AS mesoutnormal,
                SUM(IF(MONTH(data_ini) = 10 AND af = 'sim', precototal, 0.00)) AS mesoutaf,
                SUM(IF(MONTH(data_ini) = 11 AND af = 'nao', precototal, 0.00)) AS mesnovnormal,
                SUM(IF(MONTH(data_ini) = 11 AND af = 'sim', precototal, 0.00)) AS mesnovaf,
                SUM(IF(MONTH(data_ini) = 12 AND af = 'nao', precototal, 0.00)) AS mesdeznormal,
                SUM(IF(MONTH(data_ini) = 12 AND af = 'sim', precototal, 0.00)) AS mesdezaf",

            )
        )
        ->whereYear("data_ini", "=",  $anoRef)
        ->groupByRaw("regional_id")
        ->orderByRaw("regional_nome");


        $records =  DB::table('bigtable_data')->joinSub($valoresmeses, 'aliasValoresMeses', function($join){
        $join->on('bigtable_data.regional_id', '=', 'aliasValoresMeses.regional_id');
        })->select(DB::raw("bigtable_data.regional_id AS id, bigtable_data.regional_nome AS nomeentidade, bigtable_data.data_ini,
                        aliasValoresMeses.mesjannormal AS jannormal, aliasValoresMeses.mesjanaf AS janaf, aliasValoresMeses.mesfevnormal AS fevnormal, aliasValoresMeses.mesfevaf AS fevaf, aliasValoresMeses.mesmarnormal AS marnormal, aliasValoresMeses.mesmaraf AS maraf,
                        aliasValoresMeses.mesabrnormal AS abrnormal, aliasValoresMeses.mesabraf AS abraf, aliasValoresMeses.mesmainormal AS mainormal, aliasValoresMeses.mesmaiaf AS maiaf, aliasValoresMeses.mesjunnormal AS junnormal, aliasValoresMeses.mesjunaf AS junaf,
                        aliasValoresMeses.mesjulnormal AS julnormal, aliasValoresMeses.mesjulaf AS julaf, aliasValoresMeses.mesagsnormal AS agsnormal, aliasValoresMeses.mesagsaf AS agsaf, aliasValoresMeses.messetnormal AS setnormal, aliasValoresMeses.messetaf AS setaf,
                        aliasValoresMeses.mesoutnormal AS outnormal, aliasValoresMeses.mesoutaf AS outaf, aliasValoresMeses.mesnovnormal AS novnormal, aliasValoresMeses.mesnovaf AS novaf, aliasValoresMeses.mesdeznormal AS deznormal, aliasValoresMeses.mesdezaf AS dezaf"
                    )
        )
        ->whereYear("bigtable_data.data_ini", "=",  $anoRef)
        ->where('bigtable_data.regional_nome', 'like', '%' .$searchValue . '%')
        ->groupBy("bigtable_data.regional_id")
        //->orderBy("bigtable_data.regional_nome")
        ->orderBy($columnName,$columnSortOrder)
        ->skip($start)
        ->take($rowperpage)
        ->get();


        $data_arr = array();

        $linhatotalnormal = 0;
        $linhatotalaf = 0;
        $linhatotalgeral = 0;
        $linhapercentagemnormal = 0;
        $linhapercentagemaf = 0;
        $calculopercentagemnormal = 0;
        $calculopercentagemaf = 0;

        foreach($records as $record){
            // Transformando o valor retornado em float e aplicando a a formatação decimal.
            $id = $record->id;
            $nomeentidade =  $record->nomeentidade;
            $jannormal = number_format(floatval($record->jannormal), 2, ",", ".");
            $janaf = number_format(floatval($record->janaf), 2, ",", ".");
            $fevnormal = number_format(floatval($record->fevnormal), 2, ",", ".");
            $fevaf = number_format(floatval($record->fevaf), 2, ",", ".");
            $marnormal = number_format(floatval($record->marnormal), 2, ",", ".");
            $maraf = number_format(floatval($record->maraf), 2, ",", ".");
            $abrnormal = number_format(floatval($record->abrnormal), 2, ",", ".");
            $abraf = number_format(floatval($record->abraf), 2, ",", ".");
            $mainormal = number_format(floatval($record->mainormal), 2, ",", ".");
            $maiaf = number_format(floatval($record->maiaf), 2, ",", ".");
            $junnormal = number_format(floatval($record->junnormal), 2, ",", ".");
            $junaf = number_format(floatval($record->junaf), 2, ",", ".");
            $julnormal = number_format(floatval($record->julnormal), 2, ",", ".");
            $julaf = number_format(floatval($record->julaf), 2, ",", ".");
            $agsnormal = number_format(floatval($record->agsnormal), 2, ",", ".");
            $agsaf = number_format(floatval($record->agsaf), 2, ",", ".");
            $setnormal = number_format(floatval($record->setnormal), 2, ",", ".");
            $setaf = number_format(floatval($record->setaf), 2, ",", ".");
            $outnormal = number_format(floatval($record->outnormal), 2, ",", ".");
            $outaf = number_format(floatval($record->outaf), 2, ",", ".");
            $novnormal = number_format(floatval($record->novnormal), 2, ",", ".");
            $novaf = number_format(floatval($record->novaf), 2, ",", ".");
            $deznormal = number_format(floatval($record->deznormal), 2, ",", ".");
            $dezaf = number_format(floatval($record->dezaf), 2, ",", ".");

            //Soma dos valores normal e af de cada (linha)
            $linhatotalnormal = floatval($record->jannormal) + floatval($record->fevnormal) + floatval($record->marnormal) + floatval($record->abrnormal) + floatval($record->mainormal) + floatval($record->junnormal) + floatval($record->julnormal) + floatval($record->agsnormal) + floatval($record->setnormal) + floatval($record->outnormal) + floatval($record->novnormal) + floatval($record->deznormal);
            $linhatotalaf = floatval($record->janaf) + floatval($record->fevaf) + floatval($record->maraf) + floatval($record->abraf) + floatval($record->maiaf) + floatval($record->junaf) + floatval($record->julaf) + floatval($record->agsaf) + floatval($record->setaf) + floatval($record->outaf) + floatval($record->novaf) + floatval($record->dezaf);

            //Soma geral(total normal mais total af) de cada regional (linha)
            $linhatotalgeral = $linhatotalnormal + $linhatotalaf;

            //Calculando percentagem normal e af de cada regional (linha)
            //Evitando divisão por zero
            if($linhatotalgeral != 0){
                $calculopercentagemnormal = (($linhatotalnormal * 100)/$linhatotalgeral);
                $calculopercentagemaf = (($linhatotalaf * 100)/$linhatotalgeral);
            }else {
                $calculopercentagemnormal = 0;
                $calculopercentagemaf = 0;
            }



            $totalnormal = number_format($linhatotalnormal, 2, ",",".");
            $totalaf = number_format($linhatotalaf, 2, ",",".");
            $linhatotalgeral = number_format($linhatotalgeral, 2, ",",".");
            $linhapercentagemnormal = number_format($calculopercentagemnormal, 2, ",",".");
            $linhapercentagemaf = number_format($calculopercentagemaf, 2, ",", ".");


            $data_arr[] = array(
                "id"                => $id,
                "nomeentidade"      => $nomeentidade,
                "jannormal"         => $jannormal != '0,00' ? $jannormal : '',
                "janaf"             => $janaf != '0,00' ? $janaf : '',
                "fevnormal"         => $fevnormal != '0,00' ? $fevnormal : '',
                "fevaf"             => $fevaf != '0,00' ? $fevaf : '',
                "marnormal"         => $marnormal != '0,00' ? $marnormal : '',
                "maraf"             => $maraf != '0,00' ? $maraf : '',
                "abrnormal"         => $abrnormal != '0,00' ? $abrnormal : '',
                "abraf"             => $abraf != '0,00' ? $abraf : '',
                "mainormal"         => $mainormal != '0,00' ? $mainormal : '',
                "maiaf"             => $maiaf != '0,00' ? $maiaf : '',
                "junnormal"         => $junnormal != '0,00' ? $junnormal : '',
                "junaf"             => $junaf != '0,00' ? $junaf : '',
                "julnormal"         => $julnormal != '0,00' ? $julnormal : '',
                "julaf"             => $julaf != '0,00' ? $julaf : '',
                "agsnormal"         => $agsnormal != '0,00' ? $agsnormal : '',
                "agsaf"             => $agsaf != '0,00' ? $agsaf : '',
                "setnormal"         => $setnormal != '0,00' ? $setnormal : '',
                "setaf"             => $setaf != '0,00' ? $setaf : '',
                "outnormal"         => $outnormal != '0,00' ? $outnormal : '',
                "outaf"             => $outaf != '0,00' ? $outaf : '',
                "novnormal"         => $novnormal != '0,00' ? $novnormal : '',
                "novaf"             => $novaf != '0,00' ? $novaf : '',
                "deznormal"         => $deznormal != '0,00' ? $deznormal : '',
                "dezaf"             => $dezaf != '0,00' ? $dezaf : '',
                "totalnormal"       => $totalnormal != '0,00' ? $totalnormal : '',
                "totalaf"           => $totalaf != '0,00' ? $totalaf : '',
                "totalgeral"        => $linhatotalgeral != '0,00' ? $linhatotalgeral : '',
                "percentagemnormal" => $linhapercentagemnormal != '0,00' ? $linhapercentagemnormal : '',
                "percentagemaf"     => $linhapercentagemaf != '0,00' ? $linhapercentagemaf : '',

            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        echo json_encode($response);
        exit;
    }


    // Monitor Compras Mensais por Municípios
    public function ajaxgetMunicipiosComprasMensais(Request $request){

        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value


        // Obtendo o ano de referência (ano atual)
        //$anoRef = date("Y");
        $anoRef =  $request->periodo;

        // Obtendo o total de registros de acordo com os critérios de pesquia (fitro)
        $totalRecords = DB::table("bigtable_data")->select('municipio_id')->whereYear("data_ini", "=",  $anoRef)->distinct('municipio_id')->count();
        $totalRecordswithFilter =  DB::table('bigtable_data')
        ->select("count(*) as allcount")
        ->whereYear("data_ini", "=",  $anoRef)
        ->distinct('bigtable_data.municipio_id')
        ->where('bigtable_data.municipio_nome', 'like', '%' .$searchValue . '%')
        ->count();

        // Obtendo os valores das compras por mês (1 a 12), se da agricultura familiar ou não (normal ou af) no ano de referência
        // por meio de SUBQUERY utilizando a mesma tabela (bigtable_data) através do "joinSub"
        $valoresmeses = DB::table('bigtable_data')
        ->select(DB::RAW("data_ini, af, precototal, municipio_id, municipio_nome,
                SUM(IF(MONTH(data_ini) = 01 AND af = 'nao', precototal, 0.00)) AS mesjannormal,
                SUM(IF(MONTH(data_ini) = 01 AND af = 'sim', precototal, 0.00)) AS mesjanaf,
                SUM(IF(MONTH(data_ini) = 02 AND af = 'nao', precototal, 0.00)) AS mesfevnormal,
                SUM(IF(MONTH(data_ini) = 02 AND af = 'sim', precototal, 0.00)) AS mesfevaf,
                SUM(IF(MONTH(data_ini) = 03 AND af = 'nao', precototal, 0.00)) AS mesmarnormal,
                SUM(IF(MONTH(data_ini) = 03 AND af = 'sim', precototal, 0.00)) AS mesmaraf,
                SUM(IF(MONTH(data_ini) = 04 AND af = 'nao', precototal, 0.00)) AS mesabrnormal,
                SUM(IF(MONTH(data_ini) = 04 AND af = 'sim', precototal, 0.00)) AS mesabraf,
                SUM(IF(MONTH(data_ini) = 05 AND af = 'nao', precototal, 0.00)) AS mesmainormal,
                SUM(IF(MONTH(data_ini) = 05 AND af = 'sim', precototal, 0.00)) AS mesmaiaf,
                SUM(IF(MONTH(data_ini) = 06 AND af = 'nao', precototal, 0.00)) AS mesjunnormal,
                SUM(IF(MONTH(data_ini) = 06 AND af = 'sim', precototal, 0.00)) AS mesjunaf,
                SUM(IF(MONTH(data_ini) = 07 AND af = 'nao', precototal, 0.00)) AS mesjulnormal,
                SUM(IF(MONTH(data_ini) = 07 AND af = 'sim', precototal, 0.00)) AS mesjulaf,
                SUM(IF(MONTH(data_ini) = 08 AND af = 'nao', precototal, 0.00)) AS mesagsnormal,
                SUM(IF(MONTH(data_ini) = 08 AND af = 'sim', precototal, 0.00)) AS mesagsaf,
                SUM(IF(MONTH(data_ini) = 09 AND af = 'nao', precototal, 0.00)) AS messetnormal,
                SUM(IF(MONTH(data_ini) = 09 AND af = 'sim', precototal, 0.00)) AS messetaf,
                SUM(IF(MONTH(data_ini) = 10 AND af = 'nao', precototal, 0.00)) AS mesoutnormal,
                SUM(IF(MONTH(data_ini) = 10 AND af = 'sim', precototal, 0.00)) AS mesoutaf,
                SUM(IF(MONTH(data_ini) = 11 AND af = 'nao', precototal, 0.00)) AS mesnovnormal,
                SUM(IF(MONTH(data_ini) = 11 AND af = 'sim', precototal, 0.00)) AS mesnovaf,
                SUM(IF(MONTH(data_ini) = 12 AND af = 'nao', precototal, 0.00)) AS mesdeznormal,
                SUM(IF(MONTH(data_ini) = 12 AND af = 'sim', precototal, 0.00)) AS mesdezaf",

            )
        )
        ->whereYear("data_ini", "=",  $anoRef)
        ->groupByRaw("municipio_id")
        ->orderByRaw("municipio_nome");


        $records =  DB::table('bigtable_data')->joinSub($valoresmeses, 'aliasValoresMeses', function($join){
        $join->on('bigtable_data.municipio_id', '=', 'aliasValoresMeses.municipio_id');
        })->select(DB::raw("bigtable_data.municipio_id AS id, bigtable_data.municipio_nome AS nomeentidade, bigtable_data.data_ini,
                        aliasValoresMeses.mesjannormal AS jannormal, aliasValoresMeses.mesjanaf AS janaf, aliasValoresMeses.mesfevnormal AS fevnormal, aliasValoresMeses.mesfevaf AS fevaf, aliasValoresMeses.mesmarnormal AS marnormal, aliasValoresMeses.mesmaraf AS maraf,
                        aliasValoresMeses.mesabrnormal AS abrnormal, aliasValoresMeses.mesabraf AS abraf, aliasValoresMeses.mesmainormal AS mainormal, aliasValoresMeses.mesmaiaf AS maiaf, aliasValoresMeses.mesjunnormal AS junnormal, aliasValoresMeses.mesjunaf AS junaf,
                        aliasValoresMeses.mesjulnormal AS julnormal, aliasValoresMeses.mesjulaf AS julaf, aliasValoresMeses.mesagsnormal AS agsnormal, aliasValoresMeses.mesagsaf AS agsaf, aliasValoresMeses.messetnormal AS setnormal, aliasValoresMeses.messetaf AS setaf,
                        aliasValoresMeses.mesoutnormal AS outnormal, aliasValoresMeses.mesoutaf AS outaf, aliasValoresMeses.mesnovnormal AS novnormal, aliasValoresMeses.mesnovaf AS novaf, aliasValoresMeses.mesdeznormal AS deznormal, aliasValoresMeses.mesdezaf AS dezaf"
                    )
        )
        ->whereYear("bigtable_data.data_ini", "=",  $anoRef)
        ->where('bigtable_data.municipio_nome', 'like', '%' .$searchValue . '%')
        ->groupBy("bigtable_data.municipio_id")
        //->orderBy("bigtable_data.municipio_nome")
        ->orderBy($columnName,$columnSortOrder)
        ->skip($start)
        ->take($rowperpage)
        ->get();


        $data_arr = array();

        $linhatotalnormal = 0;
        $linhatotalaf = 0;
        $linhatotalgeral = 0;
        $linhapercentagemnormal = 0;
        $linhapercentagemaf = 0;
        $calculopercentagemnormal = 0;
        $calculopercentagemaf = 0;

        foreach($records as $record){
            // Transformando o valor retornado em float e aplicando a a formatação decimal.
            $id = $record->id;
            $nomeentidade =  $record->nomeentidade;
            $jannormal = number_format(floatval($record->jannormal), 2, ",", ".");
            $janaf = number_format(floatval($record->janaf), 2, ",", ".");
            $fevnormal = number_format(floatval($record->fevnormal), 2, ",", ".");
            $fevaf = number_format(floatval($record->fevaf), 2, ",", ".");
            $marnormal = number_format(floatval($record->marnormal), 2, ",", ".");
            $maraf = number_format(floatval($record->maraf), 2, ",", ".");
            $abrnormal = number_format(floatval($record->abrnormal), 2, ",", ".");
            $abraf = number_format(floatval($record->abraf), 2, ",", ".");
            $mainormal = number_format(floatval($record->mainormal), 2, ",", ".");
            $maiaf = number_format(floatval($record->maiaf), 2, ",", ".");
            $junnormal = number_format(floatval($record->junnormal), 2, ",", ".");
            $junaf = number_format(floatval($record->junaf), 2, ",", ".");
            $julnormal = number_format(floatval($record->julnormal), 2, ",", ".");
            $julaf = number_format(floatval($record->julaf), 2, ",", ".");
            $agsnormal = number_format(floatval($record->agsnormal), 2, ",", ".");
            $agsaf = number_format(floatval($record->agsaf), 2, ",", ".");
            $setnormal = number_format(floatval($record->setnormal), 2, ",", ".");
            $setaf = number_format(floatval($record->setaf), 2, ",", ".");
            $outnormal = number_format(floatval($record->outnormal), 2, ",", ".");
            $outaf = number_format(floatval($record->outaf), 2, ",", ".");
            $novnormal = number_format(floatval($record->novnormal), 2, ",", ".");
            $novaf = number_format(floatval($record->novaf), 2, ",", ".");
            $deznormal = number_format(floatval($record->deznormal), 2, ",", ".");
            $dezaf = number_format(floatval($record->dezaf), 2, ",", ".");

            //Soma dos valores normal e af de cada (linha)
            $linhatotalnormal = floatval($record->jannormal) + floatval($record->fevnormal) + floatval($record->marnormal) + floatval($record->abrnormal) + floatval($record->mainormal) + floatval($record->junnormal) + floatval($record->julnormal) + floatval($record->agsnormal) + floatval($record->setnormal) + floatval($record->outnormal) + floatval($record->novnormal) + floatval($record->deznormal);
            $linhatotalaf = floatval($record->janaf) + floatval($record->fevaf) + floatval($record->maraf) + floatval($record->abraf) + floatval($record->maiaf) + floatval($record->junaf) + floatval($record->julaf) + floatval($record->agsaf) + floatval($record->setaf) + floatval($record->outaf) + floatval($record->novaf) + floatval($record->dezaf);

            //Soma geral(total normal mais total af) de cada municipio (linha)
            $linhatotalgeral = $linhatotalnormal + $linhatotalaf;

            //Calculando percentagem normal e af de cada municipio (linha)
            //Evitando divisão por zero
            if($linhatotalgeral != 0){
                $calculopercentagemnormal = (($linhatotalnormal * 100)/$linhatotalgeral);
                $calculopercentagemaf = (($linhatotalaf * 100)/$linhatotalgeral);
            }else {
                $calculopercentagemnormal = 0;
                $calculopercentagemaf = 0;
            }



            $totalnormal = number_format($linhatotalnormal, 2, ",",".");
            $totalaf = number_format($linhatotalaf, 2, ",",".");
            $linhatotalgeral = number_format($linhatotalgeral, 2, ",",".");
            $linhapercentagemnormal = number_format($calculopercentagemnormal, 2, ",",".");
            $linhapercentagemaf = number_format($calculopercentagemaf, 2, ",", ".");


            $data_arr[] = array(
                "id"                => $id,
                "nomeentidade"      => $nomeentidade,
                "jannormal"         => $jannormal != '0,00' ? $jannormal : '',
                "janaf"             => $janaf != '0,00' ? $janaf : '',
                "fevnormal"         => $fevnormal != '0,00' ? $fevnormal : '',
                "fevaf"             => $fevaf != '0,00' ? $fevaf : '',
                "marnormal"         => $marnormal != '0,00' ? $marnormal : '',
                "maraf"             => $maraf != '0,00' ? $maraf : '',
                "abrnormal"         => $abrnormal != '0,00' ? $abrnormal : '',
                "abraf"             => $abraf != '0,00' ? $abraf : '',
                "mainormal"         => $mainormal != '0,00' ? $mainormal : '',
                "maiaf"             => $maiaf != '0,00' ? $maiaf : '',
                "junnormal"         => $junnormal != '0,00' ? $junnormal : '',
                "junaf"             => $junaf != '0,00' ? $junaf : '',
                "julnormal"         => $julnormal != '0,00' ? $julnormal : '',
                "julaf"             => $julaf != '0,00' ? $julaf : '',
                "agsnormal"         => $agsnormal != '0,00' ? $agsnormal : '',
                "agsaf"             => $agsaf != '0,00' ? $agsaf : '',
                "setnormal"         => $setnormal != '0,00' ? $setnormal : '',
                "setaf"             => $setaf != '0,00' ? $setaf : '',
                "outnormal"         => $outnormal != '0,00' ? $outnormal : '',
                "outaf"             => $outaf != '0,00' ? $outaf : '',
                "novnormal"         => $novnormal != '0,00' ? $novnormal : '',
                "novaf"             => $novaf != '0,00' ? $novaf : '',
                "deznormal"         => $deznormal != '0,00' ? $deznormal : '',
                "dezaf"             => $dezaf != '0,00' ? $dezaf : '',
                "totalnormal"       => $totalnormal != '0,00' ? $totalnormal : '',
                "totalaf"           => $totalaf != '0,00' ? $totalaf : '',
                "totalgeral"        => $linhatotalgeral != '0,00' ? $linhatotalgeral : '',
                "percentagemnormal" => $linhapercentagemnormal != '0,00' ? $linhapercentagemnormal : '',
                "percentagemaf"     => $linhapercentagemaf != '0,00' ? $linhapercentagemaf : '',

            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        echo json_encode($response);
        exit;
    }



    // Monitor Compras Mensais por Restaurantes
    public function ajaxgetRestaurantesComprasMensais(Request $request){

        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value


        // Obtendo o ano de referência (ano atual)
        //$anoRef = date("Y");
        $anoRef =  $request->periodo;

        // Obtendo o total de registros de acordo com os critérios de pesquia (fitro)
        $totalRecords = DB::table("bigtable_data")->select('restaurante_id')->whereYear("data_ini", "=",  $anoRef)->distinct('restaurante_id')->count();
        $totalRecordswithFilter =  DB::table('bigtable_data')
        ->select("count(*) as allcount")
        ->whereYear("data_ini", "=",  $anoRef)
        ->distinct('bigtable_data.restaurante_id')
        ->where('bigtable_data.identificacao', 'like', '%' .$searchValue . '%')
        ->count();

        // Obtendo os valores das compras por mês (1 a 12), se da agricultura familiar ou não (normal ou af) no ano de referência
        // por meio de SUBQUERY utilizando a mesma tabela (bigtable_data) através do "joinSub"
        $valoresmeses = DB::table('bigtable_data')
        ->select(DB::RAW("data_ini, af, precototal, restaurante_id, identificacao,
                SUM(IF(MONTH(data_ini) = 01 AND af = 'nao', precototal, 0.00)) AS mesjannormal,
                SUM(IF(MONTH(data_ini) = 01 AND af = 'sim', precototal, 0.00)) AS mesjanaf,
                SUM(IF(MONTH(data_ini) = 02 AND af = 'nao', precototal, 0.00)) AS mesfevnormal,
                SUM(IF(MONTH(data_ini) = 02 AND af = 'sim', precototal, 0.00)) AS mesfevaf,
                SUM(IF(MONTH(data_ini) = 03 AND af = 'nao', precototal, 0.00)) AS mesmarnormal,
                SUM(IF(MONTH(data_ini) = 03 AND af = 'sim', precototal, 0.00)) AS mesmaraf,
                SUM(IF(MONTH(data_ini) = 04 AND af = 'nao', precototal, 0.00)) AS mesabrnormal,
                SUM(IF(MONTH(data_ini) = 04 AND af = 'sim', precototal, 0.00)) AS mesabraf,
                SUM(IF(MONTH(data_ini) = 05 AND af = 'nao', precototal, 0.00)) AS mesmainormal,
                SUM(IF(MONTH(data_ini) = 05 AND af = 'sim', precototal, 0.00)) AS mesmaiaf,
                SUM(IF(MONTH(data_ini) = 06 AND af = 'nao', precototal, 0.00)) AS mesjunnormal,
                SUM(IF(MONTH(data_ini) = 06 AND af = 'sim', precototal, 0.00)) AS mesjunaf,
                SUM(IF(MONTH(data_ini) = 07 AND af = 'nao', precototal, 0.00)) AS mesjulnormal,
                SUM(IF(MONTH(data_ini) = 07 AND af = 'sim', precototal, 0.00)) AS mesjulaf,
                SUM(IF(MONTH(data_ini) = 08 AND af = 'nao', precototal, 0.00)) AS mesagsnormal,
                SUM(IF(MONTH(data_ini) = 08 AND af = 'sim', precototal, 0.00)) AS mesagsaf,
                SUM(IF(MONTH(data_ini) = 09 AND af = 'nao', precototal, 0.00)) AS messetnormal,
                SUM(IF(MONTH(data_ini) = 09 AND af = 'sim', precototal, 0.00)) AS messetaf,
                SUM(IF(MONTH(data_ini) = 10 AND af = 'nao', precototal, 0.00)) AS mesoutnormal,
                SUM(IF(MONTH(data_ini) = 10 AND af = 'sim', precototal, 0.00)) AS mesoutaf,
                SUM(IF(MONTH(data_ini) = 11 AND af = 'nao', precototal, 0.00)) AS mesnovnormal,
                SUM(IF(MONTH(data_ini) = 11 AND af = 'sim', precototal, 0.00)) AS mesnovaf,
                SUM(IF(MONTH(data_ini) = 12 AND af = 'nao', precototal, 0.00)) AS mesdeznormal,
                SUM(IF(MONTH(data_ini) = 12 AND af = 'sim', precototal, 0.00)) AS mesdezaf",

            )
        )
        ->whereYear("data_ini", "=",  $anoRef)
        ->groupByRaw("restaurante_id")
        ->orderByRaw("identificacao");


        $records =  DB::table('bigtable_data')->joinSub($valoresmeses, 'aliasValoresMeses', function($join){
        $join->on('bigtable_data.restaurante_id', '=', 'aliasValoresMeses.restaurante_id');
        })->select(DB::raw("bigtable_data.restaurante_id AS id, bigtable_data.identificacao AS nomeentidade, bigtable_data.data_ini,
                        aliasValoresMeses.mesjannormal AS jannormal, aliasValoresMeses.mesjanaf AS janaf, aliasValoresMeses.mesfevnormal AS fevnormal, aliasValoresMeses.mesfevaf AS fevaf, aliasValoresMeses.mesmarnormal AS marnormal, aliasValoresMeses.mesmaraf AS maraf,
                        aliasValoresMeses.mesabrnormal AS abrnormal, aliasValoresMeses.mesabraf AS abraf, aliasValoresMeses.mesmainormal AS mainormal, aliasValoresMeses.mesmaiaf AS maiaf, aliasValoresMeses.mesjunnormal AS junnormal, aliasValoresMeses.mesjunaf AS junaf,
                        aliasValoresMeses.mesjulnormal AS julnormal, aliasValoresMeses.mesjulaf AS julaf, aliasValoresMeses.mesagsnormal AS agsnormal, aliasValoresMeses.mesagsaf AS agsaf, aliasValoresMeses.messetnormal AS setnormal, aliasValoresMeses.messetaf AS setaf,
                        aliasValoresMeses.mesoutnormal AS outnormal, aliasValoresMeses.mesoutaf AS outaf, aliasValoresMeses.mesnovnormal AS novnormal, aliasValoresMeses.mesnovaf AS novaf, aliasValoresMeses.mesdeznormal AS deznormal, aliasValoresMeses.mesdezaf AS dezaf"
                    )
        )
        ->whereYear("bigtable_data.data_ini", "=",  $anoRef)
        ->where('bigtable_data.identificacao', 'like', '%' .$searchValue . '%')
        ->groupBy("bigtable_data.restaurante_id")
        //->orderBy("bigtable_data.identificacao")
        ->orderBy($columnName,$columnSortOrder)
        ->skip($start)
        ->take($rowperpage)
        ->get();


        $data_arr = array();

        $linhatotalnormal = 0;
        $linhatotalaf = 0;
        $linhatotalgeral = 0;
        $linhapercentagemnormal = 0;
        $linhapercentagemaf = 0;
        $calculopercentagemnormal = 0;
        $calculopercentagemaf = 0;

        foreach($records as $record){
            // Transformando o valor retornado em float e aplicando a a formatação decimal.
            $id = $record->id;
            $nomeentidade =  $record->nomeentidade;
            $jannormal = number_format(floatval($record->jannormal), 2, ",", ".");
            $janaf = number_format(floatval($record->janaf), 2, ",", ".");
            $fevnormal = number_format(floatval($record->fevnormal), 2, ",", ".");
            $fevaf = number_format(floatval($record->fevaf), 2, ",", ".");
            $marnormal = number_format(floatval($record->marnormal), 2, ",", ".");
            $maraf = number_format(floatval($record->maraf), 2, ",", ".");
            $abrnormal = number_format(floatval($record->abrnormal), 2, ",", ".");
            $abraf = number_format(floatval($record->abraf), 2, ",", ".");
            $mainormal = number_format(floatval($record->mainormal), 2, ",", ".");
            $maiaf = number_format(floatval($record->maiaf), 2, ",", ".");
            $junnormal = number_format(floatval($record->junnormal), 2, ",", ".");
            $junaf = number_format(floatval($record->junaf), 2, ",", ".");
            $julnormal = number_format(floatval($record->julnormal), 2, ",", ".");
            $julaf = number_format(floatval($record->julaf), 2, ",", ".");
            $agsnormal = number_format(floatval($record->agsnormal), 2, ",", ".");
            $agsaf = number_format(floatval($record->agsaf), 2, ",", ".");
            $setnormal = number_format(floatval($record->setnormal), 2, ",", ".");
            $setaf = number_format(floatval($record->setaf), 2, ",", ".");
            $outnormal = number_format(floatval($record->outnormal), 2, ",", ".");
            $outaf = number_format(floatval($record->outaf), 2, ",", ".");
            $novnormal = number_format(floatval($record->novnormal), 2, ",", ".");
            $novaf = number_format(floatval($record->novaf), 2, ",", ".");
            $deznormal = number_format(floatval($record->deznormal), 2, ",", ".");
            $dezaf = number_format(floatval($record->dezaf), 2, ",", ".");

            //Soma dos valores normal e af de cada (linha)
            $linhatotalnormal = floatval($record->jannormal) + floatval($record->fevnormal) + floatval($record->marnormal) + floatval($record->abrnormal) + floatval($record->mainormal) + floatval($record->junnormal) + floatval($record->julnormal) + floatval($record->agsnormal) + floatval($record->setnormal) + floatval($record->outnormal) + floatval($record->novnormal) + floatval($record->deznormal);
            $linhatotalaf = floatval($record->janaf) + floatval($record->fevaf) + floatval($record->maraf) + floatval($record->abraf) + floatval($record->maiaf) + floatval($record->junaf) + floatval($record->julaf) + floatval($record->agsaf) + floatval($record->setaf) + floatval($record->outaf) + floatval($record->novaf) + floatval($record->dezaf);

            //Soma geral(total normal mais total af) de cada municipio (linha)
            $linhatotalgeral = $linhatotalnormal + $linhatotalaf;

            //Calculando percentagem normal e af de cada municipio (linha)
            //Evitando divisão por zero
            if($linhatotalgeral != 0){
                $calculopercentagemnormal = (($linhatotalnormal * 100)/$linhatotalgeral);
                $calculopercentagemaf = (($linhatotalaf * 100)/$linhatotalgeral);
            }else {
                $calculopercentagemnormal = 0;
                $calculopercentagemaf = 0;
            }



            $totalnormal = number_format($linhatotalnormal, 2, ",",".");
            $totalaf = number_format($linhatotalaf, 2, ",",".");
            $linhatotalgeral = number_format($linhatotalgeral, 2, ",",".");
            $linhapercentagemnormal = number_format($calculopercentagemnormal, 2, ",",".");
            $linhapercentagemaf = number_format($calculopercentagemaf, 2, ",", ".");


            $data_arr[] = array(
                "id"                => $id,
                "nomeentidade"      => $nomeentidade,
                "jannormal"         => $jannormal != '0,00' ? $jannormal : '',
                "janaf"             => $janaf != '0,00' ? $janaf : '',
                "fevnormal"         => $fevnormal != '0,00' ? $fevnormal : '',
                "fevaf"             => $fevaf != '0,00' ? $fevaf : '',
                "marnormal"         => $marnormal != '0,00' ? $marnormal : '',
                "maraf"             => $maraf != '0,00' ? $maraf : '',
                "abrnormal"         => $abrnormal != '0,00' ? $abrnormal : '',
                "abraf"             => $abraf != '0,00' ? $abraf : '',
                "mainormal"         => $mainormal != '0,00' ? $mainormal : '',
                "maiaf"             => $maiaf != '0,00' ? $maiaf : '',
                "junnormal"         => $junnormal != '0,00' ? $junnormal : '',
                "junaf"             => $junaf != '0,00' ? $junaf : '',
                "julnormal"         => $julnormal != '0,00' ? $julnormal : '',
                "julaf"             => $julaf != '0,00' ? $julaf : '',
                "agsnormal"         => $agsnormal != '0,00' ? $agsnormal : '',
                "agsaf"             => $agsaf != '0,00' ? $agsaf : '',
                "setnormal"         => $setnormal != '0,00' ? $setnormal : '',
                "setaf"             => $setaf != '0,00' ? $setaf : '',
                "outnormal"         => $outnormal != '0,00' ? $outnormal : '',
                "outaf"             => $outaf != '0,00' ? $outaf : '',
                "novnormal"         => $novnormal != '0,00' ? $novnormal : '',
                "novaf"             => $novaf != '0,00' ? $novaf : '',
                "deznormal"         => $deznormal != '0,00' ? $deznormal : '',
                "dezaf"             => $dezaf != '0,00' ? $dezaf : '',
                "totalnormal"       => $totalnormal != '0,00' ? $totalnormal : '',
                "totalaf"           => $totalaf != '0,00' ? $totalaf : '',
                "totalgeral"        => $linhatotalgeral != '0,00' ? $linhatotalgeral : '',
                "percentagemnormal" => $linhapercentagemnormal != '0,00' ? $linhapercentagemnormal : '',
                "percentagemaf"     => $linhapercentagemaf != '0,00' ? $linhapercentagemaf : '',

            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        echo json_encode($response);
        exit;
    }



    // Monitor Compras Mensais por Categorias
    public function ajaxgetCategoriasComprasMensais(Request $request){

        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value


        // Obtendo o ano de referência (ano atual)
        //$anoRef = date("Y");
        $anoRef =  $request->periodo;

        // Obtendo o total de registros de acordo com os critérios de pesquia (fitro)
        $totalRecords = DB::table("bigtable_data")->select('categoria_id')->whereYear("data_ini", "=",  $anoRef)->distinct('categoria_id')->count();
        $totalRecordswithFilter =  DB::table('bigtable_data')
        ->select("count(*) as allcount")
        ->whereYear("data_ini", "=",  $anoRef)
        ->distinct('bigtable_data.categoria_id')
        ->where('bigtable_data.categoria_nome', 'like', '%' .$searchValue . '%')
        ->count();

        // Obtendo os valores das compras por mês (1 a 12), se da agricultura familiar ou não (normal ou af) no ano de referência
        // por meio de SUBQUERY utilizando a mesma tabela (bigtable_data) através do "joinSub"
        $valoresmeses = DB::table('bigtable_data')
        ->select(DB::RAW("data_ini, af, precototal, categoria_id, categoria_nome,
                SUM(IF(MONTH(data_ini) = 01 AND af = 'nao', precototal, 0.00)) AS mesjannormal,
                SUM(IF(MONTH(data_ini) = 01 AND af = 'sim', precototal, 0.00)) AS mesjanaf,
                SUM(IF(MONTH(data_ini) = 02 AND af = 'nao', precototal, 0.00)) AS mesfevnormal,
                SUM(IF(MONTH(data_ini) = 02 AND af = 'sim', precototal, 0.00)) AS mesfevaf,
                SUM(IF(MONTH(data_ini) = 03 AND af = 'nao', precototal, 0.00)) AS mesmarnormal,
                SUM(IF(MONTH(data_ini) = 03 AND af = 'sim', precototal, 0.00)) AS mesmaraf,
                SUM(IF(MONTH(data_ini) = 04 AND af = 'nao', precototal, 0.00)) AS mesabrnormal,
                SUM(IF(MONTH(data_ini) = 04 AND af = 'sim', precototal, 0.00)) AS mesabraf,
                SUM(IF(MONTH(data_ini) = 05 AND af = 'nao', precototal, 0.00)) AS mesmainormal,
                SUM(IF(MONTH(data_ini) = 05 AND af = 'sim', precototal, 0.00)) AS mesmaiaf,
                SUM(IF(MONTH(data_ini) = 06 AND af = 'nao', precototal, 0.00)) AS mesjunnormal,
                SUM(IF(MONTH(data_ini) = 06 AND af = 'sim', precototal, 0.00)) AS mesjunaf,
                SUM(IF(MONTH(data_ini) = 07 AND af = 'nao', precototal, 0.00)) AS mesjulnormal,
                SUM(IF(MONTH(data_ini) = 07 AND af = 'sim', precototal, 0.00)) AS mesjulaf,
                SUM(IF(MONTH(data_ini) = 08 AND af = 'nao', precototal, 0.00)) AS mesagsnormal,
                SUM(IF(MONTH(data_ini) = 08 AND af = 'sim', precototal, 0.00)) AS mesagsaf,
                SUM(IF(MONTH(data_ini) = 09 AND af = 'nao', precototal, 0.00)) AS messetnormal,
                SUM(IF(MONTH(data_ini) = 09 AND af = 'sim', precototal, 0.00)) AS messetaf,
                SUM(IF(MONTH(data_ini) = 10 AND af = 'nao', precototal, 0.00)) AS mesoutnormal,
                SUM(IF(MONTH(data_ini) = 10 AND af = 'sim', precototal, 0.00)) AS mesoutaf,
                SUM(IF(MONTH(data_ini) = 11 AND af = 'nao', precototal, 0.00)) AS mesnovnormal,
                SUM(IF(MONTH(data_ini) = 11 AND af = 'sim', precototal, 0.00)) AS mesnovaf,
                SUM(IF(MONTH(data_ini) = 12 AND af = 'nao', precototal, 0.00)) AS mesdeznormal,
                SUM(IF(MONTH(data_ini) = 12 AND af = 'sim', precototal, 0.00)) AS mesdezaf",

            )
        )
        ->whereYear("data_ini", "=",  $anoRef)
        ->groupByRaw("categoria_id")
        ->orderByRaw("categoria_nome");


        $records =  DB::table('bigtable_data')->joinSub($valoresmeses, 'aliasValoresMeses', function($join){
        $join->on('bigtable_data.categoria_id', '=', 'aliasValoresMeses.categoria_id');
        })->select(DB::raw("bigtable_data.categoria_id AS id, bigtable_data.categoria_nome AS nomeentidade, bigtable_data.data_ini,
                        aliasValoresMeses.mesjannormal AS jannormal, aliasValoresMeses.mesjanaf AS janaf, aliasValoresMeses.mesfevnormal AS fevnormal, aliasValoresMeses.mesfevaf AS fevaf, aliasValoresMeses.mesmarnormal AS marnormal, aliasValoresMeses.mesmaraf AS maraf,
                        aliasValoresMeses.mesabrnormal AS abrnormal, aliasValoresMeses.mesabraf AS abraf, aliasValoresMeses.mesmainormal AS mainormal, aliasValoresMeses.mesmaiaf AS maiaf, aliasValoresMeses.mesjunnormal AS junnormal, aliasValoresMeses.mesjunaf AS junaf,
                        aliasValoresMeses.mesjulnormal AS julnormal, aliasValoresMeses.mesjulaf AS julaf, aliasValoresMeses.mesagsnormal AS agsnormal, aliasValoresMeses.mesagsaf AS agsaf, aliasValoresMeses.messetnormal AS setnormal, aliasValoresMeses.messetaf AS setaf,
                        aliasValoresMeses.mesoutnormal AS outnormal, aliasValoresMeses.mesoutaf AS outaf, aliasValoresMeses.mesnovnormal AS novnormal, aliasValoresMeses.mesnovaf AS novaf, aliasValoresMeses.mesdeznormal AS deznormal, aliasValoresMeses.mesdezaf AS dezaf"
                    )
        )
        ->whereYear("bigtable_data.data_ini", "=",  $anoRef)
        ->where('bigtable_data.categoria_nome', 'like', '%' .$searchValue . '%')
        ->groupBy("bigtable_data.categoria_id")
        //->orderBy("bigtable_data.categoria_nome")
        ->orderBy($columnName,$columnSortOrder)
        ->skip($start)
        ->take($rowperpage)
        ->get();


        $data_arr = array();

        $linhatotalnormal = 0;
        $linhatotalaf = 0;
        $linhatotalgeral = 0;
        $linhapercentagemnormal = 0;
        $linhapercentagemaf = 0;
        $calculopercentagemnormal = 0;
        $calculopercentagemaf = 0;

        foreach($records as $record){
            // Transformando o valor retornado em float e aplicando a a formatação decimal.
            $id = $record->id;
            $nomeentidade =  $record->nomeentidade;
            $jannormal = number_format(floatval($record->jannormal), 2, ",", ".");
            $janaf = number_format(floatval($record->janaf), 2, ",", ".");
            $fevnormal = number_format(floatval($record->fevnormal), 2, ",", ".");
            $fevaf = number_format(floatval($record->fevaf), 2, ",", ".");
            $marnormal = number_format(floatval($record->marnormal), 2, ",", ".");
            $maraf = number_format(floatval($record->maraf), 2, ",", ".");
            $abrnormal = number_format(floatval($record->abrnormal), 2, ",", ".");
            $abraf = number_format(floatval($record->abraf), 2, ",", ".");
            $mainormal = number_format(floatval($record->mainormal), 2, ",", ".");
            $maiaf = number_format(floatval($record->maiaf), 2, ",", ".");
            $junnormal = number_format(floatval($record->junnormal), 2, ",", ".");
            $junaf = number_format(floatval($record->junaf), 2, ",", ".");
            $julnormal = number_format(floatval($record->julnormal), 2, ",", ".");
            $julaf = number_format(floatval($record->julaf), 2, ",", ".");
            $agsnormal = number_format(floatval($record->agsnormal), 2, ",", ".");
            $agsaf = number_format(floatval($record->agsaf), 2, ",", ".");
            $setnormal = number_format(floatval($record->setnormal), 2, ",", ".");
            $setaf = number_format(floatval($record->setaf), 2, ",", ".");
            $outnormal = number_format(floatval($record->outnormal), 2, ",", ".");
            $outaf = number_format(floatval($record->outaf), 2, ",", ".");
            $novnormal = number_format(floatval($record->novnormal), 2, ",", ".");
            $novaf = number_format(floatval($record->novaf), 2, ",", ".");
            $deznormal = number_format(floatval($record->deznormal), 2, ",", ".");
            $dezaf = number_format(floatval($record->dezaf), 2, ",", ".");

            //Soma dos valores normal e af de cada (linha)
            $linhatotalnormal = floatval($record->jannormal) + floatval($record->fevnormal) + floatval($record->marnormal) + floatval($record->abrnormal) + floatval($record->mainormal) + floatval($record->junnormal) + floatval($record->julnormal) + floatval($record->agsnormal) + floatval($record->setnormal) + floatval($record->outnormal) + floatval($record->novnormal) + floatval($record->deznormal);
            $linhatotalaf = floatval($record->janaf) + floatval($record->fevaf) + floatval($record->maraf) + floatval($record->abraf) + floatval($record->maiaf) + floatval($record->junaf) + floatval($record->julaf) + floatval($record->agsaf) + floatval($record->setaf) + floatval($record->outaf) + floatval($record->novaf) + floatval($record->dezaf);

            //Soma geral(total normal mais total af) de cada municipio (linha)
            $linhatotalgeral = $linhatotalnormal + $linhatotalaf;

            //Calculando percentagem normal e af de cada municipio (linha)
            //Evitando divisão por zero
            if($linhatotalgeral != 0){
                $calculopercentagemnormal = (($linhatotalnormal * 100)/$linhatotalgeral);
                $calculopercentagemaf = (($linhatotalaf * 100)/$linhatotalgeral);
            }else {
                $calculopercentagemnormal = 0;
                $calculopercentagemaf = 0;
            }



            $totalnormal = number_format($linhatotalnormal, 2, ",",".");
            $totalaf = number_format($linhatotalaf, 2, ",",".");
            $linhatotalgeral = number_format($linhatotalgeral, 2, ",",".");
            $linhapercentagemnormal = number_format($calculopercentagemnormal, 2, ",",".");
            $linhapercentagemaf = number_format($calculopercentagemaf, 2, ",", ".");


            $data_arr[] = array(
                "id"                => $id,
                "nomeentidade"      => $nomeentidade,
                "jannormal"         => $jannormal != '0,00' ? $jannormal : '',
                "janaf"             => $janaf != '0,00' ? $janaf : '',
                "fevnormal"         => $fevnormal != '0,00' ? $fevnormal : '',
                "fevaf"             => $fevaf != '0,00' ? $fevaf : '',
                "marnormal"         => $marnormal != '0,00' ? $marnormal : '',
                "maraf"             => $maraf != '0,00' ? $maraf : '',
                "abrnormal"         => $abrnormal != '0,00' ? $abrnormal : '',
                "abraf"             => $abraf != '0,00' ? $abraf : '',
                "mainormal"         => $mainormal != '0,00' ? $mainormal : '',
                "maiaf"             => $maiaf != '0,00' ? $maiaf : '',
                "junnormal"         => $junnormal != '0,00' ? $junnormal : '',
                "junaf"             => $junaf != '0,00' ? $junaf : '',
                "julnormal"         => $julnormal != '0,00' ? $julnormal : '',
                "julaf"             => $julaf != '0,00' ? $julaf : '',
                "agsnormal"         => $agsnormal != '0,00' ? $agsnormal : '',
                "agsaf"             => $agsaf != '0,00' ? $agsaf : '',
                "setnormal"         => $setnormal != '0,00' ? $setnormal : '',
                "setaf"             => $setaf != '0,00' ? $setaf : '',
                "outnormal"         => $outnormal != '0,00' ? $outnormal : '',
                "outaf"             => $outaf != '0,00' ? $outaf : '',
                "novnormal"         => $novnormal != '0,00' ? $novnormal : '',
                "novaf"             => $novaf != '0,00' ? $novaf : '',
                "deznormal"         => $deznormal != '0,00' ? $deznormal : '',
                "dezaf"             => $dezaf != '0,00' ? $dezaf : '',
                "totalnormal"       => $totalnormal != '0,00' ? $totalnormal : '',
                "totalaf"           => $totalaf != '0,00' ? $totalaf : '',
                "totalgeral"        => $linhatotalgeral != '0,00' ? $linhatotalgeral : '',
                "percentagemnormal" => $linhapercentagemnormal != '0,00' ? $linhapercentagemnormal : '',
                "percentagemaf"     => $linhapercentagemaf != '0,00' ? $linhapercentagemaf : '',

            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        echo json_encode($response);
        exit;
    }




    // Monitor Compras Mensais por Produtos
    public function ajaxgetProdutosComprasMensais(Request $request){

        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value


        // Obtendo o ano de referência (ano atual)
        //$anoRef = date("Y");
        $anoRef =  $request->periodo;

        // Obtendo o total de registros de acordo com os critérios de pesquia (fitro)
        $totalRecords = DB::table("bigtable_data")->select('produto_id')->whereYear("data_ini", "=",  $anoRef)->distinct('produto_id')->count();
        $totalRecordswithFilter =  DB::table('bigtable_data')
        ->select("count(*) as allcount")
        ->whereYear("data_ini", "=",  $anoRef)
        ->distinct('bigtable_data.produto_id')
        ->where('bigtable_data.produto_nome', 'like', '%' .$searchValue . '%')
        ->count();

        // Obtendo os valores das compras por mês (1 a 12), se da agricultura familiar ou não (normal ou af) no ano de referência
        // por meio de SUBQUERY utilizando a mesma tabela (bigtable_data) através do "joinSub"
        $valoresmeses = DB::table('bigtable_data')
        ->select(DB::RAW("data_ini, af, precototal, produto_id, produto_nome,
                SUM(IF(MONTH(data_ini) = 01 AND af = 'nao', precototal, 0.00)) AS mesjannormal,
                SUM(IF(MONTH(data_ini) = 01 AND af = 'sim', precototal, 0.00)) AS mesjanaf,
                SUM(IF(MONTH(data_ini) = 02 AND af = 'nao', precototal, 0.00)) AS mesfevnormal,
                SUM(IF(MONTH(data_ini) = 02 AND af = 'sim', precototal, 0.00)) AS mesfevaf,
                SUM(IF(MONTH(data_ini) = 03 AND af = 'nao', precototal, 0.00)) AS mesmarnormal,
                SUM(IF(MONTH(data_ini) = 03 AND af = 'sim', precototal, 0.00)) AS mesmaraf,
                SUM(IF(MONTH(data_ini) = 04 AND af = 'nao', precototal, 0.00)) AS mesabrnormal,
                SUM(IF(MONTH(data_ini) = 04 AND af = 'sim', precototal, 0.00)) AS mesabraf,
                SUM(IF(MONTH(data_ini) = 05 AND af = 'nao', precototal, 0.00)) AS mesmainormal,
                SUM(IF(MONTH(data_ini) = 05 AND af = 'sim', precototal, 0.00)) AS mesmaiaf,
                SUM(IF(MONTH(data_ini) = 06 AND af = 'nao', precototal, 0.00)) AS mesjunnormal,
                SUM(IF(MONTH(data_ini) = 06 AND af = 'sim', precototal, 0.00)) AS mesjunaf,
                SUM(IF(MONTH(data_ini) = 07 AND af = 'nao', precototal, 0.00)) AS mesjulnormal,
                SUM(IF(MONTH(data_ini) = 07 AND af = 'sim', precototal, 0.00)) AS mesjulaf,
                SUM(IF(MONTH(data_ini) = 08 AND af = 'nao', precototal, 0.00)) AS mesagsnormal,
                SUM(IF(MONTH(data_ini) = 08 AND af = 'sim', precototal, 0.00)) AS mesagsaf,
                SUM(IF(MONTH(data_ini) = 09 AND af = 'nao', precototal, 0.00)) AS messetnormal,
                SUM(IF(MONTH(data_ini) = 09 AND af = 'sim', precototal, 0.00)) AS messetaf,
                SUM(IF(MONTH(data_ini) = 10 AND af = 'nao', precototal, 0.00)) AS mesoutnormal,
                SUM(IF(MONTH(data_ini) = 10 AND af = 'sim', precototal, 0.00)) AS mesoutaf,
                SUM(IF(MONTH(data_ini) = 11 AND af = 'nao', precototal, 0.00)) AS mesnovnormal,
                SUM(IF(MONTH(data_ini) = 11 AND af = 'sim', precototal, 0.00)) AS mesnovaf,
                SUM(IF(MONTH(data_ini) = 12 AND af = 'nao', precototal, 0.00)) AS mesdeznormal,
                SUM(IF(MONTH(data_ini) = 12 AND af = 'sim', precototal, 0.00)) AS mesdezaf",

            )
        )
        ->whereYear("data_ini", "=",  $anoRef)
        ->groupByRaw("produto_id")
        ->orderByRaw("produto_nome");


        $records =  DB::table('bigtable_data')->joinSub($valoresmeses, 'aliasValoresMeses', function($join){
        $join->on('bigtable_data.produto_id', '=', 'aliasValoresMeses.produto_id');
        })->select(DB::raw("bigtable_data.produto_id AS id, bigtable_data.produto_nome AS nomeentidade, bigtable_data.data_ini,
                        aliasValoresMeses.mesjannormal AS jannormal, aliasValoresMeses.mesjanaf AS janaf, aliasValoresMeses.mesfevnormal AS fevnormal, aliasValoresMeses.mesfevaf AS fevaf, aliasValoresMeses.mesmarnormal AS marnormal, aliasValoresMeses.mesmaraf AS maraf,
                        aliasValoresMeses.mesabrnormal AS abrnormal, aliasValoresMeses.mesabraf AS abraf, aliasValoresMeses.mesmainormal AS mainormal, aliasValoresMeses.mesmaiaf AS maiaf, aliasValoresMeses.mesjunnormal AS junnormal, aliasValoresMeses.mesjunaf AS junaf,
                        aliasValoresMeses.mesjulnormal AS julnormal, aliasValoresMeses.mesjulaf AS julaf, aliasValoresMeses.mesagsnormal AS agsnormal, aliasValoresMeses.mesagsaf AS agsaf, aliasValoresMeses.messetnormal AS setnormal, aliasValoresMeses.messetaf AS setaf,
                        aliasValoresMeses.mesoutnormal AS outnormal, aliasValoresMeses.mesoutaf AS outaf, aliasValoresMeses.mesnovnormal AS novnormal, aliasValoresMeses.mesnovaf AS novaf, aliasValoresMeses.mesdeznormal AS deznormal, aliasValoresMeses.mesdezaf AS dezaf"
                    )
        )
        ->whereYear("bigtable_data.data_ini", "=",  $anoRef)
        ->where('bigtable_data.produto_nome', 'like', '%' .$searchValue . '%')
        ->groupBy("bigtable_data.produto_id")
        //->orderBy("bigtable_data.produto_nome")
        ->orderBy($columnName,$columnSortOrder)
        ->skip($start)
        ->take($rowperpage)
        ->get();


        $data_arr = array();

        $linhatotalnormal = 0;
        $linhatotalaf = 0;
        $linhatotalgeral = 0;
        $linhapercentagemnormal = 0;
        $linhapercentagemaf = 0;
        $calculopercentagemnormal = 0;
        $calculopercentagemaf = 0;

        foreach($records as $record){
            // Transformando o valor retornado em float e aplicando a a formatação decimal.
            $id = $record->id;
            $nomeentidade =  $record->nomeentidade;
            $jannormal = number_format(floatval($record->jannormal), 2, ",", ".");
            $janaf = number_format(floatval($record->janaf), 2, ",", ".");
            $fevnormal = number_format(floatval($record->fevnormal), 2, ",", ".");
            $fevaf = number_format(floatval($record->fevaf), 2, ",", ".");
            $marnormal = number_format(floatval($record->marnormal), 2, ",", ".");
            $maraf = number_format(floatval($record->maraf), 2, ",", ".");
            $abrnormal = number_format(floatval($record->abrnormal), 2, ",", ".");
            $abraf = number_format(floatval($record->abraf), 2, ",", ".");
            $mainormal = number_format(floatval($record->mainormal), 2, ",", ".");
            $maiaf = number_format(floatval($record->maiaf), 2, ",", ".");
            $junnormal = number_format(floatval($record->junnormal), 2, ",", ".");
            $junaf = number_format(floatval($record->junaf), 2, ",", ".");
            $julnormal = number_format(floatval($record->julnormal), 2, ",", ".");
            $julaf = number_format(floatval($record->julaf), 2, ",", ".");
            $agsnormal = number_format(floatval($record->agsnormal), 2, ",", ".");
            $agsaf = number_format(floatval($record->agsaf), 2, ",", ".");
            $setnormal = number_format(floatval($record->setnormal), 2, ",", ".");
            $setaf = number_format(floatval($record->setaf), 2, ",", ".");
            $outnormal = number_format(floatval($record->outnormal), 2, ",", ".");
            $outaf = number_format(floatval($record->outaf), 2, ",", ".");
            $novnormal = number_format(floatval($record->novnormal), 2, ",", ".");
            $novaf = number_format(floatval($record->novaf), 2, ",", ".");
            $deznormal = number_format(floatval($record->deznormal), 2, ",", ".");
            $dezaf = number_format(floatval($record->dezaf), 2, ",", ".");

            //Soma dos valores normal e af de cada (linha)
            $linhatotalnormal = floatval($record->jannormal) + floatval($record->fevnormal) + floatval($record->marnormal) + floatval($record->abrnormal) + floatval($record->mainormal) + floatval($record->junnormal) + floatval($record->julnormal) + floatval($record->agsnormal) + floatval($record->setnormal) + floatval($record->outnormal) + floatval($record->novnormal) + floatval($record->deznormal);
            $linhatotalaf = floatval($record->janaf) + floatval($record->fevaf) + floatval($record->maraf) + floatval($record->abraf) + floatval($record->maiaf) + floatval($record->junaf) + floatval($record->julaf) + floatval($record->agsaf) + floatval($record->setaf) + floatval($record->outaf) + floatval($record->novaf) + floatval($record->dezaf);

            //Soma geral(total normal mais total af) de cada municipio (linha)
            $linhatotalgeral = $linhatotalnormal + $linhatotalaf;

            //Calculando percentagem normal e af de cada municipio (linha)
            //Evitando divisão por zero
            if($linhatotalgeral != 0){
                $calculopercentagemnormal = (($linhatotalnormal * 100)/$linhatotalgeral);
                $calculopercentagemaf = (($linhatotalaf * 100)/$linhatotalgeral);
            }else {
                $calculopercentagemnormal = 0;
                $calculopercentagemaf = 0;
            }



            $totalnormal = number_format($linhatotalnormal, 2, ",",".");
            $totalaf = number_format($linhatotalaf, 2, ",",".");
            $linhatotalgeral = number_format($linhatotalgeral, 2, ",",".");
            $linhapercentagemnormal = number_format($calculopercentagemnormal, 2, ",",".");
            $linhapercentagemaf = number_format($calculopercentagemaf, 2, ",", ".");


            $data_arr[] = array(
                "id"                => $id,
                "nomeentidade"      => $nomeentidade,
                "jannormal"         => $jannormal != '0,00' ? $jannormal : '',
                "janaf"             => $janaf != '0,00' ? $janaf : '',
                "fevnormal"         => $fevnormal != '0,00' ? $fevnormal : '',
                "fevaf"             => $fevaf != '0,00' ? $fevaf : '',
                "marnormal"         => $marnormal != '0,00' ? $marnormal : '',
                "maraf"             => $maraf != '0,00' ? $maraf : '',
                "abrnormal"         => $abrnormal != '0,00' ? $abrnormal : '',
                "abraf"             => $abraf != '0,00' ? $abraf : '',
                "mainormal"         => $mainormal != '0,00' ? $mainormal : '',
                "maiaf"             => $maiaf != '0,00' ? $maiaf : '',
                "junnormal"         => $junnormal != '0,00' ? $junnormal : '',
                "junaf"             => $junaf != '0,00' ? $junaf : '',
                "julnormal"         => $julnormal != '0,00' ? $julnormal : '',
                "julaf"             => $julaf != '0,00' ? $julaf : '',
                "agsnormal"         => $agsnormal != '0,00' ? $agsnormal : '',
                "agsaf"             => $agsaf != '0,00' ? $agsaf : '',
                "setnormal"         => $setnormal != '0,00' ? $setnormal : '',
                "setaf"             => $setaf != '0,00' ? $setaf : '',
                "outnormal"         => $outnormal != '0,00' ? $outnormal : '',
                "outaf"             => $outaf != '0,00' ? $outaf : '',
                "novnormal"         => $novnormal != '0,00' ? $novnormal : '',
                "novaf"             => $novaf != '0,00' ? $novaf : '',
                "deznormal"         => $deznormal != '0,00' ? $deznormal : '',
                "dezaf"             => $dezaf != '0,00' ? $dezaf : '',
                "totalnormal"       => $totalnormal != '0,00' ? $totalnormal : '',
                "totalaf"           => $totalaf != '0,00' ? $totalaf : '',
                "totalgeral"        => $linhatotalgeral != '0,00' ? $linhatotalgeral : '',
                "percentagemnormal" => $linhapercentagemnormal != '0,00' ? $linhapercentagemnormal : '',
                "percentagemaf"     => $linhapercentagemaf != '0,00' ? $linhapercentagemaf : '',

            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        echo json_encode($response);
        exit;
    }


    // Requisição ajax simples, para carregar produtos de uma categoria específica
    public function ajaxgetProdutosDaCategoriaComprasMensais(Request $request){
        $idCat = $request->idcategoria;
        $records = DB::select(DB::raw("SELECT DISTINCT produto_id, produto_nome FROM bigtable_data WHERE categoria_id = $idCat ORDER BY produto_nome ASC"));
        return response()->json($records);
    }




    // Requisição ajax simples, para carregar os registros específicos das Regionais, Municípios ou Restaurantes
    public function ajaxgetCarregaRegistrosDaEntidade(Request $request){
        $entidade = $request->idEntidade;

        switch($entidade){
            case "1":
                $records = DB::select(DB::raw("SELECT DISTINCT regional_id AS id, regional_nome AS nome FROM bigtable_data ORDER BY regional_nome ASC"));
            break;
            case "2":
                $records = DB::select(DB::raw("SELECT DISTINCT municipio_id AS id, municipio_nome AS nome FROM bigtable_data ORDER BY municipio_nome ASC"));
            break;
            case "3":
                $records = DB::select(DB::raw("SELECT DISTINCT restaurante_id AS id, identificacao AS nome FROM bigtable_data ORDER BY identificacao ASC"));
            break;
        }

        return response()->json($records);
    }


    // Monitor Compras Mensais Categorias por Entidade (Regionais, Município ou Restaurantes)
    public function ajaxgetCategoriasPorEntidadeComprasMensais(Request $request){

        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value


        // Obtendo os parâmetros enviado via ajax do objeto dataTable(oTable)
        $anoRef     =  $request->periodo;
        $entitRef   = $request->entidade;
        $categRef   = $request->categoria;
        $prodRef    = $request->produto;

        switch($entitRef){
            case "1":
                $entidade_id = "regional_id";
                $entidade_nome =  "regional_nome";
            break;
            case "2":
                $entidade_id = "municipio_id";
                $entidade_nome = "municipio_nome";
            break;
            case "3":
                $entidade_id = "restaurante_id";
                $entidade_nome =  "identificacao";
            break;
        }



        // Obtendo o total de registros de acordo com os critérios de pesquia (fitro)
        $totalRecords = DB::table("bigtable_data")->select("$entidade_id")->where("categoria_id", "=", $categRef)->whereYear("data_ini", "=",  $anoRef)->distinct("$entidade_id")->count();
        $totalRecordswithFilter =  DB::table('bigtable_data')
        ->select("count(*) as allcount")
        ->where("categoria_id", "=", $categRef)
        ->whereYear("data_ini", "=",  $anoRef)
        ->distinct("bigtable_data.$entidade_id")
        ->where("bigtable_data.$entidade_nome", "like", "%" .$searchValue . "%")
        ->count();

        // Obtendo os valores das compras por mês (1 a 12), se da agricultura familiar ou não (normal ou af) no ano de referência
        // por meio de SUBQUERY utilizando a mesma tabela (bigtable_data) através do "joinSub"
        $valoresmeses = DB::table('bigtable_data')
        ->select(DB::RAW("data_ini, af, precototal, $entidade_id, $entidade_nome,
                SUM(IF(MONTH(data_ini) = 01 AND af = 'nao', precototal, 0.00)) AS mesjannormal,
                SUM(IF(MONTH(data_ini) = 01 AND af = 'sim', precototal, 0.00)) AS mesjanaf,
                SUM(IF(MONTH(data_ini) = 02 AND af = 'nao', precototal, 0.00)) AS mesfevnormal,
                SUM(IF(MONTH(data_ini) = 02 AND af = 'sim', precototal, 0.00)) AS mesfevaf,
                SUM(IF(MONTH(data_ini) = 03 AND af = 'nao', precototal, 0.00)) AS mesmarnormal,
                SUM(IF(MONTH(data_ini) = 03 AND af = 'sim', precototal, 0.00)) AS mesmaraf,
                SUM(IF(MONTH(data_ini) = 04 AND af = 'nao', precototal, 0.00)) AS mesabrnormal,
                SUM(IF(MONTH(data_ini) = 04 AND af = 'sim', precototal, 0.00)) AS mesabraf,
                SUM(IF(MONTH(data_ini) = 05 AND af = 'nao', precototal, 0.00)) AS mesmainormal,
                SUM(IF(MONTH(data_ini) = 05 AND af = 'sim', precototal, 0.00)) AS mesmaiaf,
                SUM(IF(MONTH(data_ini) = 06 AND af = 'nao', precototal, 0.00)) AS mesjunnormal,
                SUM(IF(MONTH(data_ini) = 06 AND af = 'sim', precototal, 0.00)) AS mesjunaf,
                SUM(IF(MONTH(data_ini) = 07 AND af = 'nao', precototal, 0.00)) AS mesjulnormal,
                SUM(IF(MONTH(data_ini) = 07 AND af = 'sim', precototal, 0.00)) AS mesjulaf,
                SUM(IF(MONTH(data_ini) = 08 AND af = 'nao', precototal, 0.00)) AS mesagsnormal,
                SUM(IF(MONTH(data_ini) = 08 AND af = 'sim', precototal, 0.00)) AS mesagsaf,
                SUM(IF(MONTH(data_ini) = 09 AND af = 'nao', precototal, 0.00)) AS messetnormal,
                SUM(IF(MONTH(data_ini) = 09 AND af = 'sim', precototal, 0.00)) AS messetaf,
                SUM(IF(MONTH(data_ini) = 10 AND af = 'nao', precototal, 0.00)) AS mesoutnormal,
                SUM(IF(MONTH(data_ini) = 10 AND af = 'sim', precototal, 0.00)) AS mesoutaf,
                SUM(IF(MONTH(data_ini) = 11 AND af = 'nao', precototal, 0.00)) AS mesnovnormal,
                SUM(IF(MONTH(data_ini) = 11 AND af = 'sim', precototal, 0.00)) AS mesnovaf,
                SUM(IF(MONTH(data_ini) = 12 AND af = 'nao', precototal, 0.00)) AS mesdeznormal,
                SUM(IF(MONTH(data_ini) = 12 AND af = 'sim', precototal, 0.00)) AS mesdezaf",

            )
        )
        ->whereYear("data_ini", "=",  $anoRef)
        ->where("categoria_id", "=", $categRef)
        ->groupByRaw("$entidade_id")
        ->orderByRaw("$entidade_nome");

        // Utilizando uma variável externa dentro de uma cláusua joinSub com "use", caso contrário a mesma não é reconhecida pelo Laravel
        $records =  DB::table("bigtable_data")->joinSub($valoresmeses, "aliasValoresMeses", function($join) use($entidade_id){
            $join->on("bigtable_data.$entidade_id", "=", "aliasValoresMeses.$entidade_id");
        })->select(DB::raw("bigtable_data.$entidade_id AS id, bigtable_data.$entidade_nome AS nomeentidade, bigtable_data.data_ini,
                        aliasValoresMeses.mesjannormal AS jannormal, aliasValoresMeses.mesjanaf AS janaf, aliasValoresMeses.mesfevnormal AS fevnormal, aliasValoresMeses.mesfevaf AS fevaf, aliasValoresMeses.mesmarnormal AS marnormal, aliasValoresMeses.mesmaraf AS maraf,
                        aliasValoresMeses.mesabrnormal AS abrnormal, aliasValoresMeses.mesabraf AS abraf, aliasValoresMeses.mesmainormal AS mainormal, aliasValoresMeses.mesmaiaf AS maiaf, aliasValoresMeses.mesjunnormal AS junnormal, aliasValoresMeses.mesjunaf AS junaf,
                        aliasValoresMeses.mesjulnormal AS julnormal, aliasValoresMeses.mesjulaf AS julaf, aliasValoresMeses.mesagsnormal AS agsnormal, aliasValoresMeses.mesagsaf AS agsaf, aliasValoresMeses.messetnormal AS setnormal, aliasValoresMeses.messetaf AS setaf,
                        aliasValoresMeses.mesoutnormal AS outnormal, aliasValoresMeses.mesoutaf AS outaf, aliasValoresMeses.mesnovnormal AS novnormal, aliasValoresMeses.mesnovaf AS novaf, aliasValoresMeses.mesdeznormal AS deznormal, aliasValoresMeses.mesdezaf AS dezaf"
                    )
        )
        ->whereYear("bigtable_data.data_ini", "=",  $anoRef)
        ->where("bigtable_data.$entidade_nome", "like", "%" .$searchValue . "%")
        ->groupBy("bigtable_data.$entidade_id")
        //->orderBy("bigtable_data.produto_nome")
        ->orderBy($columnName,$columnSortOrder)
        ->skip($start)
        ->take($rowperpage)
        ->get();


        $data_arr = array();

        $linhatotalnormal = 0;
        $linhatotalaf = 0;
        $linhatotalgeral = 0;
        $linhapercentagemnormal = 0;
        $linhapercentagemaf = 0;
        $calculopercentagemnormal = 0;
        $calculopercentagemaf = 0;

        foreach($records as $record){
            // Transformando o valor retornado em float e aplicando a a formatação decimal.
            $id = $record->id;
            $nomeentidade =  $record->nomeentidade;
            $jannormal = number_format(floatval($record->jannormal), 2, ",", ".");
            $janaf = number_format(floatval($record->janaf), 2, ",", ".");
            $fevnormal = number_format(floatval($record->fevnormal), 2, ",", ".");
            $fevaf = number_format(floatval($record->fevaf), 2, ",", ".");
            $marnormal = number_format(floatval($record->marnormal), 2, ",", ".");
            $maraf = number_format(floatval($record->maraf), 2, ",", ".");
            $abrnormal = number_format(floatval($record->abrnormal), 2, ",", ".");
            $abraf = number_format(floatval($record->abraf), 2, ",", ".");
            $mainormal = number_format(floatval($record->mainormal), 2, ",", ".");
            $maiaf = number_format(floatval($record->maiaf), 2, ",", ".");
            $junnormal = number_format(floatval($record->junnormal), 2, ",", ".");
            $junaf = number_format(floatval($record->junaf), 2, ",", ".");
            $julnormal = number_format(floatval($record->julnormal), 2, ",", ".");
            $julaf = number_format(floatval($record->julaf), 2, ",", ".");
            $agsnormal = number_format(floatval($record->agsnormal), 2, ",", ".");
            $agsaf = number_format(floatval($record->agsaf), 2, ",", ".");
            $setnormal = number_format(floatval($record->setnormal), 2, ",", ".");
            $setaf = number_format(floatval($record->setaf), 2, ",", ".");
            $outnormal = number_format(floatval($record->outnormal), 2, ",", ".");
            $outaf = number_format(floatval($record->outaf), 2, ",", ".");
            $novnormal = number_format(floatval($record->novnormal), 2, ",", ".");
            $novaf = number_format(floatval($record->novaf), 2, ",", ".");
            $deznormal = number_format(floatval($record->deznormal), 2, ",", ".");
            $dezaf = number_format(floatval($record->dezaf), 2, ",", ".");

            //Soma dos valores normal e af de cada (linha)
            $linhatotalnormal = floatval($record->jannormal) + floatval($record->fevnormal) + floatval($record->marnormal) + floatval($record->abrnormal) + floatval($record->mainormal) + floatval($record->junnormal) + floatval($record->julnormal) + floatval($record->agsnormal) + floatval($record->setnormal) + floatval($record->outnormal) + floatval($record->novnormal) + floatval($record->deznormal);
            $linhatotalaf = floatval($record->janaf) + floatval($record->fevaf) + floatval($record->maraf) + floatval($record->abraf) + floatval($record->maiaf) + floatval($record->junaf) + floatval($record->julaf) + floatval($record->agsaf) + floatval($record->setaf) + floatval($record->outaf) + floatval($record->novaf) + floatval($record->dezaf);

            //Soma geral(total normal mais total af) de cada municipio (linha)
            $linhatotalgeral = $linhatotalnormal + $linhatotalaf;

            //Calculando percentagem normal e af de cada municipio (linha)
            //Evitando divisão por zero
            if($linhatotalgeral != 0){
                $calculopercentagemnormal = (($linhatotalnormal * 100)/$linhatotalgeral);
                $calculopercentagemaf = (($linhatotalaf * 100)/$linhatotalgeral);
            }else {
                $calculopercentagemnormal = 0;
                $calculopercentagemaf = 0;
            }



            $totalnormal = number_format($linhatotalnormal, 2, ",",".");
            $totalaf = number_format($linhatotalaf, 2, ",",".");
            $linhatotalgeral = number_format($linhatotalgeral, 2, ",",".");
            $linhapercentagemnormal = number_format($calculopercentagemnormal, 2, ",",".");
            $linhapercentagemaf = number_format($calculopercentagemaf, 2, ",", ".");


            $data_arr[] = array(
                "id"                => $id,
                "nomeentidade"      => $nomeentidade,
                "jannormal"         => $jannormal != '0,00' ? $jannormal : '',
                "janaf"             => $janaf != '0,00' ? $janaf : '',
                "fevnormal"         => $fevnormal != '0,00' ? $fevnormal : '',
                "fevaf"             => $fevaf != '0,00' ? $fevaf : '',
                "marnormal"         => $marnormal != '0,00' ? $marnormal : '',
                "maraf"             => $maraf != '0,00' ? $maraf : '',
                "abrnormal"         => $abrnormal != '0,00' ? $abrnormal : '',
                "abraf"             => $abraf != '0,00' ? $abraf : '',
                "mainormal"         => $mainormal != '0,00' ? $mainormal : '',
                "maiaf"             => $maiaf != '0,00' ? $maiaf : '',
                "junnormal"         => $junnormal != '0,00' ? $junnormal : '',
                "junaf"             => $junaf != '0,00' ? $junaf : '',
                "julnormal"         => $julnormal != '0,00' ? $julnormal : '',
                "julaf"             => $julaf != '0,00' ? $julaf : '',
                "agsnormal"         => $agsnormal != '0,00' ? $agsnormal : '',
                "agsaf"             => $agsaf != '0,00' ? $agsaf : '',
                "setnormal"         => $setnormal != '0,00' ? $setnormal : '',
                "setaf"             => $setaf != '0,00' ? $setaf : '',
                "outnormal"         => $outnormal != '0,00' ? $outnormal : '',
                "outaf"             => $outaf != '0,00' ? $outaf : '',
                "novnormal"         => $novnormal != '0,00' ? $novnormal : '',
                "novaf"             => $novaf != '0,00' ? $novaf : '',
                "deznormal"         => $deznormal != '0,00' ? $deznormal : '',
                "dezaf"             => $dezaf != '0,00' ? $dezaf : '',
                "totalnormal"       => $totalnormal != '0,00' ? $totalnormal : '',
                "totalaf"           => $totalaf != '0,00' ? $totalaf : '',
                "totalgeral"        => $linhatotalgeral != '0,00' ? $linhatotalgeral : '',
                "percentagemnormal" => $linhapercentagemnormal != '0,00' ? $linhapercentagemnormal : '',
                "percentagemaf"     => $linhapercentagemaf != '0,00' ? $linhapercentagemaf : '',

            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        echo json_encode($response);
        exit;
    }


    // Monitor Compras Mensais Produtos por Entidade (Regionais, Município ou Restaurantes)
    public function ajaxgetProdutosPorEntidadeComprasMensais(Request $request){

        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value


        // Obtendo os parâmetros enviado via ajax
        $anoRef     =  $request->periodo;
        $entitRef   = $request->entidade;
        $categRef   = $request->categoria;
        $prodRef    = $request->produto;

        switch($entitRef){
            case "1":
                $entidade_id = "regional_id";
                $entidade_nome =  "regional_nome";
            break;
            case "2":
                $entidade_id = "municipio_id";
                $entidade_nome = "municipio_nome";
            break;
            case "3":
                $entidade_id = "restaurante_id";
                $entidade_nome =  "identificacao";
            break;
        }



        // Obtendo o total de registros de acordo com os critérios de pesquia (fitro)
        $totalRecords = DB::table("bigtable_data")->select("$entidade_id")->where("produto_id", "=", $prodRef)->whereYear("data_ini", "=",  $anoRef)->distinct("$entidade_id")->count();
        $totalRecordswithFilter =  DB::table('bigtable_data')
        ->select("count(*) as allcount")
        ->where("produto_id", "=", $prodRef)
        ->whereYear("data_ini", "=",  $anoRef)
        ->distinct("bigtable_data.$entidade_id")
        ->where("bigtable_data.$entidade_nome", "like", "%" .$searchValue . "%")
        ->count();

        // Obtendo os valores das compras por mês (1 a 12), se da agricultura familiar ou não (normal ou af) no ano de referência
        // por meio de SUBQUERY utilizando a mesma tabela (bigtable_data) através do "joinSub"
        $valoresmeses = DB::table('bigtable_data')
        ->select(DB::RAW("data_ini, af, precototal, $entidade_id, $entidade_nome,
                SUM(IF(MONTH(data_ini) = 01 AND af = 'nao', precototal, 0.00)) AS mesjannormal,
                SUM(IF(MONTH(data_ini) = 01 AND af = 'sim', precototal, 0.00)) AS mesjanaf,
                SUM(IF(MONTH(data_ini) = 02 AND af = 'nao', precototal, 0.00)) AS mesfevnormal,
                SUM(IF(MONTH(data_ini) = 02 AND af = 'sim', precototal, 0.00)) AS mesfevaf,
                SUM(IF(MONTH(data_ini) = 03 AND af = 'nao', precototal, 0.00)) AS mesmarnormal,
                SUM(IF(MONTH(data_ini) = 03 AND af = 'sim', precototal, 0.00)) AS mesmaraf,
                SUM(IF(MONTH(data_ini) = 04 AND af = 'nao', precototal, 0.00)) AS mesabrnormal,
                SUM(IF(MONTH(data_ini) = 04 AND af = 'sim', precototal, 0.00)) AS mesabraf,
                SUM(IF(MONTH(data_ini) = 05 AND af = 'nao', precototal, 0.00)) AS mesmainormal,
                SUM(IF(MONTH(data_ini) = 05 AND af = 'sim', precototal, 0.00)) AS mesmaiaf,
                SUM(IF(MONTH(data_ini) = 06 AND af = 'nao', precototal, 0.00)) AS mesjunnormal,
                SUM(IF(MONTH(data_ini) = 06 AND af = 'sim', precototal, 0.00)) AS mesjunaf,
                SUM(IF(MONTH(data_ini) = 07 AND af = 'nao', precototal, 0.00)) AS mesjulnormal,
                SUM(IF(MONTH(data_ini) = 07 AND af = 'sim', precototal, 0.00)) AS mesjulaf,
                SUM(IF(MONTH(data_ini) = 08 AND af = 'nao', precototal, 0.00)) AS mesagsnormal,
                SUM(IF(MONTH(data_ini) = 08 AND af = 'sim', precototal, 0.00)) AS mesagsaf,
                SUM(IF(MONTH(data_ini) = 09 AND af = 'nao', precototal, 0.00)) AS messetnormal,
                SUM(IF(MONTH(data_ini) = 09 AND af = 'sim', precototal, 0.00)) AS messetaf,
                SUM(IF(MONTH(data_ini) = 10 AND af = 'nao', precototal, 0.00)) AS mesoutnormal,
                SUM(IF(MONTH(data_ini) = 10 AND af = 'sim', precototal, 0.00)) AS mesoutaf,
                SUM(IF(MONTH(data_ini) = 11 AND af = 'nao', precototal, 0.00)) AS mesnovnormal,
                SUM(IF(MONTH(data_ini) = 11 AND af = 'sim', precototal, 0.00)) AS mesnovaf,
                SUM(IF(MONTH(data_ini) = 12 AND af = 'nao', precototal, 0.00)) AS mesdeznormal,
                SUM(IF(MONTH(data_ini) = 12 AND af = 'sim', precototal, 0.00)) AS mesdezaf",

            )
        )
        ->whereYear("data_ini", "=",  $anoRef)
        ->where("produto_id", "=", $prodRef)
        ->groupByRaw("$entidade_id")
        ->orderByRaw("$entidade_nome");

        // Utilizando uma variável externa dentro de uma cláusua joinSub com "use", caso contrário a mesma não é reconhecida pelo Laravel
        $records =  DB::table("bigtable_data")->joinSub($valoresmeses, "aliasValoresMeses", function($join) use($entidade_id){
            $join->on("bigtable_data.$entidade_id", "=", "aliasValoresMeses.$entidade_id");
        })->select(DB::raw("bigtable_data.$entidade_id AS id, bigtable_data.$entidade_nome AS nomeentidade, bigtable_data.data_ini,
                        aliasValoresMeses.mesjannormal AS jannormal, aliasValoresMeses.mesjanaf AS janaf, aliasValoresMeses.mesfevnormal AS fevnormal, aliasValoresMeses.mesfevaf AS fevaf, aliasValoresMeses.mesmarnormal AS marnormal, aliasValoresMeses.mesmaraf AS maraf,
                        aliasValoresMeses.mesabrnormal AS abrnormal, aliasValoresMeses.mesabraf AS abraf, aliasValoresMeses.mesmainormal AS mainormal, aliasValoresMeses.mesmaiaf AS maiaf, aliasValoresMeses.mesjunnormal AS junnormal, aliasValoresMeses.mesjunaf AS junaf,
                        aliasValoresMeses.mesjulnormal AS julnormal, aliasValoresMeses.mesjulaf AS julaf, aliasValoresMeses.mesagsnormal AS agsnormal, aliasValoresMeses.mesagsaf AS agsaf, aliasValoresMeses.messetnormal AS setnormal, aliasValoresMeses.messetaf AS setaf,
                        aliasValoresMeses.mesoutnormal AS outnormal, aliasValoresMeses.mesoutaf AS outaf, aliasValoresMeses.mesnovnormal AS novnormal, aliasValoresMeses.mesnovaf AS novaf, aliasValoresMeses.mesdeznormal AS deznormal, aliasValoresMeses.mesdezaf AS dezaf"
                    )
        )
        ->whereYear("bigtable_data.data_ini", "=",  $anoRef)
        ->where("bigtable_data.$entidade_nome", "like", "%" .$searchValue . "%")
        ->groupBy("bigtable_data.$entidade_id")
        //->orderBy("bigtable_data.produto_nome")
        ->orderBy($columnName,$columnSortOrder)
        ->skip($start)
        ->take($rowperpage)
        ->get();


        $data_arr = array();

        $linhatotalnormal = 0;
        $linhatotalaf = 0;
        $linhatotalgeral = 0;
        $linhapercentagemnormal = 0;
        $linhapercentagemaf = 0;
        $calculopercentagemnormal = 0;
        $calculopercentagemaf = 0;

        foreach($records as $record){
            // Transformando o valor retornado em float e aplicando a a formatação decimal.
            $id = $record->id;
            $nomeentidade =  $record->nomeentidade;
            $jannormal = number_format(floatval($record->jannormal), 2, ",", ".");
            $janaf = number_format(floatval($record->janaf), 2, ",", ".");
            $fevnormal = number_format(floatval($record->fevnormal), 2, ",", ".");
            $fevaf = number_format(floatval($record->fevaf), 2, ",", ".");
            $marnormal = number_format(floatval($record->marnormal), 2, ",", ".");
            $maraf = number_format(floatval($record->maraf), 2, ",", ".");
            $abrnormal = number_format(floatval($record->abrnormal), 2, ",", ".");
            $abraf = number_format(floatval($record->abraf), 2, ",", ".");
            $mainormal = number_format(floatval($record->mainormal), 2, ",", ".");
            $maiaf = number_format(floatval($record->maiaf), 2, ",", ".");
            $junnormal = number_format(floatval($record->junnormal), 2, ",", ".");
            $junaf = number_format(floatval($record->junaf), 2, ",", ".");
            $julnormal = number_format(floatval($record->julnormal), 2, ",", ".");
            $julaf = number_format(floatval($record->julaf), 2, ",", ".");
            $agsnormal = number_format(floatval($record->agsnormal), 2, ",", ".");
            $agsaf = number_format(floatval($record->agsaf), 2, ",", ".");
            $setnormal = number_format(floatval($record->setnormal), 2, ",", ".");
            $setaf = number_format(floatval($record->setaf), 2, ",", ".");
            $outnormal = number_format(floatval($record->outnormal), 2, ",", ".");
            $outaf = number_format(floatval($record->outaf), 2, ",", ".");
            $novnormal = number_format(floatval($record->novnormal), 2, ",", ".");
            $novaf = number_format(floatval($record->novaf), 2, ",", ".");
            $deznormal = number_format(floatval($record->deznormal), 2, ",", ".");
            $dezaf = number_format(floatval($record->dezaf), 2, ",", ".");

            //Soma dos valores normal e af de cada (linha)
            $linhatotalnormal = floatval($record->jannormal) + floatval($record->fevnormal) + floatval($record->marnormal) + floatval($record->abrnormal) + floatval($record->mainormal) + floatval($record->junnormal) + floatval($record->julnormal) + floatval($record->agsnormal) + floatval($record->setnormal) + floatval($record->outnormal) + floatval($record->novnormal) + floatval($record->deznormal);
            $linhatotalaf = floatval($record->janaf) + floatval($record->fevaf) + floatval($record->maraf) + floatval($record->abraf) + floatval($record->maiaf) + floatval($record->junaf) + floatval($record->julaf) + floatval($record->agsaf) + floatval($record->setaf) + floatval($record->outaf) + floatval($record->novaf) + floatval($record->dezaf);

            //Soma geral(total normal mais total af) de cada municipio (linha)
            $linhatotalgeral = $linhatotalnormal + $linhatotalaf;

            //Calculando percentagem normal e af de cada municipio (linha)
            //Evitando divisão por zero
            if($linhatotalgeral != 0){
                $calculopercentagemnormal = (($linhatotalnormal * 100)/$linhatotalgeral);
                $calculopercentagemaf = (($linhatotalaf * 100)/$linhatotalgeral);
            }else {
                $calculopercentagemnormal = 0;
                $calculopercentagemaf = 0;
            }



            $totalnormal = number_format($linhatotalnormal, 2, ",",".");
            $totalaf = number_format($linhatotalaf, 2, ",",".");
            $linhatotalgeral = number_format($linhatotalgeral, 2, ",",".");
            $linhapercentagemnormal = number_format($calculopercentagemnormal, 2, ",",".");
            $linhapercentagemaf = number_format($calculopercentagemaf, 2, ",", ".");


            $data_arr[] = array(
                "id"                => $id,
                "nomeentidade"      => $nomeentidade,
                "jannormal"         => $jannormal != '0,00' ? $jannormal : '',
                "janaf"             => $janaf != '0,00' ? $janaf : '',
                "fevnormal"         => $fevnormal != '0,00' ? $fevnormal : '',
                "fevaf"             => $fevaf != '0,00' ? $fevaf : '',
                "marnormal"         => $marnormal != '0,00' ? $marnormal : '',
                "maraf"             => $maraf != '0,00' ? $maraf : '',
                "abrnormal"         => $abrnormal != '0,00' ? $abrnormal : '',
                "abraf"             => $abraf != '0,00' ? $abraf : '',
                "mainormal"         => $mainormal != '0,00' ? $mainormal : '',
                "maiaf"             => $maiaf != '0,00' ? $maiaf : '',
                "junnormal"         => $junnormal != '0,00' ? $junnormal : '',
                "junaf"             => $junaf != '0,00' ? $junaf : '',
                "julnormal"         => $julnormal != '0,00' ? $julnormal : '',
                "julaf"             => $julaf != '0,00' ? $julaf : '',
                "agsnormal"         => $agsnormal != '0,00' ? $agsnormal : '',
                "agsaf"             => $agsaf != '0,00' ? $agsaf : '',
                "setnormal"         => $setnormal != '0,00' ? $setnormal : '',
                "setaf"             => $setaf != '0,00' ? $setaf : '',
                "outnormal"         => $outnormal != '0,00' ? $outnormal : '',
                "outaf"             => $outaf != '0,00' ? $outaf : '',
                "novnormal"         => $novnormal != '0,00' ? $novnormal : '',
                "novaf"             => $novaf != '0,00' ? $novaf : '',
                "deznormal"         => $deznormal != '0,00' ? $deznormal : '',
                "dezaf"             => $dezaf != '0,00' ? $dezaf : '',
                "totalnormal"       => $totalnormal != '0,00' ? $totalnormal : '',
                "totalaf"           => $totalaf != '0,00' ? $totalaf : '',
                "totalgeral"        => $linhatotalgeral != '0,00' ? $linhatotalgeral : '',
                "percentagemnormal" => $linhapercentagemnormal != '0,00' ? $linhapercentagemnormal : '',
                "percentagemaf"     => $linhapercentagemaf != '0,00' ? $linhapercentagemaf : '',

            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        echo json_encode($response);
        exit;
    }



    // Monitor Compras Mensais por Categorias ou Produtos de um Registro Específico (Regionais, Município ou Restaurantes)
    public function ajaxgetComprasPorCategoriasOuProdutos(Request $request){

        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value


        // Obtendo os parâmetros enviado via ajax do objeto dataTable(oTable)
        $entitRef       = $request->entidade;
        $idregRef       = $request->registro;
        $campocatprod   = $request->catprod;
        $anoRef         =  $request->periodo;

        switch($entitRef){
            case "1":
                $entidade_id = "regional_id";
                $entidade_nome =  "regional_nome";
            break;
            case "2":
                $entidade_id = "municipio_id";
                $entidade_nome = "municipio_nome";
            break;
            case "3":
                $entidade_id = "restaurante_id";
                $entidade_nome =  "identificacao";
            break;
        }

        // Define por qual campo pesquisar
        if($campocatprod == "1"){
            $campo_id = "categoria_id";
            $campo_nome = "categoria_nome";
        }else{
            $campo_id = "produto_id";
            $campo_nome = "produto_nome";
        }


        // Obtendo o total de registros de acordo com os critérios de pesquia (fitro)
        // Obs: A linha: ->select("count($campo_id) as allcount") pode substitui a linha: ->where("$campo_id", "<>", 0), PERFEITAMENTE, uma vez que count($campo_id), retorna todos os valores não nulos
        $totalRecords = DB::table("bigtable_data")->select("$campo_id")->where("$entidade_id", "=", $idregRef)->whereYear("data_ini", "=",  $anoRef)->distinct("$campo_id")->count();
        $totalRecordswithFilter =  DB::table('bigtable_data')
        ->select("count(*) as allcount")
        ->where("$campo_id", "<>", 0)
        ->where("$entidade_id", "=", $idregRef)
        ->whereYear("data_ini", "=",  $anoRef)
        ->distinct("bigtable_data.$campo_id")
        ->where("bigtable_data.$campo_nome", "like", "%" .$searchValue . "%")
        ->count();


        // Obtendo os valores das compras por mês (1 a 12), se da agricultura familiar ou não (normal ou af) no ano de referência
        // por meio de SUBQUERY utilizando a mesma tabela (bigtable_data) através do "joinSub"
        $valoresmeses = DB::table('bigtable_data')
        ->select(DB::RAW("data_ini, af, precototal, $campo_id, $campo_nome,
                SUM(IF(MONTH(data_ini) = 01 AND af = 'nao', precototal, 0.00)) AS mesjannormal,
                SUM(IF(MONTH(data_ini) = 01 AND af = 'sim', precototal, 0.00)) AS mesjanaf,
                SUM(IF(MONTH(data_ini) = 02 AND af = 'nao', precototal, 0.00)) AS mesfevnormal,
                SUM(IF(MONTH(data_ini) = 02 AND af = 'sim', precototal, 0.00)) AS mesfevaf,
                SUM(IF(MONTH(data_ini) = 03 AND af = 'nao', precototal, 0.00)) AS mesmarnormal,
                SUM(IF(MONTH(data_ini) = 03 AND af = 'sim', precototal, 0.00)) AS mesmaraf,
                SUM(IF(MONTH(data_ini) = 04 AND af = 'nao', precototal, 0.00)) AS mesabrnormal,
                SUM(IF(MONTH(data_ini) = 04 AND af = 'sim', precototal, 0.00)) AS mesabraf,
                SUM(IF(MONTH(data_ini) = 05 AND af = 'nao', precototal, 0.00)) AS mesmainormal,
                SUM(IF(MONTH(data_ini) = 05 AND af = 'sim', precototal, 0.00)) AS mesmaiaf,
                SUM(IF(MONTH(data_ini) = 06 AND af = 'nao', precototal, 0.00)) AS mesjunnormal,
                SUM(IF(MONTH(data_ini) = 06 AND af = 'sim', precototal, 0.00)) AS mesjunaf,
                SUM(IF(MONTH(data_ini) = 07 AND af = 'nao', precototal, 0.00)) AS mesjulnormal,
                SUM(IF(MONTH(data_ini) = 07 AND af = 'sim', precototal, 0.00)) AS mesjulaf,
                SUM(IF(MONTH(data_ini) = 08 AND af = 'nao', precototal, 0.00)) AS mesagsnormal,
                SUM(IF(MONTH(data_ini) = 08 AND af = 'sim', precototal, 0.00)) AS mesagsaf,
                SUM(IF(MONTH(data_ini) = 09 AND af = 'nao', precototal, 0.00)) AS messetnormal,
                SUM(IF(MONTH(data_ini) = 09 AND af = 'sim', precototal, 0.00)) AS messetaf,
                SUM(IF(MONTH(data_ini) = 10 AND af = 'nao', precototal, 0.00)) AS mesoutnormal,
                SUM(IF(MONTH(data_ini) = 10 AND af = 'sim', precototal, 0.00)) AS mesoutaf,
                SUM(IF(MONTH(data_ini) = 11 AND af = 'nao', precototal, 0.00)) AS mesnovnormal,
                SUM(IF(MONTH(data_ini) = 11 AND af = 'sim', precototal, 0.00)) AS mesnovaf,
                SUM(IF(MONTH(data_ini) = 12 AND af = 'nao', precototal, 0.00)) AS mesdeznormal,
                SUM(IF(MONTH(data_ini) = 12 AND af = 'sim', precototal, 0.00)) AS mesdezaf",
            )
        )
        ->whereYear("data_ini", "=",  $anoRef)
        ->where("$entidade_id", "=", $idregRef)
        ->groupByRaw("$campo_id")
        ->orderByRaw("$campo_nome");


        // Utilizando uma variável externa dentro de uma cláusua joinSub com "use", caso contrário a mesma não é reconhecida pelo Laravel
        $records =  DB::table("bigtable_data")->joinSub($valoresmeses, "aliasValoresMeses", function($join) use($campo_id){
            $join->on("bigtable_data.$campo_id", "=", "aliasValoresMeses.$campo_id");
        })->select(DB::raw("bigtable_data.$campo_id AS id, bigtable_data.$campo_nome AS nomeentidade, bigtable_data.data_ini,
                        aliasValoresMeses.mesjannormal AS jannormal, aliasValoresMeses.mesjanaf AS janaf, aliasValoresMeses.mesfevnormal AS fevnormal, aliasValoresMeses.mesfevaf AS fevaf, aliasValoresMeses.mesmarnormal AS marnormal, aliasValoresMeses.mesmaraf AS maraf,
                        aliasValoresMeses.mesabrnormal AS abrnormal, aliasValoresMeses.mesabraf AS abraf, aliasValoresMeses.mesmainormal AS mainormal, aliasValoresMeses.mesmaiaf AS maiaf, aliasValoresMeses.mesjunnormal AS junnormal, aliasValoresMeses.mesjunaf AS junaf,
                        aliasValoresMeses.mesjulnormal AS julnormal, aliasValoresMeses.mesjulaf AS julaf, aliasValoresMeses.mesagsnormal AS agsnormal, aliasValoresMeses.mesagsaf AS agsaf, aliasValoresMeses.messetnormal AS setnormal, aliasValoresMeses.messetaf AS setaf,
                        aliasValoresMeses.mesoutnormal AS outnormal, aliasValoresMeses.mesoutaf AS outaf, aliasValoresMeses.mesnovnormal AS novnormal, aliasValoresMeses.mesnovaf AS novaf, aliasValoresMeses.mesdeznormal AS deznormal, aliasValoresMeses.mesdezaf AS dezaf"
                    )
        )
        ->whereYear("bigtable_data.data_ini", "=",  $anoRef)
        ->where("bigtable_data.$campo_nome", "like", "%" .$searchValue . "%")
        ->groupBy("bigtable_data.$campo_id")
        //->orderBy("bigtable_data.produto_nome")
        ->orderBy($columnName,$columnSortOrder)
        ->skip($start)
        ->take($rowperpage)
        ->get();


        $data_arr = array();

        $linhatotalnormal = 0;
        $linhatotalaf = 0;
        $linhatotalgeral = 0;
        $linhapercentagemnormal = 0;
        $linhapercentagemaf = 0;
        $calculopercentagemnormal = 0;
        $calculopercentagemaf = 0;

        foreach($records as $record){
            // Transformando o valor retornado em float e aplicando a a formatação decimal.
            $id = $record->id;
            $nomeentidade =  $record->nomeentidade;
            $jannormal = number_format(floatval($record->jannormal), 2, ",", ".");
            $janaf = number_format(floatval($record->janaf), 2, ",", ".");
            $fevnormal = number_format(floatval($record->fevnormal), 2, ",", ".");
            $fevaf = number_format(floatval($record->fevaf), 2, ",", ".");
            $marnormal = number_format(floatval($record->marnormal), 2, ",", ".");
            $maraf = number_format(floatval($record->maraf), 2, ",", ".");
            $abrnormal = number_format(floatval($record->abrnormal), 2, ",", ".");
            $abraf = number_format(floatval($record->abraf), 2, ",", ".");
            $mainormal = number_format(floatval($record->mainormal), 2, ",", ".");
            $maiaf = number_format(floatval($record->maiaf), 2, ",", ".");
            $junnormal = number_format(floatval($record->junnormal), 2, ",", ".");
            $junaf = number_format(floatval($record->junaf), 2, ",", ".");
            $julnormal = number_format(floatval($record->julnormal), 2, ",", ".");
            $julaf = number_format(floatval($record->julaf), 2, ",", ".");
            $agsnormal = number_format(floatval($record->agsnormal), 2, ",", ".");
            $agsaf = number_format(floatval($record->agsaf), 2, ",", ".");
            $setnormal = number_format(floatval($record->setnormal), 2, ",", ".");
            $setaf = number_format(floatval($record->setaf), 2, ",", ".");
            $outnormal = number_format(floatval($record->outnormal), 2, ",", ".");
            $outaf = number_format(floatval($record->outaf), 2, ",", ".");
            $novnormal = number_format(floatval($record->novnormal), 2, ",", ".");
            $novaf = number_format(floatval($record->novaf), 2, ",", ".");
            $deznormal = number_format(floatval($record->deznormal), 2, ",", ".");
            $dezaf = number_format(floatval($record->dezaf), 2, ",", ".");

            //Soma dos valores normal e af de cada (linha)
            $linhatotalnormal = floatval($record->jannormal) + floatval($record->fevnormal) + floatval($record->marnormal) + floatval($record->abrnormal) + floatval($record->mainormal) + floatval($record->junnormal) + floatval($record->julnormal) + floatval($record->agsnormal) + floatval($record->setnormal) + floatval($record->outnormal) + floatval($record->novnormal) + floatval($record->deznormal);
            $linhatotalaf = floatval($record->janaf) + floatval($record->fevaf) + floatval($record->maraf) + floatval($record->abraf) + floatval($record->maiaf) + floatval($record->junaf) + floatval($record->julaf) + floatval($record->agsaf) + floatval($record->setaf) + floatval($record->outaf) + floatval($record->novaf) + floatval($record->dezaf);

            //Soma geral(total normal mais total af) de cada municipio (linha)
            $linhatotalgeral = $linhatotalnormal + $linhatotalaf;

            //Calculando percentagem normal e af de cada municipio (linha)
            //Evitando divisão por zero
            if($linhatotalgeral != 0){
                $calculopercentagemnormal = (($linhatotalnormal * 100)/$linhatotalgeral);
                $calculopercentagemaf = (($linhatotalaf * 100)/$linhatotalgeral);
            }else {
                $calculopercentagemnormal = 0;
                $calculopercentagemaf = 0;
            }



            $totalnormal = number_format($linhatotalnormal, 2, ",",".");
            $totalaf = number_format($linhatotalaf, 2, ",",".");
            $linhatotalgeral = number_format($linhatotalgeral, 2, ",",".");
            $linhapercentagemnormal = number_format($calculopercentagemnormal, 2, ",",".");
            $linhapercentagemaf = number_format($calculopercentagemaf, 2, ",", ".");


            $data_arr[] = array(
                "id"                => $id,
                "nomeentidade"      => $nomeentidade,
                "jannormal"         => $jannormal != '0,00' ? $jannormal : '',
                "janaf"             => $janaf != '0,00' ? $janaf : '',
                "fevnormal"         => $fevnormal != '0,00' ? $fevnormal : '',
                "fevaf"             => $fevaf != '0,00' ? $fevaf : '',
                "marnormal"         => $marnormal != '0,00' ? $marnormal : '',
                "maraf"             => $maraf != '0,00' ? $maraf : '',
                "abrnormal"         => $abrnormal != '0,00' ? $abrnormal : '',
                "abraf"             => $abraf != '0,00' ? $abraf : '',
                "mainormal"         => $mainormal != '0,00' ? $mainormal : '',
                "maiaf"             => $maiaf != '0,00' ? $maiaf : '',
                "junnormal"         => $junnormal != '0,00' ? $junnormal : '',
                "junaf"             => $junaf != '0,00' ? $junaf : '',
                "julnormal"         => $julnormal != '0,00' ? $julnormal : '',
                "julaf"             => $julaf != '0,00' ? $julaf : '',
                "agsnormal"         => $agsnormal != '0,00' ? $agsnormal : '',
                "agsaf"             => $agsaf != '0,00' ? $agsaf : '',
                "setnormal"         => $setnormal != '0,00' ? $setnormal : '',
                "setaf"             => $setaf != '0,00' ? $setaf : '',
                "outnormal"         => $outnormal != '0,00' ? $outnormal : '',
                "outaf"             => $outaf != '0,00' ? $outaf : '',
                "novnormal"         => $novnormal != '0,00' ? $novnormal : '',
                "novaf"             => $novaf != '0,00' ? $novaf : '',
                "deznormal"         => $deznormal != '0,00' ? $deznormal : '',
                "dezaf"             => $dezaf != '0,00' ? $dezaf : '',
                "totalnormal"       => $totalnormal != '0,00' ? $totalnormal : '',
                "totalaf"           => $totalaf != '0,00' ? $totalaf : '',
                "totalgeral"        => $linhatotalgeral != '0,00' ? $linhatotalgeral : '',
                "percentagemnormal" => $linhapercentagemnormal != '0,00' ? $linhapercentagemnormal : '',
                "percentagemaf"     => $linhapercentagemaf != '0,00' ? $linhapercentagemaf : '',

            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        echo json_encode($response);
        exit;
    }




    // Configuração de relatórios PDF's
    public function relpdfmonitorgeral(Request $request)
    {
        $entitRef   = $request->identidade;
        $catRef     = $request->idcategoria;
        $prodRef   = $request->idproduto;
        $anoRef     = $request->idano;


        switch($entitRef){
            case "1":
                $entidade_id = "regional_id";
                $entidade_nome =  "regional_nome";
                $entidaderotulo = "Regionais";
                $titulorelatorio =  "COMPRAS POR REGIONAIS EM ".$anoRef;
            break;
            case "2":
                $entidade_id = "municipio_id";
                $entidade_nome = "municipio_nome";
                $entidaderotulo = "Municípios";
                $titulorelatorio =  "COMPRAS POR MUNICÍPIOS EM ".$anoRef;
            break;
            case "3":
                $entidade_id = "restaurante_id";
                $entidade_nome =  "identificacao";
                $entidaderotulo = "Restaurantes";
                $titulorelatorio =  "COMPRAS POR RESTAURANTES EM ".$anoRef;
            break;
            case "4":
                $entidade_id = "categoria_id";
                $entidade_nome =  "categoria_nome";
                $entidaderotulo = "Categorias";
                $titulorelatorio =  "COMPRAS POR CATEGORIAS EM ".$anoRef;
            break;
            case "5":
                $entidade_id = "produto_id";
                $entidade_nome =  "produto_nome";
                $entidaderotulo = "Produtos";
                $titulorelatorio =  "COMPRAS POR PRODUTOS EM ".$anoRef;
            break;
        }


        // Montando o título do relatório com base na CATEGORIA, se Regional, Município ou Restaurantes forem escolhidos
        if($entitRef == "1" && $catRef != 0 && $prodRef == 0 ){
            $nomeCategoria = DB::table('categorias')->where('id', '=', $catRef)->value('nome');
            $titulorelatorio =  "COMPRA DE ".Str::upper($nomeCategoria)." POR REGIONAIS EM ".$anoRef;
        }
        if($entitRef == "2" && $catRef != 0 && $prodRef == 0 ){
            $nomeCategoria = DB::table('categorias')->where('id', '=', $catRef)->value('nome');
            $titulorelatorio =  "COMPRA DE ".Str::upper($nomeCategoria)." POR MUNICÍPIOS EM ".$anoRef;
        }
        if($entitRef == "3" && $catRef != 0 && $prodRef == 0 ){
            $nomeCategoria = DB::table('categorias')->where('id', '=', $catRef)->value('nome');
            $titulorelatorio =  "COMPRA DE ".Str::upper($nomeCategoria)." POR RESTAURANTES EM ".$anoRef;
        }

        // Montando o título do relatório com base no PRODUTO, se Regional, Município ou Restaurantes forem escolhidos
        if($entitRef == "1" && $catRef != 0 && $prodRef != 0 ){
            $nomeProduto = DB::table('produtos')->where('id', '=', $prodRef)->value('nome');
            $titulorelatorio =  "COMPRA DE ".Str::upper($nomeProduto)." POR REGIONAIS EM ".$anoRef;
        }
        if($entitRef == "2" && $catRef != 0 && $prodRef != 0 ){
            $nomeProduto = DB::table('produtos')->where('id', '=', $prodRef)->value('nome');
            $titulorelatorio =  "COMPRA DE ".Str::upper($nomeProduto)." POR MUNICÍPIOS EM ".$anoRef;
        }
        if($entitRef == "3" && $catRef != 0 && $prodRef != 0 ){
            $nomeProduto = DB::table('produtos')->where('id', '=', $prodRef)->value('nome');
            $titulorelatorio =  "COMPRA DE ".Str::upper($nomeProduto)." POR RESTAURANTES EM ".$anoRef;
        }



        $valoresmeses = DB::table('bigtable_data')
        ->select(DB::RAW("data_ini, af, precototal, $entidade_id, $entidade_nome,
                SUM(IF(MONTH(data_ini) = 01 AND af = 'nao', precototal, 0.00)) AS mesjannormal,
                SUM(IF(MONTH(data_ini) = 01 AND af = 'sim', precototal, 0.00)) AS mesjanaf,
                SUM(IF(MONTH(data_ini) = 02 AND af = 'nao', precototal, 0.00)) AS mesfevnormal,
                SUM(IF(MONTH(data_ini) = 02 AND af = 'sim', precototal, 0.00)) AS mesfevaf,
                SUM(IF(MONTH(data_ini) = 03 AND af = 'nao', precototal, 0.00)) AS mesmarnormal,
                SUM(IF(MONTH(data_ini) = 03 AND af = 'sim', precototal, 0.00)) AS mesmaraf,
                SUM(IF(MONTH(data_ini) = 04 AND af = 'nao', precototal, 0.00)) AS mesabrnormal,
                SUM(IF(MONTH(data_ini) = 04 AND af = 'sim', precototal, 0.00)) AS mesabraf,
                SUM(IF(MONTH(data_ini) = 05 AND af = 'nao', precototal, 0.00)) AS mesmainormal,
                SUM(IF(MONTH(data_ini) = 05 AND af = 'sim', precototal, 0.00)) AS mesmaiaf,
                SUM(IF(MONTH(data_ini) = 06 AND af = 'nao', precototal, 0.00)) AS mesjunnormal,
                SUM(IF(MONTH(data_ini) = 06 AND af = 'sim', precototal, 0.00)) AS mesjunaf,
                SUM(IF(MONTH(data_ini) = 07 AND af = 'nao', precototal, 0.00)) AS mesjulnormal,
                SUM(IF(MONTH(data_ini) = 07 AND af = 'sim', precototal, 0.00)) AS mesjulaf,
                SUM(IF(MONTH(data_ini) = 08 AND af = 'nao', precototal, 0.00)) AS mesagsnormal,
                SUM(IF(MONTH(data_ini) = 08 AND af = 'sim', precototal, 0.00)) AS mesagsaf,
                SUM(IF(MONTH(data_ini) = 09 AND af = 'nao', precototal, 0.00)) AS messetnormal,
                SUM(IF(MONTH(data_ini) = 09 AND af = 'sim', precototal, 0.00)) AS messetaf,
                SUM(IF(MONTH(data_ini) = 10 AND af = 'nao', precototal, 0.00)) AS mesoutnormal,
                SUM(IF(MONTH(data_ini) = 10 AND af = 'sim', precototal, 0.00)) AS mesoutaf,
                SUM(IF(MONTH(data_ini) = 11 AND af = 'nao', precototal, 0.00)) AS mesnovnormal,
                SUM(IF(MONTH(data_ini) = 11 AND af = 'sim', precototal, 0.00)) AS mesnovaf,
                SUM(IF(MONTH(data_ini) = 12 AND af = 'nao', precototal, 0.00)) AS mesdeznormal,
                SUM(IF(MONTH(data_ini) = 12 AND af = 'sim', precototal, 0.00)) AS mesdezaf",

            )
        )
        ->whereYear("data_ini", "=",  $anoRef)
        ->groupByRaw("$entidade_id")
        ->orderByRaw("$entidade_nome");


        //MONTAGEM CONDICIONAL DA QUERYBUILDER COM BASE NO ENVIO DE CATEGORIAS OU PRODUTOS
        if($catRef != 0 && $prodRef == 0){
            $valoresmeses->where("categoria_id", "=", $catRef);
        }
        if($catRef != 0 && $prodRef != 0){
            $valoresmeses->where("produto_id", "=", $prodRef);
        }


        $records =  DB::table("bigtable_data")->joinSub($valoresmeses, "aliasValoresMeses", function($join)  use($entidade_id){
            $join->on("bigtable_data.$entidade_id", "=", "aliasValoresMeses.$entidade_id");
        })->select(DB::raw("bigtable_data.$entidade_id AS id, bigtable_data.$entidade_nome AS nomeentidade, bigtable_data.data_ini,
                        aliasValoresMeses.mesjannormal AS jannormal, aliasValoresMeses.mesjanaf AS janaf, aliasValoresMeses.mesfevnormal AS fevnormal, aliasValoresMeses.mesfevaf AS fevaf, aliasValoresMeses.mesmarnormal AS marnormal, aliasValoresMeses.mesmaraf AS maraf,
                        aliasValoresMeses.mesabrnormal AS abrnormal, aliasValoresMeses.mesabraf AS abraf, aliasValoresMeses.mesmainormal AS mainormal, aliasValoresMeses.mesmaiaf AS maiaf, aliasValoresMeses.mesjunnormal AS junnormal, aliasValoresMeses.mesjunaf AS junaf,
                        aliasValoresMeses.mesjulnormal AS julnormal, aliasValoresMeses.mesjulaf AS julaf, aliasValoresMeses.mesagsnormal AS agsnormal, aliasValoresMeses.mesagsaf AS agsaf, aliasValoresMeses.messetnormal AS setnormal, aliasValoresMeses.messetaf AS setaf,
                        aliasValoresMeses.mesoutnormal AS outnormal, aliasValoresMeses.mesoutaf AS outaf, aliasValoresMeses.mesnovnormal AS novnormal, aliasValoresMeses.mesnovaf AS novaf, aliasValoresMeses.mesdeznormal AS deznormal, aliasValoresMeses.mesdezaf AS dezaf"
                    )
        )
        ->whereYear("bigtable_data.data_ini", "=",  $anoRef)
        ->groupBy("bigtable_data.$entidade_id")
        ->orderBy("bigtable_data.$entidade_nome")
        ->get();

        $fileName = ('RelMonitor.pdf');

        // Invocando a biblioteca mpdf e definindo as margens do arquivo
        $mpdf = new \Mpdf\Mpdf([
            'orientation' => 'L',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 39,
            'margin_bottom' => 10,
            'margin-header' => 10,
            'margin_footer' => 5
        ]);

        // Configurando o cabeçalho da página
        $mpdf->SetHTMLHeader('
            <table style="width:1080px; border-bottom: 1px solid #000000; margin-bottom: 3px;">
                <tr>
                    <td style="width: 108px">
                        <img src="images/logo-ma.png" width="100"/>
                    </td>
                    <td style="width: 432px; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                        Governo do Estado do Maranhão<br>
                        Secretaria de Governo<br>
                        Secreatia Adjunta de Tecnologia da Informação/SEATI<br>
                        Secretaria do Estado de Desenvolvimento Social/SEDES
                    </td>
                    <td style="width: 540px;" class="titulo-rel">'. $titulorelatorio .'</td>
                </tr>
            </table>


            <table style="width:1080px; border-collapse: collapse; border: 0.1px solid #000000;">
                <tr>
                    <td  rowspan="3" class="col-header-table-monitor" style="vertical-align: middle; text-align:center; width: 25px;">Id</td>
                    <td  rowspan="3" class="col-header-table-monitor" style="vertical-align: middle; text-align:center; width: 69px;">'.$entidaderotulo.'</td>
                    <td  colspan="24"  class="col-header-table-monitor" style="vertical-align: middle; text-align:center; width: 816px;">ANO: '.$anoRef.'</td>
                    <td  rowspan="2" class="col-header-table-monitor" colspan="2" style="vertical-align: middle; text-align:center; width: 78px;">TOTAL<br>PARCIAL</td>
                    <td  rowspan="3" class="col-header-table-monitor" style="vertical-align: middle; text-align:center; width: 42px;">TOTAL<br>GERAL<br>(nm + af)</td>
                    <td  rowspan="2" class="col-header-table-monitor" colspan="2" style="vertical-align: middle; text-align:center; width: 50px;">PORCENTO<br>%</td>
                </tr>
                <tr>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">JAN</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">FEV</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">MAR</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">ABR</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">MAI</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">JUN</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">JUL</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">AGS</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">SET</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">OUT</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">NOV</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">DEZ</td>
                </tr>
                <tr>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 39px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 39px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 25px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 25px; text-align:center" class="col-header-table-monitor">af</td>
                </tr>
            </table>
        ');

        $mpdf->SetHTMLFooter('
            <table style="width:1080px; border-top: 1px solid #000000; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                <tr>
                    <td width="360px">São Luis(MA) {DATE d/m/Y}</td>
                    <td width="360px" align="center"></td>
                    <td width="360px" align="right">{PAGENO}/{nbpg}</td>
                </tr>
            </table>
        ');


        $html = \View::make('admin.monitor.pdf.pdfrelatoriomonitorgeral', compact('records'));
        $html = $html->render();

        $stylesheet = file_get_contents('pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }

    /////////// SUB GRUPO
    public function relpdfmonitorgeralsubgrupo(Request $request)
    {
        $entitRef   = $request->identidade;
        $idRegsRef  = $request->idregistro;
        $catRef     = $request->idcategoria;
        $prodRef   = $request->idproduto;
        $anoRef     = $request->idano;


        switch($entitRef){
            // Se for REGIONAL(1), então a entidade a ser pesquisada será municípios pertencentes à regional(idRegRef)
            case "1":
                $entidade_id = "municipio_id";
                $entidade_nome =  "municipio_nome";
                $entidaderotulo = "Municípios";
                $nomeregional = DB::table('regionais')->where('id', '=', $idRegsRef)->value('nome');
                $titulorelatorio =  "Compras por Municípios da Regional: ".$nomeregional." em ".$anoRef;
            break;
            // Se for MUNICÍPIO(2), então a entidade a ser pesquisada será restaurantes pertencentes ao município(idRegRef)
            case "2":
                $entidade_id = "restaurante_id";
                $entidade_nome = "identificacao";
                $entidaderotulo = "Restaurantes";
                $nomemunicipio = DB::table('restaurantes')->where('id', '=', $idRegsRef)->value('identificacao');
                $titulorelatorio =  "Compras por Restaurantes do Muncípio: ".$nomemunicipio." em ".$anoRef;
            break;
            // Se for CATEGORIAS(4), então a entidade a ser pesquisada será produtos pertencentes à categoria(idRegRef)
            case "4":
                $entidade_id = "categoria_id";
                $entidade_nome =  "categoria_nome";
                $entidaderotulo = "Produtos";
                $nomecategoria = DB::table('categorias')->where('id', '=', $idRegsRef)->value('nome');
                $titulorelatorio =  "Compras por produtos da Categoria: ".$nomecategoria." em ".$anoRef;
            break;
        }


        // Montando o título do relatório com base na CATEGORIA, se Regional, Município ou Restaurantes forem escolhidos
        if($entitRef == "1" && $catRef != 0 && $prodRef == 0 ){
            $nomeCategoria = DB::table('categorias')->where('id', '=', $catRef)->value('nome');
            $titulorelatorio =  "COMPRA DE ".Str::upper($nomeCategoria)." POR REGIONAIS EM ".$anoRef;
        }
        if($entitRef == "2" && $catRef != 0 && $prodRef == 0 ){
            $nomeCategoria = DB::table('categorias')->where('id', '=', $catRef)->value('nome');
            $titulorelatorio =  "COMPRA DE ".Str::upper($nomeCategoria)." POR MUNICÍPIOS EM ".$anoRef;
        }
        if($entitRef == "3" && $catRef != 0 && $prodRef == 0 ){
            $nomeCategoria = DB::table('categorias')->where('id', '=', $catRef)->value('nome');
            $titulorelatorio =  "COMPRA DE ".Str::upper($nomeCategoria)." POR RESTAURANTES EM ".$anoRef;
        }

        // Montando o título do relatório com base no PRODUTO, se Regional, Município ou Restaurantes forem escolhidos
        if($entitRef == "1" && $catRef != 0 && $prodRef != 0 ){
            $nomeProduto = DB::table('produtos')->where('id', '=', $prodRef)->value('nome');
            $titulorelatorio =  "COMPRA DE ".Str::upper($nomeProduto)." POR REGIONAIS EM ".$anoRef;
        }
        if($entitRef == "2" && $catRef != 0 && $prodRef != 0 ){
            $nomeProduto = DB::table('produtos')->where('id', '=', $prodRef)->value('nome');
            $titulorelatorio =  "COMPRA DE ".Str::upper($nomeProduto)." POR MUNICÍPIOS EM ".$anoRef;
        }
        if($entitRef == "3" && $catRef != 0 && $prodRef != 0 ){
            $nomeProduto = DB::table('produtos')->where('id', '=', $prodRef)->value('nome');
            $titulorelatorio =  "COMPRA DE ".Str::upper($nomeProduto)." POR RESTAURANTES EM ".$anoRef;
        }



        $valoresmeses = DB::table('bigtable_data')
        ->select(DB::RAW("data_ini, af, precototal, $entidade_id, $entidade_nome,
                SUM(IF(MONTH(data_ini) = 01 AND af = 'nao', precototal, 0.00)) AS mesjannormal,
                SUM(IF(MONTH(data_ini) = 01 AND af = 'sim', precototal, 0.00)) AS mesjanaf,
                SUM(IF(MONTH(data_ini) = 02 AND af = 'nao', precototal, 0.00)) AS mesfevnormal,
                SUM(IF(MONTH(data_ini) = 02 AND af = 'sim', precototal, 0.00)) AS mesfevaf,
                SUM(IF(MONTH(data_ini) = 03 AND af = 'nao', precototal, 0.00)) AS mesmarnormal,
                SUM(IF(MONTH(data_ini) = 03 AND af = 'sim', precototal, 0.00)) AS mesmaraf,
                SUM(IF(MONTH(data_ini) = 04 AND af = 'nao', precototal, 0.00)) AS mesabrnormal,
                SUM(IF(MONTH(data_ini) = 04 AND af = 'sim', precototal, 0.00)) AS mesabraf,
                SUM(IF(MONTH(data_ini) = 05 AND af = 'nao', precototal, 0.00)) AS mesmainormal,
                SUM(IF(MONTH(data_ini) = 05 AND af = 'sim', precototal, 0.00)) AS mesmaiaf,
                SUM(IF(MONTH(data_ini) = 06 AND af = 'nao', precototal, 0.00)) AS mesjunnormal,
                SUM(IF(MONTH(data_ini) = 06 AND af = 'sim', precototal, 0.00)) AS mesjunaf,
                SUM(IF(MONTH(data_ini) = 07 AND af = 'nao', precototal, 0.00)) AS mesjulnormal,
                SUM(IF(MONTH(data_ini) = 07 AND af = 'sim', precototal, 0.00)) AS mesjulaf,
                SUM(IF(MONTH(data_ini) = 08 AND af = 'nao', precototal, 0.00)) AS mesagsnormal,
                SUM(IF(MONTH(data_ini) = 08 AND af = 'sim', precototal, 0.00)) AS mesagsaf,
                SUM(IF(MONTH(data_ini) = 09 AND af = 'nao', precototal, 0.00)) AS messetnormal,
                SUM(IF(MONTH(data_ini) = 09 AND af = 'sim', precototal, 0.00)) AS messetaf,
                SUM(IF(MONTH(data_ini) = 10 AND af = 'nao', precototal, 0.00)) AS mesoutnormal,
                SUM(IF(MONTH(data_ini) = 10 AND af = 'sim', precototal, 0.00)) AS mesoutaf,
                SUM(IF(MONTH(data_ini) = 11 AND af = 'nao', precototal, 0.00)) AS mesnovnormal,
                SUM(IF(MONTH(data_ini) = 11 AND af = 'sim', precototal, 0.00)) AS mesnovaf,
                SUM(IF(MONTH(data_ini) = 12 AND af = 'nao', precototal, 0.00)) AS mesdeznormal,
                SUM(IF(MONTH(data_ini) = 12 AND af = 'sim', precototal, 0.00)) AS mesdezaf",

            )
        )
        ->whereYear("data_ini", "=",  $anoRef)
        ->groupByRaw("$entidade_id")
        ->orderByRaw("$entidade_nome");

        //MONTAGEM CONDICIONAL DA QUERYBUILDER COM BASE NO ENVIO DA ENTIDADE: REGIONAL, MUNICÍPIO OU CATEGORIA
        if($entitRef == "1"){
            $valoresmeses->where("regional_id", "=", $idRegsRef);
        }
        if($entitRef == "2"){
            $valoresmeses->where("municipio_id", "=", $idRegsRef);
        }
        if($entitRef == "4"){
            $valoresmeses->where("categoria_id", "=", $idRegsRef);
        }


        //MONTAGEM CONDICIONAL DA QUERYBUILDER COM BASE NO ENVIO DE CATEGORIAS OU PRODUTOS
        if($catRef != 0 && $prodRef == 0){
            $valoresmeses->where("categoria_id", "=", $catRef);
        }
        if($catRef != 0 && $prodRef != 0){
            $valoresmeses->where("produto_id", "=", $prodRef);
        }


        $records =  DB::table("bigtable_data")->joinSub($valoresmeses, "aliasValoresMeses", function($join)  use($entidade_id){
            $join->on("bigtable_data.$entidade_id", "=", "aliasValoresMeses.$entidade_id");
        })->select(DB::raw("bigtable_data.$entidade_id AS id, bigtable_data.$entidade_nome AS nomeentidade, bigtable_data.data_ini,
                        aliasValoresMeses.mesjannormal AS jannormal, aliasValoresMeses.mesjanaf AS janaf, aliasValoresMeses.mesfevnormal AS fevnormal, aliasValoresMeses.mesfevaf AS fevaf, aliasValoresMeses.mesmarnormal AS marnormal, aliasValoresMeses.mesmaraf AS maraf,
                        aliasValoresMeses.mesabrnormal AS abrnormal, aliasValoresMeses.mesabraf AS abraf, aliasValoresMeses.mesmainormal AS mainormal, aliasValoresMeses.mesmaiaf AS maiaf, aliasValoresMeses.mesjunnormal AS junnormal, aliasValoresMeses.mesjunaf AS junaf,
                        aliasValoresMeses.mesjulnormal AS julnormal, aliasValoresMeses.mesjulaf AS julaf, aliasValoresMeses.mesagsnormal AS agsnormal, aliasValoresMeses.mesagsaf AS agsaf, aliasValoresMeses.messetnormal AS setnormal, aliasValoresMeses.messetaf AS setaf,
                        aliasValoresMeses.mesoutnormal AS outnormal, aliasValoresMeses.mesoutaf AS outaf, aliasValoresMeses.mesnovnormal AS novnormal, aliasValoresMeses.mesnovaf AS novaf, aliasValoresMeses.mesdeznormal AS deznormal, aliasValoresMeses.mesdezaf AS dezaf"
                    )
        )
        ->whereYear("bigtable_data.data_ini", "=",  $anoRef)
        ->groupBy("bigtable_data.$entidade_id")
        ->orderBy("bigtable_data.$entidade_nome")
        ->get();

        $fileName = ('RelMonitor.pdf');

        // Invocando a biblioteca mpdf e definindo as margens do arquivo
        $mpdf = new \Mpdf\Mpdf([
            'orientation' => 'L',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 39,
            'margin_bottom' => 10,
            'margin-header' => 10,
            'margin_footer' => 5
        ]);

        // Configurando o cabeçalho da página
        $mpdf->SetHTMLHeader('
            <table style="width:1080px; border-bottom: 1px solid #000000; margin-bottom: 3px;">
                <tr>
                    <td style="width: 108px">
                        <img src="images/logo-ma.png" width="100"/>
                    </td>
                    <td style="width: 432px; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                        Governo do Estado do Maranhão<br>
                        Secretaria de Governo<br>
                        Secreatia Adjunta de Tecnologia da Informação/SEATI<br>
                        Secretaria do Estado de Desenvolvimento Social/SEDES
                    </td>
                    <td style="width: 540px;" class="titulo-rel">'. $titulorelatorio .'</td>
                </tr>
            </table>


            <table style="width:1080px; border-collapse: collapse; border: 0.1px solid #000000;">
                <tr>
                    <td  rowspan="3" class="col-header-table-monitor" style="vertical-align: middle; text-align:center; width: 25px;">Id</td>
                    <td  rowspan="3" class="col-header-table-monitor" style="vertical-align: middle; text-align:center; width: 69px;">'.$entidaderotulo.'</td>
                    <td  colspan="24"  class="col-header-table-monitor" style="vertical-align: middle; text-align:center; width: 816px;">ANO: '.$anoRef.'</td>
                    <td  rowspan="2" class="col-header-table-monitor" colspan="2" style="vertical-align: middle; text-align:center; width: 78px;">TOTAL<br>PARCIAL</td>
                    <td  rowspan="3" class="col-header-table-monitor" style="vertical-align: middle; text-align:center; width: 42px;">TOTAL<br>GERAL<br>(nm + af)</td>
                    <td  rowspan="2" class="col-header-table-monitor" colspan="2" style="vertical-align: middle; text-align:center; width: 50px;">PORCENTO<br>%</td>
                </tr>
                <tr>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">JAN</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">FEV</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">MAR</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">ABR</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">MAI</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">JUN</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">JUL</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">AGS</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">SET</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">OUT</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">NOV</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">DEZ</td>
                </tr>
                <tr>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 39px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 39px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 25px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 25px; text-align:center" class="col-header-table-monitor">af</td>
                </tr>
            </table>
        ');

        $mpdf->SetHTMLFooter('
            <table style="width:1080px; border-top: 1px solid #000000; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                <tr>
                    <td width="360px">São Luis(MA) {DATE d/m/Y}</td>
                    <td width="360px" align="center"></td>
                    <td width="360px" align="right">{PAGENO}/{nbpg}</td>
                </tr>
            </table>
        ');


        $html = \View::make('admin.monitor.pdf.pdfrelatoriomonitorgeralsubgrupo', compact('records'));
        $html = $html->render();

        $stylesheet = file_get_contents('pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }
    /////////// SUB GRUPO


    public function relpdfmonitorespecifico(Request $request)
    {
        $entitRef   = $request->identidade;
        $idregRef   = $request->idregistro;
        $idtipoRef  = $request->idtipopesquisa;
        $anoRef     = $request->idano;


        switch($entitRef){
            case "1":
                $entidade_id = "regional_id";
                $rotuloentidade = "REGIONAL: ";
                $rotuloregistro = DB::table('regionais')->where('id', '=', $idregRef)->value('nome');
            break;
            case "2":
                $entidade_id = "municipio_id";
                $rotuloentidade = "MUNICÍPIO: ";
                $rotuloregistro = DB::table('municipios')->where('id', '=', $idregRef)->value('nome');
            break;
            case "3":
                $entidade_id = "restaurante_id";
                $rotuloentidade = "RESTAURANTE: ";
                $rotuloregistro = DB::table('restaurantes')->where('id', '=', $idregRef)->value('identificacao');
            break;
        }

        // Define por qual campo pesquisar
        if($idtipoRef == "1"){
            $campo_id = "categoria_id";
            $campo_nome = "categoria_nome";
            $rotulopesquisa =  "Categorias";
            $titulorelatorio =  "COMPRAS POR CATEGORIAS - ". $rotuloentidade . $rotuloregistro ." EM ".$anoRef;
        }else{
            $campo_id = "produto_id";
            $campo_nome = "produto_nome";
            $rotulopesquisa =  "Produtos";
            $titulorelatorio =  "COMPRAS POR PRODUTOS - ". $rotuloentidade . $rotuloregistro ." EM ".$anoRef;
        }


        $valoresmeses = DB::table('bigtable_data')
        ->select(DB::RAW("data_ini, af, precototal, $campo_id, $campo_nome,
                SUM(IF(MONTH(data_ini) = 01 AND af = 'nao', precototal, 0.00)) AS mesjannormal,
                SUM(IF(MONTH(data_ini) = 01 AND af = 'sim', precototal, 0.00)) AS mesjanaf,
                SUM(IF(MONTH(data_ini) = 02 AND af = 'nao', precototal, 0.00)) AS mesfevnormal,
                SUM(IF(MONTH(data_ini) = 02 AND af = 'sim', precototal, 0.00)) AS mesfevaf,
                SUM(IF(MONTH(data_ini) = 03 AND af = 'nao', precototal, 0.00)) AS mesmarnormal,
                SUM(IF(MONTH(data_ini) = 03 AND af = 'sim', precototal, 0.00)) AS mesmaraf,
                SUM(IF(MONTH(data_ini) = 04 AND af = 'nao', precototal, 0.00)) AS mesabrnormal,
                SUM(IF(MONTH(data_ini) = 04 AND af = 'sim', precototal, 0.00)) AS mesabraf,
                SUM(IF(MONTH(data_ini) = 05 AND af = 'nao', precototal, 0.00)) AS mesmainormal,
                SUM(IF(MONTH(data_ini) = 05 AND af = 'sim', precototal, 0.00)) AS mesmaiaf,
                SUM(IF(MONTH(data_ini) = 06 AND af = 'nao', precototal, 0.00)) AS mesjunnormal,
                SUM(IF(MONTH(data_ini) = 06 AND af = 'sim', precototal, 0.00)) AS mesjunaf,
                SUM(IF(MONTH(data_ini) = 07 AND af = 'nao', precototal, 0.00)) AS mesjulnormal,
                SUM(IF(MONTH(data_ini) = 07 AND af = 'sim', precototal, 0.00)) AS mesjulaf,
                SUM(IF(MONTH(data_ini) = 08 AND af = 'nao', precototal, 0.00)) AS mesagsnormal,
                SUM(IF(MONTH(data_ini) = 08 AND af = 'sim', precototal, 0.00)) AS mesagsaf,
                SUM(IF(MONTH(data_ini) = 09 AND af = 'nao', precototal, 0.00)) AS messetnormal,
                SUM(IF(MONTH(data_ini) = 09 AND af = 'sim', precototal, 0.00)) AS messetaf,
                SUM(IF(MONTH(data_ini) = 10 AND af = 'nao', precototal, 0.00)) AS mesoutnormal,
                SUM(IF(MONTH(data_ini) = 10 AND af = 'sim', precototal, 0.00)) AS mesoutaf,
                SUM(IF(MONTH(data_ini) = 11 AND af = 'nao', precototal, 0.00)) AS mesnovnormal,
                SUM(IF(MONTH(data_ini) = 11 AND af = 'sim', precototal, 0.00)) AS mesnovaf,
                SUM(IF(MONTH(data_ini) = 12 AND af = 'nao', precototal, 0.00)) AS mesdeznormal,
                SUM(IF(MONTH(data_ini) = 12 AND af = 'sim', precototal, 0.00)) AS mesdezaf",

            )
        )
        ->whereYear("data_ini", "=",  $anoRef)
        ->where("$entidade_id", "=", $idregRef)
        ->groupByRaw("$campo_id")
        ->orderByRaw("$campo_nome");

        $records =  DB::table("bigtable_data")->joinSub($valoresmeses, "aliasValoresMeses", function($join)  use($campo_id){
            $join->on("bigtable_data.$campo_id", "=", "aliasValoresMeses.$campo_id");
        })->select(DB::raw("bigtable_data.$campo_id AS id, bigtable_data.$campo_nome AS nomeentidade, bigtable_data.data_ini,
                        aliasValoresMeses.mesjannormal AS jannormal, aliasValoresMeses.mesjanaf AS janaf, aliasValoresMeses.mesfevnormal AS fevnormal, aliasValoresMeses.mesfevaf AS fevaf, aliasValoresMeses.mesmarnormal AS marnormal, aliasValoresMeses.mesmaraf AS maraf,
                        aliasValoresMeses.mesabrnormal AS abrnormal, aliasValoresMeses.mesabraf AS abraf, aliasValoresMeses.mesmainormal AS mainormal, aliasValoresMeses.mesmaiaf AS maiaf, aliasValoresMeses.mesjunnormal AS junnormal, aliasValoresMeses.mesjunaf AS junaf,
                        aliasValoresMeses.mesjulnormal AS julnormal, aliasValoresMeses.mesjulaf AS julaf, aliasValoresMeses.mesagsnormal AS agsnormal, aliasValoresMeses.mesagsaf AS agsaf, aliasValoresMeses.messetnormal AS setnormal, aliasValoresMeses.messetaf AS setaf,
                        aliasValoresMeses.mesoutnormal AS outnormal, aliasValoresMeses.mesoutaf AS outaf, aliasValoresMeses.mesnovnormal AS novnormal, aliasValoresMeses.mesnovaf AS novaf, aliasValoresMeses.mesdeznormal AS deznormal, aliasValoresMeses.mesdezaf AS dezaf"
                    )
        )
        ->whereYear("bigtable_data.data_ini", "=",  $anoRef)
        ->groupBy("bigtable_data.$campo_id")
        ->orderBy("bigtable_data.$campo_nome")
        ->get();

        $fileName = ('RelMonitor.pdf');

        // Invocando a biblioteca mpdf e definindo as margens do arquivo
        $mpdf = new \Mpdf\Mpdf([
            'orientation' => 'L',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 39,
            'margin_bottom' => 10,
            'margin-header' => 10,
            'margin_footer' => 5
        ]);

        // Configurando o cabeçalho da página
        $mpdf->SetHTMLHeader('
            <table style="width:1080px; border-bottom: 1px solid #000000; margin-bottom: 3px;">
                <tr>
                    <td style="width: 108px">
                        <img src="images/logo-ma.png" width="100"/>
                    </td>
                    <td style="width: 432px; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                        Governo do Estado do Maranhão<br>
                        Secretaria de Governo<br>
                        Secreatia Adjunta de Tecnologia da Informação/SEATI<br>
                        Secretaria do Estado de Desenvolvimento Social/SEDES
                    </td>
                    <td style="width: 540px;" class="titulo-rel">'. $titulorelatorio .'</td>
                </tr>
            </table>


            <table style="width:1080px; border-collapse: collapse; border: 0.1px solid #000000;">
                <tr>
                    <td  rowspan="3" class="col-header-table-monitor" style="vertical-align: middle; text-align:center; width: 25px;">Id</td>
                    <td  rowspan="3" class="col-header-table-monitor" style="vertical-align: middle; text-align:center; width: 69px;">'.$rotulopesquisa.'</td>
                    <td  colspan="24"  class="col-header-table-monitor" style="vertical-align: middle; text-align:center; width: 816px;">ANO: '.$anoRef.'</td>
                    <td  rowspan="2" class="col-header-table-monitor" colspan="2" style="vertical-align: middle; text-align:center; width: 78px;">TOTAL<br>PARCIAL</td>
                    <td  rowspan="3" class="col-header-table-monitor" style="vertical-align: middle; text-align:center; width: 42px;">TOTAL<br>GERAL<br>(nm + af)</td>
                    <td  rowspan="2" class="col-header-table-monitor" colspan="2" style="vertical-align: middle; text-align:center; width: 50px;">PORCENTO<br>%</td>
                </tr>
                <tr>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">JAN</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">FEV</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">MAR</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">ABR</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">MAI</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">JUN</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">JUL</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">AGS</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">SET</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">OUT</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">NOV</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">DEZ</td>
                </tr>
                <tr>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 39px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 39px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 25px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 25px; text-align:center" class="col-header-table-monitor">af</td>
                </tr>
            </table>
        ');

        $mpdf->SetHTMLFooter('
            <table style="width:1080px; border-top: 1px solid #000000; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                <tr>
                    <td width="360px">São Luis(MA) {DATE d/m/Y}</td>
                    <td width="360px" align="center"></td>
                    <td width="360px" align="right">{PAGENO}/{nbpg}</td>
                </tr>
            </table>
        ');


        $html = \View::make('admin.monitor.pdf.pdfrelatoriomonitorespecifico', compact('records'));
        $html = $html->render();

        $stylesheet = file_get_contents('pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }




    public function relpdfmonitorgeralprimeirosemestre(Request $request)
    {
        $entitRef   = $request->identidade;
        $catRef     = $request->idcategoria;
        $prodRef   = $request->idproduto;
        $anoRef     = $request->idano;

        switch($entitRef){
            case "1":
                $entidade_id = "regional_id";
                $entidade_nome =  "regional_nome";
                $entidaderotulo = "Regionais";
                $titulorelatorio =  "COMPRAS POR REGIONAIS EM ".$anoRef." (1º semestre)";
            break;
            case "2":
                $entidade_id = "municipio_id";
                $entidade_nome = "municipio_nome";
                $entidaderotulo = "Municípios";
                $titulorelatorio =  "COMPRAS POR MUNICÍPIOS EM ".$anoRef." (1º semestre)";
            break;
            case "3":
                $entidade_id = "restaurante_id";
                $entidade_nome =  "identificacao";
                $entidaderotulo = "Restaurantes";
                $titulorelatorio =  "COMPRAS POR RESTAURANTES EM ".$anoRef." (1º semestre)";
            break;
            case "4":
                $entidade_id = "categoria_id";
                $entidade_nome =  "categoria_nome";
                $entidaderotulo = "Categorias";
                $titulorelatorio =  "COMPRAS POR CATEGORIAS EM ".$anoRef." (1º semestre)";
            break;
            case "5":
                $entidade_id = "produto_id";
                $entidade_nome =  "produto_nome";
                $entidaderotulo = "Produtos";
                $titulorelatorio =  "COMPRAS POR PRODUTOS EM ".$anoRef." (1º semestre)";
            break;
        }


        // Montando o título do relatório com base na CATEGORIA, se Regional, Município ou Restaurantes forem escolhidos
        if($entitRef == "1" && $catRef != 0 && $prodRef == 0 ){
            $nomeCategoria = DB::table('categorias')->where('id', '=', $catRef)->value('nome');
            $titulorelatorio =  "COMPRA DE ".Str::upper($nomeCategoria)." POR REGIONAIS EM ".$anoRef;
        }
        if($entitRef == "2" && $catRef != 0 && $prodRef == 0 ){
            $nomeCategoria = DB::table('categorias')->where('id', '=', $catRef)->value('nome');
            $titulorelatorio =  "COMPRA DE ".Str::upper($nomeCategoria)." POR MUNICÍPIOS EM ".$anoRef;
        }
        if($entitRef == "3" && $catRef != 0 && $prodRef == 0 ){
            $nomeCategoria = DB::table('categorias')->where('id', '=', $catRef)->value('nome');
            $titulorelatorio =  "COMPRA DE ".Str::upper($nomeCategoria)." POR RESTAURANTES EM ".$anoRef;
        }

        // Montando o título do relatório com base no PRODUTO, se Regional, Município ou Restaurantes forem escolhidos
        if($entitRef == "1" && $catRef != 0 && $prodRef != 0 ){
            $nomeProduto = DB::table('produtos')->where('id', '=', $prodRef)->value('nome');
            $titulorelatorio =  "COMPRA DE ".Str::upper($nomeProduto)." POR REGIONAIS EM ".$anoRef;
        }
        if($entitRef == "2" && $catRef != 0 && $prodRef != 0 ){
            $nomeProduto = DB::table('produtos')->where('id', '=', $prodRef)->value('nome');
            $titulorelatorio =  "COMPRA DE ".Str::upper($nomeProduto)." POR MUNICÍPIOS EM ".$anoRef;
        }
        if($entitRef == "3" && $catRef != 0 && $prodRef != 0 ){
            $nomeProduto = DB::table('produtos')->where('id', '=', $prodRef)->value('nome');
            $titulorelatorio =  "COMPRA DE ".Str::upper($nomeProduto)." POR RESTAURANTES EM ".$anoRef;
        }



        $valoresmeses = DB::table('bigtable_data')
        ->select(DB::RAW("data_ini, af, precototal, $entidade_id, $entidade_nome,
                SUM(IF(MONTH(data_ini) = 01 AND af = 'nao', precototal, 0.00)) AS mesjannormal,
                SUM(IF(MONTH(data_ini) = 01 AND af = 'sim', precototal, 0.00)) AS mesjanaf,
                SUM(IF(MONTH(data_ini) = 02 AND af = 'nao', precototal, 0.00)) AS mesfevnormal,
                SUM(IF(MONTH(data_ini) = 02 AND af = 'sim', precototal, 0.00)) AS mesfevaf,
                SUM(IF(MONTH(data_ini) = 03 AND af = 'nao', precototal, 0.00)) AS mesmarnormal,
                SUM(IF(MONTH(data_ini) = 03 AND af = 'sim', precototal, 0.00)) AS mesmaraf,
                SUM(IF(MONTH(data_ini) = 04 AND af = 'nao', precototal, 0.00)) AS mesabrnormal,
                SUM(IF(MONTH(data_ini) = 04 AND af = 'sim', precototal, 0.00)) AS mesabraf,
                SUM(IF(MONTH(data_ini) = 05 AND af = 'nao', precototal, 0.00)) AS mesmainormal,
                SUM(IF(MONTH(data_ini) = 05 AND af = 'sim', precototal, 0.00)) AS mesmaiaf,
                SUM(IF(MONTH(data_ini) = 06 AND af = 'nao', precototal, 0.00)) AS mesjunnormal,
                SUM(IF(MONTH(data_ini) = 06 AND af = 'sim', precototal, 0.00)) AS mesjunaf,
                SUM(IF(MONTH(data_ini) = 07 AND af = 'nao', precototal, 0.00)) AS mesjulnormal,
                SUM(IF(MONTH(data_ini) = 07 AND af = 'sim', precototal, 0.00)) AS mesjulaf,
                SUM(IF(MONTH(data_ini) = 08 AND af = 'nao', precototal, 0.00)) AS mesagsnormal,
                SUM(IF(MONTH(data_ini) = 08 AND af = 'sim', precototal, 0.00)) AS mesagsaf,
                SUM(IF(MONTH(data_ini) = 09 AND af = 'nao', precototal, 0.00)) AS messetnormal,
                SUM(IF(MONTH(data_ini) = 09 AND af = 'sim', precototal, 0.00)) AS messetaf,
                SUM(IF(MONTH(data_ini) = 10 AND af = 'nao', precototal, 0.00)) AS mesoutnormal,
                SUM(IF(MONTH(data_ini) = 10 AND af = 'sim', precototal, 0.00)) AS mesoutaf,
                SUM(IF(MONTH(data_ini) = 11 AND af = 'nao', precototal, 0.00)) AS mesnovnormal,
                SUM(IF(MONTH(data_ini) = 11 AND af = 'sim', precototal, 0.00)) AS mesnovaf,
                SUM(IF(MONTH(data_ini) = 12 AND af = 'nao', precototal, 0.00)) AS mesdeznormal,
                SUM(IF(MONTH(data_ini) = 12 AND af = 'sim', precototal, 0.00)) AS mesdezaf",

            )
        )
        ->whereYear("data_ini", "=",  $anoRef)
        ->groupByRaw("$entidade_id")
        ->orderByRaw("$entidade_nome");


        //MONTAGEM CONDICIONAL DA QUERYBUILDER COM BASE NO ENVIO DE CATEGORIAS OU PRODUTOS
        if($catRef != 0 && $prodRef == 0){
            $valoresmeses->where("categoria_id", "=", $catRef);
        }
        if($catRef != 0 && $prodRef != 0){
            $valoresmeses->where("produto_id", "=", $prodRef);
        }


        $records =  DB::table("bigtable_data")->joinSub($valoresmeses, "aliasValoresMeses", function($join)  use($entidade_id){
            $join->on("bigtable_data.$entidade_id", "=", "aliasValoresMeses.$entidade_id");
        })->select(DB::raw("bigtable_data.$entidade_id AS id, bigtable_data.$entidade_nome AS nomeentidade, bigtable_data.data_ini,
                        aliasValoresMeses.mesjannormal AS jannormal, aliasValoresMeses.mesjanaf AS janaf, aliasValoresMeses.mesfevnormal AS fevnormal, aliasValoresMeses.mesfevaf AS fevaf, aliasValoresMeses.mesmarnormal AS marnormal, aliasValoresMeses.mesmaraf AS maraf,
                        aliasValoresMeses.mesabrnormal AS abrnormal, aliasValoresMeses.mesabraf AS abraf, aliasValoresMeses.mesmainormal AS mainormal, aliasValoresMeses.mesmaiaf AS maiaf, aliasValoresMeses.mesjunnormal AS junnormal, aliasValoresMeses.mesjunaf AS junaf,
                        aliasValoresMeses.mesjulnormal AS julnormal, aliasValoresMeses.mesjulaf AS julaf, aliasValoresMeses.mesagsnormal AS agsnormal, aliasValoresMeses.mesagsaf AS agsaf, aliasValoresMeses.messetnormal AS setnormal, aliasValoresMeses.messetaf AS setaf,
                        aliasValoresMeses.mesoutnormal AS outnormal, aliasValoresMeses.mesoutaf AS outaf, aliasValoresMeses.mesnovnormal AS novnormal, aliasValoresMeses.mesnovaf AS novaf, aliasValoresMeses.mesdeznormal AS deznormal, aliasValoresMeses.mesdezaf AS dezaf"
                    )
        )
        ->whereYear("bigtable_data.data_ini", "=",  $anoRef)
        ->groupBy("bigtable_data.$entidade_id")
        ->orderBy("bigtable_data.$entidade_nome")
        ->get();

        $fileName = ('RelMonitorSemestreUm.pdf');

        // Invocando a biblioteca mpdf e definindo as margens do arquivo
        $mpdf = new \Mpdf\Mpdf([
            'orientation' => 'L',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 39,
            'margin_bottom' => 10,
            'margin-header' => 10,
            'margin_footer' => 5
        ]);

        // Configurando o cabeçalho da página
        $mpdf->SetHTMLHeader('
            <table style="width:1080px; border-bottom: 1px solid #000000; margin-bottom: 3px;">
                <tr>
                    <td style="width: 108px">
                        <img src="images/logo-ma.png" width="100"/>
                    </td>
                    <td style="width: 432px; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                        Governo do Estado do Maranhão<br>
                        Secretaria de Governo<br>
                        Secreatia Adjunta de Tecnologia da Informação/SEATI<br>
                        Secretaria do Estado de Desenvolvimento Social/SEDES
                    </td>
                    <td style="width: 540px;" class="titulo-rel">'. $titulorelatorio .'</td>
                </tr>
            </table>


            <table style="width:1080px; border-collapse: collapse; border: 0.1px solid #000000;">
                <tr>
                    <td  rowspan="3" class="col-header-table-monitor" style="vertical-align: middle; text-align:center; width: 25px;">Id</td>
                    <td  rowspan="3" class="col-header-table-monitor" style="vertical-align: middle; text-align:center; width: 69px;">'.$entidaderotulo.'</td>
                    <td  colspan="24"  class="col-header-table-monitor" style="vertical-align: middle; text-align:center; width: 816px;">ANO: '.$anoRef.'</td>
                    <td  rowspan="2" class="col-header-table-monitor" colspan="2" style="vertical-align: middle; text-align:center; width: 78px;">TOTAL<br>PARCIAL</td>
                    <td  rowspan="3" class="col-header-table-monitor" style="vertical-align: middle; text-align:center; width: 42px;">TOTAL<br>GERAL<br>(nm + af)</td>
                    <td  rowspan="2" class="col-header-table-monitor" colspan="2" style="vertical-align: middle; text-align:center; width: 50px;">PORCENTO<br>%</td>
                </tr>
                <tr>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">JAN</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">FEV</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">MAR</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">ABR</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">MAI</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">JUN</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">JUL</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">AGS</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">SET</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">OUT</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">NOV</td>
                    <td style="width: 68px;" colspan="2" class="col-header-table-monitor" style="text-align:center">DEZ</td>
                </tr>
                <tr>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 34px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 39px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 39px; text-align:center" class="col-header-table-monitor">af</td>
                    <td style="width: 25px; text-align:center" class="col-header-table-monitor">nm</td>
                    <td style="width: 25px; text-align:center" class="col-header-table-monitor">af</td>
                </tr>
            </table>
        ');

        $mpdf->SetHTMLFooter('
            <table style="width:1080px; border-top: 1px solid #000000; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                <tr>
                    <td width="360px">São Luis(MA) {DATE d/m/Y}</td>
                    <td width="360px" align="center"></td>
                    <td width="360px" align="right">{PAGENO}/{nbpg}</td>
                </tr>
            </table>
        ');


        $html = \View::make('admin.monitor.pdf.pdfrelatoriomonitorgeralprimeirosemestre', compact('records'));
        $html = $html->render();

        $stylesheet = file_get_contents('pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }


}
