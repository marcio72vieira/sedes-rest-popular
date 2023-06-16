<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Rules\CpfValidateRule;  // Utilizado na alteração de profile
use Illuminate\Http\Request;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Models\Municipio;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{

    public function index()
    {
        if(Gate::authorize('adm')){
            $users = User::all();

            return view('admin.user.index', compact('users'));
        }
    }


    public function create()
    {
        if(Gate::authorize('adm')){
            $municipios = Municipio::orderBy('nome', 'ASC')->get();

            return view('admin.user.create', compact('municipios'));
        }
    }


    public function store(UserCreateRequest $request)
    {
        $user = new User();

            $user->nomecompleto = $request->nomecompleto;
            $user->cpf = $request->cpf;
            $user->crn = $request->crn;
            $user->telefone = $request->telefone;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->municipio_id = $request->municipio_id;
            $user->perfil = $request->perfil;
            $user->password = bcrypt($request->password);

            $user->save();

            $request->session()->flash('sucesso', 'Registro incluído com sucesso!');

            return redirect()->route('admin.user.index');
    }


    public function show($id)
    {
        if(Gate::authorize('adm')){
            $user = User::find($id);

            return view('admin.user.show', compact('user'));
        }
    }


    public function edit($id)
    {
        if(Gate::authorize('adm')){
            $municipios = Municipio::orderBy('nome', 'ASC')->get();
            $user = User::find($id);

            $usuario = User::find($id);

            return view('admin.user.edit', compact('municipios', 'user'));
        }
    }


    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::find($id);

            $user->nomecompleto     = $request->nomecompleto;
            $user->cpf              = $request->cpf;
            $user->crn              = $request->crn;
            $user->telefone         = $request->telefone;
            $user->name             = $request->name;
            $user->email            = $request->email;
            $user->perfil           = $request->perfil;

            Validator::make($request->all(), [
                'cpf' => [
                    'required',
                    Rule::unique('users')->ignore($user->id),
                ],
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users')->ignore($user->id),
                ],
            ]);

            if($request->password == ''){
                $user->password = $request->old_password_hidden;
            }else{
                $user->password = bcrypt($request->password);
            }

            $user->save();

            $request->session()->flash('sucesso', 'Registro editado com sucesso!');

            return redirect()->route('admin.user.index');
    }

    public function profile($id)
    {
        $user = User::find($id);

        return view('admin.user.profile', compact('user'));
    }

    public function updateprofile( Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nomecompleto'          => 'bail|required|string',
            'cpf'                   => ['bail', 'required', new CpfValidateRule()], // Valida o CPF com com regra de validação customizada, sem fazer uso do UserCreate ou UserUdpdateRequest
            'crn'                   => 'required_if:perfil,"nut"',  // campo requerido se perfil for do tipo "nut"
            'telefone'              => 'required',
            'name'                  => 'bail|required|string',  // é o campo usuário
            'email'                 => 'bail|required|string|email',
            'password'              => 'bail|required_with:password_confirmation|confirmed',
            'password_confirmation' => 'bail|required_with:password',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }else {

            $user = User::find($id);

            $user->nomecompleto     = $request->nomecompleto;
            $user->cpf          = $request->cpf;
            $user->crn          = $request->crn;
            $user->telefone     = $request->telefone;
            $user->name         = $request->name;
            $user->email        = $request->email;
            $user->perfil       = $request->old_perfil_hidden;         // não é alterado pelo usuário

            if($request->password == ''){
                $user->password = $request->old_password_hidden;
            }else{
                $user->password = bcrypt($request->password);
            }

            $user->save();

            // Atualiza os dados, executa o logout e força o usuário a fazer login novamente com os novos dados
            return redirect()->route('acesso.logout');
        }

    }


    public function destroy($id, Request $request)
    {
        User::destroy($id);

        $request->session()->flash('sucesso', 'Registro excluído com sucesso!');

        return redirect()->route('admin.user.index');
    }


    /***************************************/
    /*    RELATÓRIOS PDF's, Excel e CSV    */
    /***************************************/

    public function relpdfuser()
    {
        // Obtendo os dados
        $users =  User::with('municipio')->orderBy('nomecompleto', 'ASC')->get();

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('Usuarios_lista.pdf');

        // Invocando a biblioteca mpdf e definindo as margens do arquivo
        $mpdf = new \Mpdf\Mpdf([
            'orientation' => 'L',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 30,
            'margin_bottom' => 15,
            'margin-header' => 10,
            'margin_footer' => 5
        ]);

        // Configurando o cabeçalho da página
        $mpdf->SetHTMLHeader('
            <table style="width:1080px; border-bottom: 1px solid #000000; margin-bottom: 3px;">
                <tr>
                    <td style="width: 108px">
                        <img src="images/logo-ma.png" width="80"/>
                    </td>
                    <td style="width: 432px; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                        Governo do Estado do Maranhão<br>
                        Secretaria de Governo<br>
                        Secreatia Adjunta de Tecnologia da Informação/SEATI<br>
                        Secretaria do Estado de Desenvolvimento Social/SEDES
                    </td>
                    <td style="width: 540px;" class="titulo-rel">
                        USUÁRIOS
                    </td>
                </tr>
            </table>
            <table style="width:1080px; border-collapse: collapse">
                <tr>
                    <td width="40px" class="col-header-table">ID</td>
                    <td width="160px" class="col-header-table">NOME</td>
                    <td width="100px" class="col-header-table">PERFIL</td>
                    <td width="200px" class="col-header-table">CIDADE</td>
                    <td width="200px" class="col-header-table">E-mal / Telefone</td>
                    <td width="100px" class="col-header-table">CPF / CRN</td>
                    <td width="230px" class="col-header-table">RESTAURANTE</td>
                    <td width="50px" class="col-header-table">ATIVO</td>
                </tr>
            </table>
        ');

        // Configurando o rodapé da página
        $mpdf->SetHTMLFooter('
            <table style="width:1080px; border-top: 1px solid #000000; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                <tr>
                    <td width="200px">São Luis(MA) {DATE d/m/Y}</td>
                    <td width="830px" align="center"></td>
                    <td width="50px" align="right">{PAGENO}/{nbpg}</td>
                </tr>
            </table>
        ');


        // Definindo a view que deverá ser renderizada como arquivo .pdf e passando os dados da pesquisa
        $html = \View::make('admin.user.pdf.pdfuser', compact('users'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.empresa.pdf.pdfempresa')
        $stylesheet = file_get_contents('pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }







}
