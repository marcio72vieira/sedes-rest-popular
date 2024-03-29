<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Municipio;
use App\Models\Bairro;
use App\Http\Requests\BairroCreateRequest;
use App\Http\Requests\BairroUpdateRequest;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\DB;

class BairroController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth', ['except' => ['index', 'show']]);
        $this->middleware(['auth', 'can:adm']);
    }


    public function index()
    {
        $bairros = Bairro::all();
        return view('admin.bairro.index', compact('bairros'));
    }


    public function create()
    {
        $municipios = Municipio::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        return view('admin.bairro.create', compact('municipios'));
    }


    public function store(BairroCreateRequest $request)
    {
        Bairro::create($request->all());

        $request->session()->flash('sucesso', 'Registro incluído com sucesso!');

        return redirect()->route('admin.bairro.index');
    }


    public function show($id)
    {
        $bairro = Bairro::findOrFail($id);
        $municipios = Municipio::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();

        return view('admin.bairro.show', compact('municipios', 'bairro'));
    }


    public function edit($id)
    {
        $bairro = Bairro::findOrFail($id);
        $municipios = Municipio::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();

        return view('admin.bairro.edit', compact('municipios', 'bairro'));
    }


    public function update($id, BairroUpdateRequest $request)
    {

        $bairro = Bairro::findOrFail($id);


        // Validação unique
        Validator::make($request->all(), [
            'nome' => [
                'required',
                Rule::unique('bairros')->ignore($bairro->id),
            ],
        ]);

        $bairro->update($request->all());


        // Alterando dados na bigtable_data, se além do nome do bairro for alterado seu município de origem.
        if($request->municipio_id != $request->municipio_id_old_hidden){
            $novo_municipio = Municipio::findOrFail($request->municipio_id);
            $novo_nome_municipio = $novo_municipio->nome;                   // Recupera o nome do município
            $novo_id_regional = $novo_municipio->regional_id;               // O model município possui o campo regional_id
            $novo_nome_regional = $novo_municipio->regional->nome;          // O model município possui um relacionamento com regional
            
            $affected = DB::table('bigtable_data')->where('bairro_id', '=',  $id)->update(['bairro_nome' => $bairro->nome, 'municipio_id' => $bairro->municipio_id, 'municipio_nome' => $novo_nome_municipio, 'regional_id' => $novo_id_regional, 'regional_nome' => $novo_nome_regional]);
            $request->session()->flash('aviso', "É necessário atualizar o Muncípio do Restaurante pertencente a este bairro!");
        } else {
            // Obs: update(['bairro_nome' => $bairro->nome]), significa que o campo bairro_nome recebe o valor da propriedade ->nome do objeto $bairro depois de atualizado no banco ($bairro->update($request->all())), ou seja, com os dados já alterados.
            $affected = DB::table('bigtable_data')->where('bairro_id', '=',  $id)->update(['bairro_nome' => $bairro->nome]);
        }

        // $request->session()->flash('sucesso', "$affected Registro atualizado com sucesso!");
        $request->session()->flash('sucesso', "Registro atualizado com sucesso!");

        return redirect()->route('admin.bairro.index');
    }


    public function destroy($id, Request $request)
    {
        Bairro::destroy($id);

        $request->session()->flash('sucesso', 'Registro excluído com sucesso!');

        return redirect()->route('admin.bairro.index');
    }




    /***************************************/
    /*    RELATÓRIOS PDF's, Excel e CSV    */
    /***************************************/

    public function relpdfbairro()
    {
        // Obtendo os dados
        $bairros =  Bairro::with('municipio')->orderBy('nome', 'ASC')->get();

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('Bairros_lista.pdf');

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
                        BAIRROS
                    </td>
                </tr>
            </table>
            <table style="width:717px; border-collapse: collapse;">
                <tr>
                    <td width="50px" class="col-header-table">ID</td>
                    <td width="276px" class="col-header-table">NOME</td>
                    <td width="275px" class="col-header-table">MUNICÍPIO</td>
                    <td width="115px" class="col-header-table">ATIVO</td>
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
        $html = \View::make('admin.bairro.pdf.pdfbairro', compact('bairros'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.bairro.pdf.pdfbairro')
        $stylesheet = file_get_contents('pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

        //return view('admin.bairro.pdf.pdfbairro', compact('bairros'));
    }




}
