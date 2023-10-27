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

            $regionais = DB::select(DB::raw("regional_id, regional_nome, SUM(jannormal), SUM(janaf), SUM(fevnormal), SUM(fevaf), SUM(marnormal), SUM(maraf), SUM(abrnormal), SUM(abraf), SUM(mainormal), SUM(maiaf), SUM(junnormal), SUM(junaf), SUM(julnormal), SUM(julaf), SUM(agsnormal), SUM(agsaf), SUM(setnormal), SUM(setaf), SUM(outnormal), SUM(outaf), SUM(novnormal), SUM(novaf), SUM(deznormal), SUM(dezaf) FROM (SELECT data_ini, af, precototal, regional_id, regional_nome, SUM(IF(MONTH(data_ini) = 01 AND af = 'nao', precototal, 0.00)) AS jannormal, SUM(IF(MONTH(data_ini) = 01 AND af = 'sim', precototal, 0.00)) AS janaf, SUM(IF(MONTH(data_ini) = 02 AND af = 'nao', precototal, 0.00)) AS fevnormal, SUM(IF(MONTH(data_ini) = 02 AND af = 'sim', precototal, 0.00)) AS fevaf, SUM(IF(MONTH(data_ini) = 03 AND af = 'nao', precototal, 0.00)) AS marnormal, SUM(IF(MONTH(data_ini) = 03 AND af = 'sim', precototal, 0.00)) AS maraf, SUM(IF(MONTH(data_ini) = 04 AND af = 'nao', precototal, 0.00)) AS abrnormal, SUM(IF(MONTH(data_ini) = 04 AND af = 'sim', precototal, 0.00)) AS abraf, SUM(IF(MONTH(data_ini) = 05 AND af = 'nao', precototal, 0.00)) AS mainormal, SUM(IF(MONTH(data_ini) = 05 AND af = 'sim', precototal, 0.00)) AS maiaf, SUM(IF(MONTH(data_ini) = 06 AND af = 'nao', precototal, 0.00)) AS junnormal, SUM(IF(MONTH(data_ini) = 06 AND af = 'sim', precototal, 0.00)) AS junaf, SUM(IF(MONTH(data_ini) = 07 AND af = 'nao', precototal, 0.00)) AS julnormal, SUM(IF(MONTH(data_ini) = 07 AND af = 'sim', precototal, 0.00)) AS julaf, SUM(IF(MONTH(data_ini) = 08 AND af = 'nao', precototal, 0.00)) AS agsnormal, SUM(IF(MONTH(data_ini) = 08 AND af = 'sim', precototal, 0.00)) AS agsaf, SUM(IF(MONTH(data_ini) = 09 AND af = 'nao', precototal, 0.00)) AS setnormal, SUM(IF(MONTH(data_ini) = 09 AND af = 'sim', precototal, 0.00)) AS setaf, SUM(IF(MONTH(data_ini) = 10 AND af = 'nao', precototal, 0.00)) AS outnormal, SUM(IF(MONTH(data_ini) = 10 AND af = 'sim', precototal, 0.00)) AS outaf, SUM(IF(MONTH(data_ini) = 11 AND af = 'nao', precototal, 0.00)) AS novnormal, SUM(IF(MONTH(data_ini) = 11 AND af = 'sim', precototal, 0.00)) AS novaf, SUM(IF(MONTH(data_ini) = 12 AND af = 'nao', precototal, 0.00)) AS deznormal, SUM(IF(MONTH(data_ini) = 12 AND af = 'sim', precototal, 0.00)) AS dezaf FROM bigtable_data WHERE YEAR(data_ini) = 2023 GROUP BY regional_id, MONTH(data_ini) ORDER BY regional_nome ) AS valoresmeses"));

        $data_arr = array();

        foreach($regionais as $regional){
            $id = $regional->id;
            $regional =  $regional->regional;

            // Testar se o valor vier null, atribuir 0.0, do tipo: $jannormal = $registro->jannormal != NULL ? $registro->janmnoram ; 0.00;
            $jannormal = 0.00;
            $janaf = 0.00;
            $fevnormal = 0.00;
            $fevaf = 0.00;
            $marnormal = 0.00;
            $maraf = 0.00;
            $abrnormal = 0.00;
            $abraf = 0.00;
            $mainormal = 0.00;
            $maiaf = 0.00;
            $junnormal = 0.00;
            $junaf = 0.00;
            $julnormal = 0.00;
            $julaf = 0.00;
            $agsnormal = 0.00;
            $agsaf = 0.00;
            $setnormal = 0.00;
            $setaf = 0.00;
            $outnormal = 0.00;
            $outaf = 0.00;
            $novnormal = 0.00;
            $novaf = 0.00;
            $deznormal = 0.00;
            $dezaf = 0.00;
            $totalnormal = 0.00;
            $totalaf = 0.00;
            $percentagemnormal = 0.00;
            $percentagemaf = 0.00;


            $data_arr[] = array(
                "id"                => $id,
                "regional"          => $regional,
                "jannormal"         => $jannormal,
                "janaf"             => $janaf,
                "fevnormal"         => $fevnormal,
                "fevaf"             => $fevaf,
                "marnormal"         => $marnormal,
                "maraf"             => $maraf,
                "abrnormal"         => $abrnormal,
                "abraf"             => $abraf,
                "mainormal"         => $mainormal,
                "maiaf"             => $maiaf,
                "junnormal"         => $junnormal,
                "junaf"             => $junaf,
                "julnormal"         => $julnormal,
                "julaf"             => $julaf,
                "agsnormal"         => $agsnormal,
                "agsaf"             => $agsaf,
                "setnormal"         => $setnormal,
                "setaf"             => $setaf,
                "outnormal"         => $outnormal,
                "outaf"             => $outaf,
                "novnormal"         => $novnormal,
                "novaf"             => $novaf,
                "deznormal"         => $deznormal,
                "dezaf"             => $dezaf,
                "totalnormal"       => $totalnormal,
                "totalaf"           => $totalaf,
                "percentagemnormal" => $percentagemnormal,
                "percentagemaf"     => $percentagemaf,
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
