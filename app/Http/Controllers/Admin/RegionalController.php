<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Regional;
use App\Models\Municipio;
use App\Http\Requests\RegionalCreateRequest;
use App\Http\Requests\RegionalUpdateRequest;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Illuminate\Support\Arr;

class RegionalController extends Controller
{
    
    public function index()
    {
        $regionais = Regional::all();

        //Verificando se há registros vinculados para evitar deleção acidental na view
        $havinculo = Municipio::withCount('regional')->get();
        $turnarray = $havinculo->toArray();
        $regsvinculados = Arr::pluck($turnarray, 'regional_id');

        return view('admin.regional.index', compact('regionais', 'regsvinculados'));
    }

    
    public function create()
    {
        return view('admin.regional.create');
    }

    
    public function store(RegionalCreateRequest $request)
    {
        Regional::create($request->all());

        $request->session()->flash('sucesso', 'Registro incluído com sucesso!');

        return redirect()->route('admin.regional.index');
    }

    
    public function show($id)
    {
        $regional = Regional::find($id);

        return view('admin.regional.show', compact('regional'));
    }

    
    public function edit($id)
    {
        $regional = Regional::find($id);

        return view('admin.regional.edit', compact('regional'));
    }

    
    public function update(RegionalUpdateRequest $request, $id)
    {
        $regional = Regional::find($id);

        // Validação unique
        Validator::make($request->all(), [
            'nome' => [
                'required',
                Rule::unique('regionais')->ignore($regional->id),
            ],
        ]);


        $regional->update($request->all());

        $request->session()->flash('sucesso', 'Registro atualizado com sucesso!');

        return redirect()->route('admin.regional.index');
    }

   
    public function destroy($id, Request $request)
    {
        Regional::destroy($id);

        $request->session()->flash('sucesso', 'Registro excluído com sucesso!');

        return redirect()->route('admin.regional.index');
    }


    public function listarmunicipios($id)
    {
        $regional = Regional::find($id);
        $municipios = Municipio::where('regional_id', '=', $id)->get();
        
        return view('admin.regional.list', compact('regional','municipios'));
    }


    /***************************************/
    /*    RELATÓRIOS PDF's, Excel e CSV    */
    /***************************************/

    public function relpdfregional()
    {
        // Obtendo os dados
        $regionais =  Regional::all();

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('Regionais_lista.pdf');

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
                        REGIONAIS
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
        $html = \View::make('admin.regional.pdf.pdfregional', compact('regionais'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.regional.pdf.pdfregional')
        $stylesheet = file_get_contents('pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }



    // --- Relatório PDF Municípios da Regional
    public function relpdfregionalmunicipios($id)
    {
        // Obtendo os dados
        $regional = Regional::find($id);
        $municipios =  Municipio::where('regional_id', '=', $id)->orderBy('nome', 'ASC')->get();

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('Regionais_lista.pdf');

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
                        Municípios da Regional: '.$regional->nome.'
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
        $html = \View::make('admin.regional.pdf.pdfregionalmunicipios', compact('municipios'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.regional.pdf.pdfregional')
        $stylesheet = file_get_contents('pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }
}
