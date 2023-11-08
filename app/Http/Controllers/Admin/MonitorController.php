<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurante;
use App\Models\Regional;
use App\Models\Monitor;
use Cron\MonthField;
use Illuminate\Support\Facades\DB;

class MonitorController extends Controller
{
    public function __construct()
    {
        // O usuário logado deve está autenticado e possui autorização para executar os métodos deste controle
        $this->middleware(['auth', 'can:adm']);
    }


    public function index()
    {
        //$restaurantes = Restaurante::orderBy('identificacao', 'ASC')->get();
        //return view('admin.monitor.index', compact('restaurantes'));
        
        return view('admin.monitor.index');
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

}
