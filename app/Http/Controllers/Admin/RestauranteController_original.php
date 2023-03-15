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
        //$this->middleware('auth', ['except' => ['index', 'show']]);
        $this->middleware(['auth', 'can:adm']);
    }
    

    public function index()
    {
        //$restaurantes = Restaurante::all();

        // Se ADMINISTRADOR, visualiza todos os RESTAURANTES, caso contrário, NUTRICIONISTA, só ao qual pertence
        if(Auth::user()->perfil == 'adm'){
            $restaurantes = Restaurante::orderBy('identificacao', 'ASC')->get();
        } else {
            $restaurantes = Restaurante::where('user_id', '=', Auth::user()->id)->orderBy('identificacao', 'ASC')->get();
        }

        return view('admin.restaurante.index', compact('restaurantes'));
    }


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
