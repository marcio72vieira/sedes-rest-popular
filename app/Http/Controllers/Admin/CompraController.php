<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurante;
use App\Models\Produto;
use App\Models\Medida;
use App\Models\Compra;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CompraCreateRequest;
use App\Http\Requests\CompraUpdateRequest;
use App\Models\Comprovante;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CompraController extends Controller
{

    public function index($idrestaurante)
    {
        $restaurante = Restaurante::find($idrestaurante);
        $produtos = Produto::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $compras = Compra::where('restaurante_id', '=', $idrestaurante)->orderBy('data_ini', 'DESC')->get();

        //Recupera em uma collection o número de registros relacionados, para impedir deleção acidental.
        //Todos os registros relacionados entre comprovante e compra, independente de seus IDs serão recuperados
        $comprovantes = Comprovante::withCount('compra')->get();
        //Transforma a collection ($comprovante) retornada pelo ->get() em um array.
        $turnarray = $comprovantes->toArray();
        //Do array retornado, extrai apenas os valores da chave compra_id
        //Na view, comparo o id da compra corrente dentro do foreach com os id's do array $regsvinculados
        $regsvinculado = Arr::pluck($turnarray, 'compra_id');
        
        return view('admin.compra.index', compact('restaurante', 'compras', 'produtos', 'regsvinculado'));
    }


    public function create($idrestaurante)
    {
        $restaurante = Restaurante::find($idrestaurante);

        $produtos = Produto::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $medidas = Medida::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();


        return view('admin.compra.create', compact('restaurante', 'produtos', 'medidas'));
    }


    public function store(CompraCreateRequest $request, $idrestaurante)
    {

        $arrProdIds = [];
        $arrCampos = [];
        $arrMesclado = [];


        for($x = 0; $x < count($request->produto_id); $x++){
            $arrProdIds[] = $request->produto_id[$x];
            $arrCampos[] = $request->quantidade[$x];

            //$user->roles()->sync([1 => ['expires' => true], 2, 3]);
            $arrMesclado[$arrProdIds[$x]] = ['quantidade' => $request->quantidade[$x], 'medida_id' => $request->medida_id[$x], 'detalhe' => $request->detalhe[$x], 'preco' => $request->preco[$x], 'af' => $request->af_hidden[$x], 'precototal' => $request->precototal[$x]];
        }


        DB::beginTransaction();
            //Com o $resquest->all(), só os campos definidos no model (propriedade $fillable) serão gravados
             $compra = Compra::create($request->all());
            
            $compra->produtos()->sync($arrMesclado); 

        DB::commit();

        $request->session()->flash('sucesso', 'Registro incluído com sucesso!');

        return redirect()->route('admin.restaurante.compra.index', $idrestaurante);
    }


    public function show($idrestaurante, $idcompra)
    {
        $restaurante = Restaurante::find($idrestaurante);
        $compra = Compra::with('produtos')->find($idcompra);
        $medidas = Medida::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();

        //dd([$restaurante, $compra, $medidas]);

        return view('admin.compra.show', compact('restaurante', 'compra', 'medidas'));
    }


    public function edit($idrestaurante, $idcompra)
    {
        $restaurante = Restaurante::find($idrestaurante);

        $compra = Compra::with('produtos')->find($idcompra);

        //$produtos = Produto::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $produtos = Produto::where('ativo', '=', '1')->get();
        $medidas = Medida::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();


        return view('admin.compra.edit', compact('restaurante', 'compra', 'produtos', 'medidas'));
    }


    public function update(CompraUpdateRequest $request, $idrestaurante, $idcompra)
    {

        $compra = Compra::find($idcompra);

        $arrProdIds = [];
        $arrCampos = [];
        $arrMesclado = [];


        for($x=0; $x < count($request->produto_id); $x++){
            $arrProdIds[] = $request->produto_id[$x];
            $arrCampos[] = $request->quantidade[$x];

            $arrMesclado[$arrProdIds[$x]] = ['quantidade' => $request->quantidade[$x], 'medida_id' => $request->medida_id[$x], 'detalhe' => $request->detalhe[$x], 'preco' => $request->preco[$x], 'af' => $request->af_hidden[$x], 'precototal' => $request->precototal[$x]];
        }

        DB::beginTransaction();

            $compra->update($request->all());

            $compra->produtos()->sync($arrMesclado); 

        DB::commit();

        $request->session()->flash('sucesso', 'Registro atualizado com sucesso!');

        return redirect()->route('admin.restaurante.compra.index', $idrestaurante);
    }




    public function destroy($idrestaurante, $idcompra, Request $request)
    {

        Compra::destroy($idcompra);

        $request->session()->flash('sucesso', 'Registro excluído com sucesso!');

        return redirect()->route('admin.restaurante.compra.index', $idrestaurante);
    }



    /***************************************/
    /*    RELATÓRIOS PDF's, Excel e CSV    */
    /***************************************/

    public function relpdfcompra($idrest, $idcompra)
    {
        // Obtendo os dados
        $restaurante = Restaurante::find($idrest);
        $compra = Compra::with('produtos')->find($idcompra);
        $medidas = Medida::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('compra_'.$compra->id.'.pdf');

        // Invocando a biblioteca mpdf e definindo as margens do arquivo
        $mpdf = new \Mpdf\Mpdf([
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 50,
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
                        Restaurante Popular - '.$restaurante->identificacao.' <br> compra nº '.$compra->id.'
                    </td>
                </tr>
            </table>
            <table style="width:717px; border-collapse: collapse;; margin-bottom: 5px">
                <tr>
                    <td style="width: 417px"><span class="spanlabel">MUNICÍPIO: </span><span  class="spandata">'.$restaurante->municipio->nome.'</span></td>
                    <td style="width: 100px; text-align:right"><span class="spanlabel">SEMANA</span><span class="spandata"></span></td>
                    <td style="width: 100px; text-align:right"><span class="spanlabel">DATA INICIAL</span><span class="spandata"></span></td>
                    <td style="width: 100px; text-align:right"><span class="spanlabel">DATA FINAL</span><span class="spandata"></span></td>
                </tr>
                <tr>
                    <td style="width: 417px"><span class="spanlabel">RESTAURANTE: </span><span  class="spandata">'.$restaurante->identificacao.'</span></td>
                    <td style="width: 100px; text-align:right"><span class="spanlabel"><span class="spandata">'.mrc_extract_week($compra->semana).'</span></td>
                    <td style="width: 100px; text-align:right"><span class="spanlabel"><span class="spandata">'.mrc_turn_data($compra->data_ini).'</span></td>
                    <td style="width: 100px; text-align:right"><span class="spanlabel"><span class="spandata">'.mrc_turn_data($compra->data_fin).'</span></td>
                </tr>
                <tr>
                    <td style="width: 417px"><span class="spanlabel">NUTRICIONISTA DA EMPRESA: </span><span  class="spandata">'.$restaurante->nutricionista->nomecompleto.'</span></td>
                    <td style="width: 100px; text-align:right"><span class="spanlabel">VALOR </span><span class="spandata"></span></td>
                    <td style="width: 100px; text-align:right"><span class="spanlabel">VALOR AF ('.intval(mrc_calc_percentaf($compra->valortotal, $compra->valoraf )).'%)</span><span class="spandata"></span></td>
                    <td style="width: 100px; text-align:right"><span class="spanlabel">VALOR TOTAL</span><span class="spandata"></span></td>
                </tr>
                <tr>
                    <td style="width: 417px"><span class="spanlabel">NUTRICIONISTA DA SEDES: </span><span  class="spandata">'.$restaurante->user->nomecompleto.'</span></td>
                    <td style="width: 100px; text-align:right"><span class="spanlabel"></span><span class="spandata">'.mrc_turn_value($compra->valor).'</span></td>
                    <td style="width: 100px; text-align:right"><span class="spanlabel"></span><span class="spandata">'.mrc_turn_value($compra->valoraf).'</span></td>
                    <td style="width: 100px; text-align:right"><span class="spanlabel"></span><span class="spandata">'.mrc_turn_value($compra->valortotal).'</span></td>
                </tr>
            </table>
            <table style="width:717px; border-collapse: collapse">
                <tr>
                    <td width="30px" class="col-header-table" style="text-align:center">Id</td>
                    <td width="200px" class="col-header-table" style="text-align:center">Produto</td>
                    <td width="50px" class="col-header-table" style="text-align:center">Quant.</td>
                    <td width="50px" class="col-header-table" style="text-align:center">Unid.</td>
                    <td width="200px" class="col-header-table" style="text-align:center">Detalhe</td>
                    <td width="72px" class="col-header-table" style="text-align:center">Preço</td>
                    <td width="35px" class="col-header-table" style="text-align:center">AF</td>
                    <td width="80px" class="col-header-table" style="text-align:center">Total</td>
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
        $html = \View::make('admin.compra.pdf.pdfcompra', compact('compra', 'medidas'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.produto.pdf.pdfproduto')
        $stylesheet = file_get_contents('pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }


}
