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
            $regionais = DB::select(DB::raw("
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

        $regionaltotalnormal = 0;
        $regionaltotalaf = 0;
        $regionaltotalnormalaf = 0;
        $regionalpercentagemnormal = 0;
        $regionalpercentagemaf = 0;

        foreach($regionais as $item){
            $id = $item->id;
            $regional =  $item->regional;
            $jannormal = $item->jannormal;
            $janaf = $item->janaf;
            $fevnormal = $item->fevnormal;
            $fevaf = $item->fevaf;
            $marnormal = $item->marnormal;
            $maraf = $item->maraf;
            $abrnormal = $item->abrnormal;
            $abraf = $item->abraf;
            $mainormal = $item->mainormal;
            $maiaf = $item->maiaf;
            $junnormal = $item->junnormal;
            $junaf = $item->junaf;
            $julnormal = $item->julnormal;
            $julaf = $item->julaf;
            $agsnormal = $item->agsnormal;
            $agsaf = $item->agsaf;
            $setnormal = $item->setnormal;
            $setaf = $item->setaf;
            $outnormal = $item->outnormal;
            $outaf = $item->outaf;
            $novnormal = $item->novnormal;
            $novaf = $item->novaf;
            $deznormal = $item->deznormal;
            $dezaf = $item->dezaf;

            //Soma dos valores normal e af de cada regional
            $regionaltotalnormal = floatval($item->jannormal) + floatval($item->fevnormal) + floatval($item->marnormal) + floatval($item->abrnormal) + floatval($item->mainormal) + floatval($item->junnormal) + floatval($item->julnormal) + floatval($item->agsnormal) + floatval($item->setnormal) + floatval($item->outnormal) + floatval($item->novnormal) + floatval($item->deznormal);
            $regionaltotalaf = floatval($item->janaf) + floatval($item->fevaf) + floatval($item->maraf) + floatval($item->abraf) + floatval($item->maiaf) + floatval($item->junaf) + floatval($item->julaf) + floatval($item->agsaf) + floatval($item->setaf) + floatval($item->outaf) + floatval($item->novaf) + floatval($item->dezaf);

            //Calculando percentagem normal e af
            $regionaltotalnormalaf = $regionaltotalnormal + $regionaltotalaf;
            $regionalpercentagemnormal = (($regionaltotalnormal * 100)/$regionaltotalnormalaf);
            $regionalpercentagemaf = (($regionaltotalaf * 100)/$regionaltotalnormalaf);



            $totalnormal = number_format($regionaltotalnormal, 2, ",", ".");
            $totalaf = number_format($regionaltotalaf, 2, ",", ".");
            $percentagemnormal = $regionalpercentagemnormal;
            $percentagemaf = $regionalpercentagemaf;


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
