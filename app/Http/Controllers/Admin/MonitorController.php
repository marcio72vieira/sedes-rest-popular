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
        $restaurantes = Restaurante::orderBy('identificacao', 'ASC')->get();

        return view('admin.monitor.index', compact('restaurantes'));
    }

    public function ajaxgetMonitorRestaurantes(Request $request){

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



        // Total records.
        // Obs: Como serão realizadas pesquisas apenas nos campos "identificacao e municipio" penso que não há a necessidade
        //      de utilizarmos os joins: ->join('users', ....) e  ->join('nutricionistas', ...) mas, em todo caso...!!!,
        $totalRecords = Restaurante::select('count(*) as allcount')->count();
        $totalRecordswithFilter = DB::table('restaurantes')
            ->join('municipios', 'municipios.id', '=', 'restaurantes.municipio_id')
            ->join('regionais', 'regionais.id', '=', 'municipios.regional_id')
            ->join('users', 'users.id', '=', 'restaurantes.user_id')
            ->join('nutricionistas', 'nutricionistas.id', '=', 'restaurantes.nutricionista_id')
            ->select('count(*) as allcount')
            ->where('restaurantes.identificacao', 'like', '%' .$searchValue . '%')
            ->orWhere('municipios.nome', 'like', '%' . $searchValue . '%' )
            ->orWhere('regionais.nome', 'like', '%' .$searchValue . '%')
            ->count();

        // Fetch records (restaurantes)
        $restaurantes = DB::table('restaurantes')
        ->join('municipios', 'municipios.id', '=', 'restaurantes.municipio_id')
        ->join('regionais', 'regionais.id', '=', 'municipios.regional_id')
        ->join('users', 'users.id', '=', 'restaurantes.user_id')
        ->join('nutricionistas', 'nutricionistas.id', '=', 'restaurantes.nutricionista_id')
        ->select('restaurantes.id', 'restaurantes.identificacao', 'restaurantes.ativo',
                 'municipios.nome AS municipio', 'regionais.nome AS regional',
                 'users.nomecompleto AS nomeusersedes', 'users.email AS emailusersedes', 'users.telefone AS telefoneusersedes',
                 'nutricionistas.nomecompleto AS nomenutricionista', 'nutricionistas.email AS emailnutricionista', 'nutricionistas.telefone AS telefonenutricionista')
        ->where('restaurantes.identificacao', 'like', '%' .$searchValue . '%')
        ->orWhere('municipios.nome', 'like', '%' .$searchValue . '%')
        ->orWhere('regionais.nome', 'like', '%' .$searchValue . '%')
        ->orderBy($columnName,$columnSortOrder)
        ->skip($start)
        ->take($rowperpage)
        ->get();


        $data_arr = array();

        foreach($restaurantes as $restaurante){
            // campos a serem exibidos
            $id = $restaurante->id;
            $regional =  $restaurante->regional;
            $municipio = $restaurante->municipio;
            $identificacao = $restaurante->identificacao;

            $data_arr[] = array(
                "id" => $id,
                "regional" => $regional,
                "municipio" => $municipio,
                "identificacao" => $identificacao,
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

        $totalRecords = DB::table("bigtable_data")->select('regional_id')->distinct('regional_id')->count();

        $totalRecordswithFilter = DB::table("bigtable_data")
            ->select(DB::RAW('regional_id AS id, regional_nome AS regional'))
            ->distinct('regional_id')
            ->where('regional_nome', 'like', '%' .$searchValue . '%')
            ->count();


            /*
            QUERY COM RESULTADO SIMPLES (Só o id e o nome das regionais sem categorização mês a mês)
            $regionais = DB::table("bigtable_data")
            ->select(DB::RAW('regional_id AS id, regional_nome AS regional'))
            ->groupBy('regional_id')
            ->orderBy($columnName,$columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();
            */

            $ano = 2023;
            $records = DB::select(DB::raw("
                SELECT
                    regional_id AS id, regional_nome AS regional,
                    SUM(mesjannormal) AS jannormal, SUM(mesjanaf) AS janaf, SUM(mesfevnormal) AS fevnormal, SUM(mesfevaf) AS fevaf, SUM(mesmarnormal) AS marnormal, SUM(mesmaraf) AS maraf,
                    SUM(mesabrnormal) AS abrnormal, SUM(mesabraf) AS abraf, SUM(mesmainormal) AS mainormal, SUM(mesmaiaf) AS maiaf, SUM(mesjunnormal) AS junnormal, SUM(mesjunaf) AS junaf,
                    SUM(mesjulnormal) AS julnormal, SUM(mesjulaf) AS julaf, SUM(mesagsnormal) AS agsnormal, SUM(mesagsaf) AS agsaf, SUM(messetnormal) AS setnormal, SUM(messetaf) AS setaf,
                    SUM(mesoutnormal) AS outnormal, SUM(mesoutaf) AS outaf, SUM(mesnovnormal) AS novnormal, SUM(mesnovaf) AS novaf, SUM(mesdeznormal) AS deznormal, SUM(mesdezaf) AS dezaf
                FROM
                    (SELECT
                        data_ini, af, precototal, regional_id, regional_nome,
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
                        SUM(IF(MONTH(data_ini) = 12 AND af = 'sim', precototal, 0.00)) AS mesdezaf
                    FROM
                        bigtable_data
                        WHERE YEAR(data_ini) = $ano
                        GROUP BY regional_id, MONTH(data_ini)
                        ORDER BY regional_nome ) AS valoresmeses
                WHERE YEAR(data_ini) = $ano
                GROUP BY regional_id"));

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
            $regional =  $record->regional;
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
            $calculopercentagemnormal = (($linhatotalnormal * 100)/$linhatotalgeral);
            $calculopercentagemaf = (($linhatotalaf * 100)/$linhatotalgeral);



            $totalnormal = number_format($linhatotalnormal, 2, ",",".");
            $totalaf = number_format($linhatotalaf, 2, ",",".");
            $linhatotalgeral = number_format($linhatotalgeral, 2, ",",".");
            $linhapercentagemnormal = number_format($calculopercentagemnormal, 2, ",",".");
            $linhapercentagemaf = number_format($calculopercentagemaf, 2, ",", ".");


            $data_arr[] = array(
                "id"                => $id,
                "regional"          => $regional,
                "jannormal"         => $jannormal != 0 ? $jannormal : '',
                "janaf"             => $janaf != 0 ? $janaf : '',
                "fevnormal"         => $fevnormal != 0 ? $fevnormal : '',
                "fevaf"             => $fevaf != 0 ? $fevaf : '',
                "marnormal"         => $marnormal != 0 ? $marnormal : '',
                "maraf"             => $maraf != 0 ? $maraf : '',
                "abrnormal"         => $abrnormal != 0 ? $abrnormal : '',
                "abraf"             => $abraf != 0 ? $abraf : '',
                "mainormal"         => $mainormal != 0 ? $mainormal : '',
                "maiaf"             => $maiaf != 0 ? $maiaf : '',
                "junnormal"         => $junnormal != 0 ? $junnormal : '',
                "junaf"             => $junaf != 0 ? $junaf : '',
                "julnormal"         => $julnormal != 0 ? $julnormal : '',
                "julaf"             => $julaf != 0 ? $julaf : '',
                "agsnormal"         => $agsnormal != 0 ? $agsnormal : '',
                "agsaf"             => $agsaf != 0 ? $agsaf : '',
                "setnormal"         => $setnormal != 0 ? $setnormal : '',
                "setaf"             => $setaf != 0 ? $setaf : '',
                "outnormal"         => $outnormal != 0 ? $outnormal : '',
                "outaf"             => $outaf != 0 ? $outaf : '',
                "novnormal"         => $novnormal != 0 ? $novnormal : '',
                "novaf"             => $novaf != 0 ? $novaf : '',
                "deznormal"         => $deznormal != 0 ? $deznormal : '',
                "dezaf"             => $dezaf != 0 ? $dezaf : '',

                "totalnormal"       => $totalnormal != 0 ? $totalnormal : '',
                "totalaf"           => $totalaf != 0 ? $totalaf : '',
                "totalgeral"        => $linhatotalgeral != 0 ? $linhatotalgeral : '',
                "percentagemnormal" => $linhapercentagemnormal != 0 ? $linhapercentagemnormal : '',
                "percentagemaf"     => $linhapercentagemaf != 0 ? $linhapercentagemaf : '',
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
