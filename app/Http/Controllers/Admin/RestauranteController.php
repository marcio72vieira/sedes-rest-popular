<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurante;
use App\Models\Municipio;
use App\Models\Bairro;
use App\Models\Empresa;
use App\Models\User;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\RestauranteCreateRequest;
use App\Http\Requests\RestauranteUpdateRequest;
use App\Models\Nutricionista;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class RestauranteController extends Controller
{
    public function __construct()
    {
        // O usuário logado deve está autenticado e possui autorização para executar os métodos deste controle
        //$this->middleware('auth', ['except' => ['index', 'show']]);
        $this->middleware(['auth', 'can:adm']);
    }


    public function index()
    {
        //$restaurantes = Restaurante::all();

        // Se ADMINISTRADOR, visualiza todos os RESTAURANTES, caso contrário, NUTRICIONISTA, só ao qual pertence
        // Obs: Esta condição abaixo, só era faria sentido, se o USUÁRIO NUTRICIONISTA DA SEDES tivesse acesso
        //      ao cadastro do restaurante ao qual o mesmo era responsável. Esta condição pode ser suprimida ficando
        //      apnenas a seguinte linha: $restaurantes = Restaurante::orderBy('identificacao', 'ASC')->get();
        if(Auth::user()->perfil == 'adm'){
            $restaurantes = Restaurante::orderBy('identificacao', 'ASC')->get();
        } else {
            $restaurantes = Restaurante::where('user_id', '=', Auth::user()->id)->orderBy('identificacao', 'ASC')->get();
        }

        return view('admin.restaurante.index', compact('restaurantes'));
    }


    ////// Início - Ajax para datatable com paginação dinâmica
    /*
        AJAX request.
        Este método é executado automaticamente pela linha: ajax: "{{route('admin.ajaxgetRestaurantes')}}", que se encontra no script da view: admin.restaurantes.index
    */
    public function ajaxgetRestaurantes(Request $request){

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

        /***********************************************************************************************************
        // RECUPERAÇÃO DE REGISTROS FEITO ATRAVÉS DO ELOQUENTE E SEUS RELACIONAMENTOS DIRETOS (TOTALMENTE FUNCIONAL)
        // Total records
        $totalRecords = Restaurante::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Restaurante::select('count(*) as allcount')->where('identificacao', 'like', '%' .$searchValue . '%')->count();

        // Fetch records
        $restaurantes = Restaurante::orderBy($columnName,$columnSortOrder)
        ->where('restaurantes.identificacao', 'like', '%' .$searchValue . '%')
        ->select('restaurantes.*')
        ->skip($start)
        ->take($rowperpage)
        ->get();

        $data_arr = array();

        foreach($restaurantes as $restaurante){
            // campos a serem exibidos
            $id = $restaurante->id;
            $municipio = $restaurante->municipio->nome;
            $identificacao = $restaurante->identificacao;
            $responsaveis = "<span style='font-size: 10px; color: blue'>SEDES: </span>".$restaurante->user->nomecompleto." / ". $restaurante->user->telefone." / ".$restaurante->user->email."<br> <span style='font-size: 10px; color: blue'>EMPRESA: </span>".$restaurante->nutricionista->nomecompleto." / ". $restaurante->nutricionista->telefone." / ".$restaurante->nutricionista->email;
            $compras = $restaurante->qtdcomprasvinc($restaurante->id);
            $ativo = ($restaurante->ativo == 1) ? "<b><i class='fas fa-check text-success mr-2'></i></b>" : "<b><i class='fas fa-times  text-danger mr-2'></i></b>";


            // ações
            $actionShow = "<a href='".route('admin.restaurante.show', $id)."' title='exibir'><i class='fas fa-eye text-warning mr-2'></i></a>";
            $actionEdit = "<a href='".route('admin.restaurante.edit', $id)."' title='editar'><i class='fas fa-edit text-info mr-2'></i></a>";
            // verifica se o restaurante possui compras vinculadas para não possibilitar sua exclusão acidental
            if($restaurante->qtdcomprasvinc($restaurante->id) == 0){
                $actionDelete = "<a href='' class='deleterestaurante' data-idrestaurante='".$id."' data-identificacaorestaurante='".$identificacao."'  data-toggle='modal' data-target='#formDelete' title='excluir'><i class='fas fa-trash text-danger mr-2'></i></a>";
            }else{
                $actionDelete = "<a title='há compras vinculadas!'><i class='fas fa-trash text-secondary mr-2'></i></a>";
            }


            $actions = $actionShow. " ".$actionEdit. " ".$actionDelete;

            $data_arr[] = array(
                "id" => $id,
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
        ***********************************************************************************************************/


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
            ->orWhere('regionais.nome', 'like', '%' . $searchValue . '%' )
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
        ->orWhere('regionais.nome', 'like', '%' . $searchValue . '%' )
        ->orderBy($columnName,$columnSortOrder)
        ->skip($start)
        ->take($rowperpage)
        ->get();


        $data_arr = array();

        foreach($restaurantes as $restaurante){
            // campos a serem exibidos
            $id = $restaurante->id;
            $regional = $restaurante->regional;
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
    ////// Fim - Ajax para datatable com paginação dinâmica





    public function getbairrosrestaurante(Request $request)
    {
        $condicoes = [
            ['municipio_id', '=', $request->municipio_id],
            ['ativo', '=', 1]
        ];

        $data['bairros'] = Bairro::where($condicoes)->orderBy('nome', 'ASC')->get();
        return response()->json($data);
    }


    /*
    MÉTODO ORIGINAL
    public function getnutricionistasempresas(Request $request)
    {
        $condicoes = [
            ['empresa_id', '=', $request->empresa_id],
            ['ativo', '=', 1]
        ];

        $data['nutricionistas'] = Nutricionista::where($condicoes)->orderBy('nomecompleto', 'ASC')->get();
        return response()->json($data);
    }
    */

    public function getnutricionistasempresas(Request $request)
    {
        $condicoes = [
            ['empresa_id', '=', $request->empresa_id],
            ['ativo', '=', 1]
        ];

        $data['nutricionistas'] = Nutricionista::where($condicoes)->orderBy('nomecompleto', 'ASC')->get();
        return response()->json($data);
    }


    /*
    MÉTODO ORIGINAL - PERMITE QUE UM NUTRICIONISTA E UM USUÁRIO SEJAM ALOCADOS PARA MAIS DE UM RESTAURANTE
    public function create()
    {
        $municipios = Municipio::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $bairros = Bairro::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $empresas = Empresa::where('ativo', '=', '1')->orderBy('nomefantasia', 'ASC')->get();
        $nutricionistas = Nutricionista::where('ativo', '=', '1')->orderBy('nomecompleto', 'ASC')->get();
        $users = User::where('perfil', '=', 'nut')->orderBy('nomecompleto', 'ASC')->get();

        return view('admin.restaurante.create', compact('municipios', 'bairros', 'empresas', 'nutricionistas','users'));
    }
    */


    public function create()
    {
        $municipios = Municipio::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $bairros = Bairro::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $empresas = Empresa::where('ativo', '=', '1')->orderBy('nomefantasia', 'ASC')->get();

        //Recupera todos os nutricionistas cujo que estejamm ativo, apenas os campos id e nomecompleto
        $nutricionistas = Nutricionista::select('id', 'nomecompleto')->where('ativo', '=', '1')->orderBy('nomecompleto', 'ASC')->get();

        //Recupera todos os usuários cujo perfil seja igual a "nut", apenas os campos id e nomecompleto
        $users = User::select('id', 'nomecompleto')->where('perfil', '=', 'nut')->orderBy('nomecompleto', 'ASC')->get();
        //Recupera todos os usuários associados a um Restaurante, apenas o campo 'user_id'
        $usersAlocadosRestaurante = Restaurante::select('user_id')->get();

        //Recupera apenas os usuários que não estejam previamente associados a um Restaurante(evita selecionar o mesmo
        //usuário para mais de um restaurante). Observação: Essa regra não deve ser aplicada para a edição de um
        //restaurante, devendo nesse caso, serem exibidos todos os usuários.
        $users = $users->diff(User::whereIn('id', $usersAlocadosRestaurante)->get());

        return view('admin.restaurante.create', compact('municipios', 'bairros', 'empresas', 'nutricionistas','users'));
    }


    public function store(RestauranteCreateRequest $request)
    {
        Restaurante::create([
            'identificacao'     => $request['identificacao'],
            'logradouro'        => $request['logradouro'],
            'numero'            => $request['numero'],
            'complemento'       => $request['complemento'],
            'municipio_id'      => $request['municipio_id'],
            'bairro_id'         => $request['bairro_id'],
            'cep'               => $request['cep'],
            'empresa_id'        => $request['empresa_id'],
            'nutricionista_id'  => $request['nutricionista_id'],
            'user_id'           => $request['user_id'],
            'ativo'             => $request['ativo'],
        ]);

        $request->session()->flash('sucesso', 'Registro incluído com sucesso!');

        return redirect()->route('admin.restaurante.index');

    }


    public function show($id)
    {
        // Resgata registro através do eager-load
        // $empresa = Empresa::with(['municipio', 'bairro', 'banco'])->find($id);
        $restaurante = Restaurante::with(['municipio', 'bairro'])->find($id);

        return view('admin.restaurante.show', compact('restaurante'));
    }


    public function edit($id)
    {
        $restaurante = Restaurante::find($id);

        $municipios = Municipio::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $bairros = Bairro::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $empresas = Empresa::where('ativo', '=', '1')->orderBy('nomefantasia', 'ASC')->get();
        $nutricionistas = Nutricionista::where('ativo', '=', '1')->orderBy('nomecompleto', 'ASC')->get();
        $users = User::where('perfil', '=', 'nut')->orderBy('nomecompleto', 'ASC')->get();

        return view('admin.restaurante.edit', compact('restaurante', 'municipios', 'bairros', 'empresas', 'nutricionistas', 'users'));
    }


    public function update(RestauranteUpdateRequest $request, $id)
    {
        $restaurante = Restaurante::find($id);

        // Validação unique para cnpj na atualização
        Validator::make($request->all(), [
            'cnpj' => [
                'required',
                Rule::unique('restaurantes')->ignore($restaurante->id),
            ],
        ]);

        $restaurante->update($request->all());

        $request->session()->flash('sucesso', 'Registro atualizado com sucesso!');

        return redirect()->route('admin.restaurante.index');
    }


    public function destroy($id, Request $request)
    {
        $restaurante = Restaurante::find($id);

        Restaurante::destroy($id);

        $request->session()->flash('sucesso', 'Registro excluído com sucesso!');

        return redirect()->route('admin.restaurante.index');
    }



    /***************************************/
    /*    RELATÓRIOS PDF's, Excel e CSV    */
    /***************************************/

    // --- Relatório PDF Restaurante
    public function relpdfrestaurante()
    {
        // Obtendo os dados
        $restaurantes =  Restaurante::with(['municipio', 'empresa', 'nutricionista', 'user'])->get();

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('Restaurantes_lista.pdf');

        // Invocando a biblioteca mpdf e definindo as margens do arquivo
        $mpdf = new \Mpdf\Mpdf([
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 25,
            'margin_bottom' => 15,
            'margin-header' => 10,
            'margin_footer' => 5
        ]);

        // Configurando o cabeçalho da página
        $mpdf->SetHTMLHeader('
            <table style="width:717px; border-bottom: 1px solid #000000; margin-bottom: 3px;">
                <tr>
                    <td style="width: 83px">
                        <img src="images/logo-ma.png" width="80"/>
                    </td>
                    <td style="width: 282px; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                        Governo do Estado do Maranhão<br>
                        Secretaria de Governo<br>
                        Secreatia Adjunta de Tecnologia da Informação/SEATI<br>
                        Secretaria do Estado de Desenvolvimento Social/SEDES
                    </td>
                    <td style="width: 352px;" class="titulo-rel">
                        RESTAURANTES
                    </td>
                </tr>
            </table>
        ');

        // Configurando o rodapé da página
        $mpdf->SetHTMLFooter('
            <table style="width:717px; border-top: 1px solid #000000; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                <tr>
                    <td width="239px">São Luis(MA) {DATE d/m/Y h:i}</td>
                    <td width="239px" align="center"></td>
                    <td width="239px" align="right">{PAGENO}/{nbpg}</td>
                </tr>
            </table>
        ');


        // Definindo a view que deverá ser renderizada como arquivo .pdf e passando os dados da pesquisa
        $html = \View::make('admin.restaurante.pdf.pdfrestaurante', compact('restaurantes'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.empresa.pdf.pdfempresa')
        $stylesheet = file_get_contents('pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }


}
