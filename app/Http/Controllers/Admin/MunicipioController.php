<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Municipio;
use App\Models\Regional;
use App\Models\Bairro;
use App\Http\Requests\MunicipioCreateRequest;
use App\Http\Requests\MunicipioUpdateRequest;
use App\Models\Restaurante;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\DB;


class MunicipioController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth', ['except' => ['index', 'show']]);
        $this->middleware(['auth', 'can:adm']);
    }


    public function index()
    {
        $municipios = Municipio::with('regional')->get();

        return view('admin.municipio.index', compact('municipios'));
    }

    public function getamountbairros(Request $request)
    {
        /*
        $condicoes = [
            ['municipio_id', '=', $request->municipio_id],
            ['ativo', '=', 1]
        ];
        $data['bairros'] = Bairro::where($condicoes)->orderBy('nome', 'ASC')->get();
        */
        $id = $request->municipio_id;

        $data['qtd_bairros'] = DB::table('bairros')->where('municipio_id', '=', $id)->count();
        return response()->json($data);
    }


    public function create()
    {
        $regionais = Regional::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        return view('admin.municipio.create', compact('regionais'));
    }


    public function store(MunicipioCreateRequest $request)
    {
        Municipio::create($request->all());

        $request->session()->flash('sucesso', 'Registro incluído com sucesso!');

        return redirect()->route('admin.municipio.index');
    }


    public function show($id)
    {
        $municipio = Municipio::findOrFail($id);
        $regionais = Regional::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();

        return view('admin.municipio.show', compact('municipio', 'regionais'));
    }


    public function edit($id)
    {
        $municipio = Municipio::findOrFail($id);
        $regionais = Regional::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();

        return view('admin.municipio.edit', compact('regionais', 'municipio'));
    }


    public function update($id, MunicipioUpdateRequest $request)
    {
        $municipio = Municipio::findOrFail($id);

        // Validação unique
        Validator::make($request->all(), [
            'nome' => [
                'required',
                Rule::unique('municipios')->ignore($municipio->id),
            ],
        ]);

        $municipio->update($request->all());

        // Alterando dados na bigtable_data, se além do nome do município for alterado sua regional de origem.
        if($request->regional_id != $request->regional_id_old_hidden){
            $nova_regional = Regional::findOrFail($request->regional_id);
            $novo_nome_regional = $nova_regional->nome;                     // Recupera o nome da regional
            
            $affected = DB::table('bigtable_data')->where('municipio_id', '=',  $id)->update(['municipio_nome' => $municipio->nome, 'regional_id' => $municipio->regional_id, 'regional_nome' => $novo_nome_regional]);
        } else {
            $affected = DB::table('bigtable_data')->where('municipio_id', '=',  $id)->update(['municipio_nome' => $municipio->nome]);
        }

        // $request->session()->flash('sucesso', "$affected Registro atualizado com sucesso!");
        $request->session()->flash('sucesso', 'Registro atualizado com sucesso!');

        return redirect()->route('admin.municipio.index');
    }


    public function destroy($id, Request $request)
    {
        Municipio::destroy($id);

        $request->session()->flash('sucesso', 'Registro excluído com sucesso!');

        return redirect()->route('admin.municipio.index');
    }


    public function listarbairros($id)
    {
        $municipio = Municipio::findOrFail($id);

        $bairros = Bairro::where('municipio_id', '=', $id)->get();
        $restaurantes = Restaurante::where('municipio_id', '=', $id)->get();

        return view('admin.municipio.list', compact('municipio','bairros', 'restaurantes'));
    }


    /***************************************/
    /*    RELATÓRIOS PDF's, Excel e CSV    */
    /***************************************/

    public function relpdfmunicipio()
    {
        // Obtendo os dados
        $municipios =  Municipio::orderBy('nome', 'ASC')->get();

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('Municipios_lista.pdf');

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
                        MUNICÍPIOS
                    </td>
                </tr>
            </table>
            <table style="width:717px; border-collapse: collapse;">
                <tr>
                    <td width="50px" class="col-header-table">ID</td>
                    <td width="550px" class="col-header-table">NOME</td>
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
        $html = \View::make('admin.municipio.pdf.pdfmunicipio', compact('municipios'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.municipio.pdf.pdfmunicipio')
        $stylesheet = file_get_contents('pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }



    // --- Relatório PDF Bairros do Município
    public function relpdfmunicipiobairros($id)
    {
        // Obtendo os dados
        $municipio = Municipio::findOrFail($id);
        $bairros =  Bairro::where('municipio_id', '=', $id)->orderBy('nome', 'ASC')->get();

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('BairrosMunicipio_lista.pdf');

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
                        Bairros do Município: '.$municipio->nome.'
                    </td>
                </tr>
            </table>
            <table style="width:717px; border-collapse: collapse;">
                <tr>
                    <td width="50px" class="col-header-table">ID</td>
                    <td width="550px" class="col-header-table">NOME</td>
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
        $html = \View::make('admin.municipio.pdf.pdfmunicipiobairros', compact('bairros'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.regional.pdf.pdfregional')
        $stylesheet = file_get_contents('pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }



    // --- Relatório PDF Restaurantes do Município
    public function relpdfmunicipiorestaurantes($id)
    {
        // Obtendo os dados
        $municipio = Municipio::findOrFail($id);
        $restaurantes =  Restaurante::where('municipio_id', '=', $id)->orderBy('identificacao', 'ASC')->get();

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('RestaurantesMunicipio_lista.pdf');

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
                        Restaurantes do Município: '.$municipio->nome.'
                    </td>
                </tr>
            </table>
            <table style="width:717px; border-collapse: collapse;">
                <tr>
                    <td width="50px" class="col-header-table">ID</td>
                    <td width="550px" class="col-header-table">NOME</td>
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
        $html = \View::make('admin.municipio.pdf.pdfmunicipiorestaurantes', compact('restaurantes'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.regional.pdf.pdfregional')
        $stylesheet = file_get_contents('pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }
}
