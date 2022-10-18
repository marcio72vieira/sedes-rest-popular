<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Nutricionista;
use App\Http\Requests\EmpresaCreateRequest;
use App\Http\Requests\EmpresaUpdateRequest;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EmpresaController extends Controller
{

    public function index()
    {
        $empresas = Empresa::all();
        return view('admin.empresa.index', compact('empresas'));
    }

    public function create()
    {
        //$municipios = Municipio::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        //return view('admin.empresa.create', compact('municipios'));

        return view('admin.empresa.create');
    }


    public function store(EmpresaCreateRequest $request)
    {
        Empresa::create([
            'razaosocial'   => $request['razaosocial'],
            'nomefantasia'  => $request['nomefantasia'],
            'cnpj'          => $request['cnpj'],
            'titular'       => $request['titular'],
            'cargotitular'  => $request['cargotitular'],
            'logradouro'    => $request['logradouro'],
            'numero'        => $request['numero'],
            'complemento'   => $request['complemento'],
            'municipio'     => $request['municipio'],
            'bairro'        => $request['bairro'],
            'cep'           => $request['cep'],
            'email'         => $request['email'],
            'celular'       => $request['celular'],
            'fone'          => $request['fone'],
            'ativo'         => $request['ativo'],
        ]);


        $request->session()->flash('sucesso', 'Registro incluído com sucesso!');

        return redirect()->route('admin.empresa.index');

    }


    public function show($id)
    {
        // Resgata registro através do eager-load
        // $empresa = Empresa::with(['municipio'])->findOrFail($id);
        // return view('admin.empresa.show', compact('empresa'));

        $empresa = Empresa::findOrFail($id);
        return view('admin.empresa.show', compact('empresa'));

    }


    public function edit($id)
    {
        // $empresa = Empresa::findOrFail($id);
        // $municipios = Municipio::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        // return view('admin.empresa.edit', compact('empresa', 'municipios'));

        $empresa = Empresa::findOrFail($id);
        return view('admin.empresa.edit', compact('empresa'));

    }


    public function update(EmpresaUpdateRequest $request, $id)
    {
        $empresa = Empresa::findOrFail($id);

        // Validação unique para cnpj na atualização
        Validator::make($request->all(), [
            'cnpj' => [
                'required',
                Rule::unique('empresas')->ignore($empresa->id),
            ],
        ]);

        $empresa->update($request->all());

        $request->session()->flash('sucesso', 'Registro atualizado com sucesso!');

        return redirect()->route('admin.empresa.index');
    }



    public function destroy($id, Request $request)
    {
        //$empresa = Empresa::find($id);

        Empresa::destroy($id);

        $request->session()->flash('sucesso', 'Registro excluído com sucesso!');

        return redirect()->route('admin.empresa.index');
    }



    public function listarnutricionistas($id)
    {
        $empresa = Empresa::findOrFail($id);
        $nutricionistas = Nutricionista::where('empresa_id', '=', $id)->get();
        
        return view('admin.empresa.list', compact('empresa','nutricionistas'));
    }




    /***************************************/
    /*    RELATÓRIOS PDF's, Excel e CSV    */
    /***************************************/

    public function relpdfempresa()
    {
        // Obtendo os dados
        $empresas =  Empresa::with('nutricionistas')->get();

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('Empresas_lista.pdf');

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
                        EMPRESAS
                    </td>
                </tr>
            </table>
        ');

        // Configurando o rodapé da página
        $mpdf->SetHTMLFooter('
            <table style="width:717px; border-top: 1px solid #000000; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                <tr>
                    <td width="239px">São Luis(MA) {DATE d/m/Y}</td>
                    <td width="239px" align="center"></td>
                    <td width="239px" align="right">{PAGENO}/{nbpg}</td>
                </tr>
            </table>
        ');


        // Definindo a view que deverá ser renderizada como arquivo .pdf e passando os dados da pesquisa
        $html = \View::make('admin.empresa.pdf.pdfempresa', compact('empresas'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.empresa.pdf.pdfempresa')
        $stylesheet = file_get_contents('pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }



    // --- Relatório PDF Nutricionistas da Empresa
    public function relpdfempresanutricionistas($id)
    {
        // Obtendo os dados
        $empresa = Empresa::findOrFail($id);
        $nutricionistas =  Nutricionista::where('empresa_id', '=', $id)->orderBy('nomecompleto', 'ASC')->get();

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('Empresas_lista.pdf');

        // Invocando a biblioteca mpdf e definindo as margens do arquivo
        $mpdf = new \Mpdf\Mpdf([
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 32,
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
                        Nutricionistas da Empresa:<br>'.$empresa->nomefantasia.'
                    </td>
                </tr>
            </table>
            <table style="width:717px; border-collapse: collapse;">
                <tr>
                    <td width="50px" class="col-header-table">ID</td>
                    <td width="275px" class="col-header-table">NOME</td>
                    <td width="137px" class="col-header-table">E-MAIL</td>
                    <td width="138px" class="col-header-table">CONTATO</td>
                    <td width="115px" class="col-header-table">ATIVO</td>
                </tr>
            </table>
        ');

        // Configurando o rodapé da página
        $mpdf->SetHTMLFooter('
            <table style="width:717px; border-top: 1px solid #000000; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                <tr>
                    <td width="239px">São Luis(MA) {DATE d/m/Y H:i}</td>
                    <td width="239px" align="center"></td>
                    <td width="239px" align="right">{PAGENO}/{nbpg}</td>
                </tr>
            </table>
        ');


        // Definindo a view que deverá ser renderizada como arquivo .pdf e passando os dados da pesquisa
        $html = \View::make('admin.empresa.pdf.pdfempresanutricionistas', compact('nutricionistas'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.empresa.pdf.pdfempresa')
        $stylesheet = file_get_contents('pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }    



}
