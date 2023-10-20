<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurante;
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
            $responsaveis = "<span style='font-size: 10px; color: blue'>SEDES: </span>".$restaurante->nomeusersedes." / ". $restaurante->telefoneusersedes." / ".$restaurante->emailusersedes."<br> <span style='font-size: 10px; color: blue'>EMPRESA: </span>".$restaurante->nomenutricionista." / ". $restaurante->telefonenutricionista." / ".$restaurante->emailnutricionista;
            $compras = DB::table('compras')->where('restaurante_id', '=', $id)->count();
            $ativo = ($restaurante->ativo == 1) ? "<b><i class='fas fa-check text-success mr-2'></i></b>" : "<b><i class='fas fa-times  text-danger mr-2'></i></b>";


            // ações
            $actionShow = "<a href='".route('admin.restaurante.show', $id)."' title='exibir'><i class='fas fa-eye text-warning mr-2'></i></a>";
            $actionEdit = "<a href='".route('admin.restaurante.edit', $id)."' title='editar'><i class='fas fa-edit text-info mr-2'></i></a>";
            // verifica se o restaurante possui compras vinculadas para não possibilitar sua exclusão acidental
            if($compras == 0){
                $actionDelete = "<a href='' class='deleterestaurante' data-idrestaurante='".$id."' data-identificacaorestaurante='".$identificacao."'  data-toggle='modal' data-target='#formDelete' title='excluir'><i class='fas fa-trash text-danger mr-2'></i></a>";
            }else{
                $actionDelete = "<a title='há compras vinculadas!'><i class='fas fa-trash text-secondary mr-2'></i></a>";
            }


            $actions = $actionShow. " ".$actionEdit. " ".$actionDelete;

            $data_arr[] = array(
                "id" => $id,
                "regional" => $regional,
                "municipio" => $municipio,
                "identificacao" => $identificacao,
                "responsaveis" => $responsaveis,
                "compras" => $compras,
                "ativo" => $ativo,
                "actions" => $actions,
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
