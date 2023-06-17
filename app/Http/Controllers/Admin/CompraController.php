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
use Illuminate\Support\Facades\Auth;

use App\Models\Comprovante;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Illuminate\Support\Carbon;

class CompraController extends Controller
{

    public function index(Request $request, $idrestaurante)
    {
        //echo "Mês: " . $request->mes_id. " Ano:" . $request->ano_id;

        // Meses e anos para popular campos selects
        $mesespesquisa = [
            '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
            '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
        ];

        $anoimplantacao = 2023;
        $anoatual = date("Y");
        $anospesquisa = [];
        $anos = [];

        if($anoimplantacao >= $anoatual){
            $anospesquisa[] = $anoatual;
        }else{
            $qtdanosexibicao = $anoatual - $anoimplantacao;
            for($a = $qtdanosexibicao; $a >= 0; $a--){
                $anos[] = $anoatual - $a;
            }
            $anospesquisa = array_reverse($anos);
        }

        /* //Recupera em uma collection o número de registros relacionados, para impedir deleção acidental.
        //Todos os registros relacionados entre comprovante e compra, independente de seus IDs serão recuperados
        $comprovantes = Comprovante::withCount('compra')->get();
        //Transforma a collection ($comprovante) retornada pelo ->get() em um array.
        $turnarray = $comprovantes->toArray();
        //Do array retornado, extrai apenas os valores da chave compra_id
        //Na view, comparo o id da compra corrente dentro do foreach com os id's do array $regsvinculados
        $regsvinculado = Arr::pluck($turnarray, 'compra_id');
        return view('admin.compra.index', compact('restaurante', 'compras', 'produtos', 'regsvinculado')); */


        $restaurante = Restaurante::findOrFail($idrestaurante);
        //$produtos = Produto::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();

        // Recupera todas as compras do restaurante (query anterior á query com limitação dos 3 últimos meses)
        //$compras = Compra::with('comprovantes')->where('restaurante_id', '=', $idrestaurante)->orderBy('data_ini', 'DESC')->get();

        // Recupera só as compras realizadas nos últimos 3 mêses (3 months) ou 90 dias (90 days) ou 1 ano (1 year) atrás, conforme a necessidade
        $dataAtual = date("Y-m-d");             // obtém a data atual
        $dataAtual =  date_create($dataAtual);  // cria uma data a partir da data atual
        $dataRetroativa = date_sub($dataAtual, date_interval_create_from_date_string("3 months"));  // subtrai da dataATual do tempo necessário

        if(isset($request->mes_id) && isset($request->ano_id) ){
            $compras = Compra::with('comprovantes')->where('restaurante_id', '=', $restaurante->id)->whereMonth('data_ini', $request->mes_id)->whereYear('data_ini', $request->ano_id)->orderBy('data_ini', 'DESC')->get();
        } else {
            $compras = Compra::with('comprovantes')->where('restaurante_id', '=', $restaurante->id)->where('data_ini', '>=', $dataRetroativa)->orderBy('data_ini', 'DESC')->get();
        }


        //$compras = Compra::with('comprovantes')->where('restaurante_id', '=', $restaurante->id)->where('data_ini', '>=', $dataRetroativa)->orderBy('data_ini', 'DESC')->get();


        //$compras = Compra::whereMonth('data_ini', date('11'))->first();

        //return view('admin.compra.index', compact('restaurante', 'compras', 'produtos'));
        return view('admin.compra.index', compact('restaurante', 'compras', 'mesespesquisa', 'anospesquisa'));
    }


    public function create($idrestaurante)
    {
        $restaurante = Restaurante::findOrFail($idrestaurante);

        $produtos = Produto::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $medidas = Medida::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();


        return view('admin.compra.create', compact('restaurante', 'produtos', 'medidas'));
    }


    public function store(CompraCreateRequest $request, $idrestaurante)
    {
        //dd($request->restaurante_id_hidden);
        //dd($request);

        $arrProdIds = [];
        $arrMesclado = [];

        $arrProdutos = [];
        $arrComposto = [];

        for($x = 0; $x < count($request->produto_id); $x++){
            $arrProdIds[] = $request->produto_id[$x];
            $arrProdutos[] = $request->produto_id[$x];

            // Campos a serem gravados na tabela compra_produto
            // $user->roles()->sync([1 => ['expires' => true], 2, 3]);
            $arrMesclado[$arrProdIds[$x]] = [
                'quantidade'    => $request->quantidade[$x],
                'medida_id'     => $request->medida_id[$x],
                'detalhe'       => $request->detalhe[$x],
                'preco'         => $request->preco[$x],
                'af'            => $request->af_hidden[$x],
                'precototal'    => $request->precototal[$x]];

            // Campos a serem gravados na tabela bigtable_data para consultas rápidas
            $arrComposto[$arrProdutos[$x]] = [
                'quantidade'                    => $request->quantidade[$x],
                'medida_id'                     => $request->medida_id[$x],
                'detalhe'                       => $request->detalhe[$x],
                'preco'                         => $request->preco[$x],
                'af'                            => $request->af_hidden[$x],
                'precototal'                    => $request->precototal[$x],
                'produto_nome'                  => $request->produto_nome_hidden[$x],
                'medida_nome'                   => $request->medida_nome_hidden[$x],
                'medida_simbolo'                => $request->medida_simbolo[$x],
                'semana'                        => $request->semana_hidden,
                'semana_nome'                   => $request->semana_nome_hidden,
                'data_ini'                      => $request->data_ini_hidden,
                'data_fin'                      => $request->data_fin_hidden,
                'valor'                         => $request->valor_hidden,
                'valoraf'                       => $request->valoraf_hidden,
                'valortotal'                    => $request->valortotal_hidden,
                'categoria_id'                  => $request->categoria_id_hidden[$x],
                'categoria_nome'                => $request->categoria_nome_hidden[$x],
                'restaurante_id'                => $request->restaurante_id_hidden,
                'identificacao'                 => $request->identificacao_hidden,
                'regional_id'                   => $request->regional_id_hidden,
                'regional_nome'                 => $request->regional_nome_hidden,
                'municipio_id'                  => $request->municipio_id_hidden,
                'municipio_nome'                => $request->municipio_nome_hidden,
                'bairro_id'                     => $request->bairro_id_hidden,
                'bairro_nome'                   => $request->bairro_nome_hidden,
                'empresa_id'                    => $request->empresa_id_hidden,
                'razaosocial'                   => $request->razaosocial_hidden,
                'nomefantasia'                  => $request->nomefantasia_hidden,
                'cnpj'                          => $request->cnpj_hidden,
                'nutricionista_id'              => $request->nutricionista_id_hidden,
                'nutricionista_nomecompleto'    => $request->nutricionista_nomecompleto_hidden,
                'nutricionista_cpf'             => $request->nutricionista_cpf_hidden,
                'nutricionista_crn'             => $request->nutricionista_crn_hidden,
                'nutricionista_empresa_id'      => $request->nutricionista_empresa_id_hidden,
                'user_id'                       => $request->user_id_hidden,
                'user_nomecompleto'             => $request->user_nomecompleto_hidden,
                'user_cpf'                      => $request->user_cpf_hidden,
                'user_crn'                      => $request->user_crn_hidden
            ];

        }


        DB::beginTransaction();
            //Com o $resquest->all(), só os campos definidos no model (propriedade $fillable) serão gravados
            $compra = Compra::create($request->all());

            $compra->produtos()->sync($arrMesclado);

            $compra->allProdutos()->sync($arrComposto);

        DB::commit();

        $request->session()->flash('sucesso', 'Registro incluído com sucesso!');

        return redirect()->route('admin.restaurante.compra.index', $idrestaurante);
    }


    public function show($idrestaurante, $idcompra)
    {
        $restaurante = Restaurante::findOrFail($idrestaurante);
        $compra = Compra::with('produtos')->findOrFail($idcompra);
        $medidas = Medida::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();

        //dd([$restaurante, $compra, $medidas]);

        return view('admin.compra.show', compact('restaurante', 'compra', 'medidas'));
    }


    public function edit($idrestaurante, $idcompra)
    {
        $restaurante = Restaurante::findOrFail($idrestaurante);

        $compra = Compra::with('produtos')->findOrFail($idcompra);

        $produtos = Produto::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        //$produtos = Produto::where('ativo', '=', '1')->get();
        $medidas = Medida::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();


        return view('admin.compra.edit', compact('restaurante', 'compra', 'produtos', 'medidas'));
    }


    /*
    public function update(CompraUpdateRequest $request, $idrestaurante, $idcompra)
    {

        $compra = Compra::findOrFail($idcompra);

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
    */

    public function update(CompraUpdateRequest $request, $idrestaurante, $idcompra)
    {

        //dd($request);

        $compra = Compra::findOrFail($idcompra);

        $arrProdIds = [];
        $arrMesclado = [];

        $arrProdutos = [];
        $arrComposto = [];


        for($x=0; $x < count($request->produto_id); $x++){
            $arrProdIds[] = $request->produto_id[$x];
            $arrProdutos[] = $request->produto_id[$x];

            $arrMesclado[$arrProdIds[$x]] = [
                'quantidade' => $request->quantidade[$x],
                'medida_id' => $request->medida_id[$x],
                'detalhe' => $request->detalhe[$x],
                'preco' => $request->preco[$x],
                'af' => $request->af_hidden[$x],
                'precototal' => $request->precototal[$x]
            ];


            // Campos a serem gravados na tabela bigtable_data para consultas rápidas
            $arrComposto[$arrProdutos[$x]] = [
                'quantidade'                    => $request->quantidade[$x],
                'medida_id'                     => $request->medida_id[$x],
                'detalhe'                       => $request->detalhe[$x],
                'preco'                         => $request->preco[$x],
                'af'                            => $request->af_hidden[$x],
                'precototal'                    => $request->precototal[$x],
                'produto_nome'                  => $request->produto_nome_hidden[$x],
                'medida_nome'                   => $request->medida_nome_hidden[$x],
                'medida_simbolo'                => $request->medida_simbolo[$x],
                'semana'                        => $request->semana_hidden,
                'semana_nome'                   => $request->semana_nome_hidden,
                'data_ini'                      => $request->data_ini_hidden,
                'data_fin'                      => $request->data_fin_hidden,
                'valor'                         => $request->valor_hidden,
                'valoraf'                       => $request->valoraf_hidden,
                'valortotal'                    => $request->valortotal_hidden,
                'categoria_id'                  => $request->categoria_id_hidden[$x],
                'categoria_nome'                => $request->categoria_nome_hidden[$x],
                'restaurante_id'                => $request->restaurante_id_hidden,
                'identificacao'                 => $request->identificacao_hidden,
                'regional_id'                   => $request->regional_id_hidden,
                'regional_nome'                 => $request->regional_nome_hidden,
                'municipio_id'                  => $request->municipio_id_hidden,
                'municipio_nome'                => $request->municipio_nome_hidden,
                'bairro_id'                     => $request->bairro_id_hidden,
                'bairro_nome'                   => $request->bairro_nome_hidden,
                'empresa_id'                    => $request->empresa_id_hidden,
                'razaosocial'                   => $request->razaosocial_hidden,
                'nomefantasia'                  => $request->nomefantasia_hidden,
                'cnpj'                          => $request->cnpj_hidden,
                'nutricionista_id'              => $request->nutricionista_id_hidden,
                'nutricionista_nomecompleto'    => $request->nutricionista_nomecompleto_hidden,
                'nutricionista_cpf'             => $request->nutricionista_cpf_hidden,
                'nutricionista_crn'             => $request->nutricionista_crn_hidden,
                'nutricionista_empresa_id'      => $request->nutricionista_empresa_id_hidden,
                'user_id'                       => $request->user_id_hidden,
                'user_nomecompleto'             => $request->user_nomecompleto_hidden,
                'user_cpf'                      => $request->user_cpf_hidden,
                'user_crn'                      => $request->user_crn_hidden
            ];
        }

        DB::beginTransaction();

            $compra->update($request->all());

            $compra->produtos()->sync($arrMesclado);

            $compra->allProdutos()->sync($arrComposto);

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
        $restaurante = Restaurante::findOrFail($idrest);
        $compra = Compra::with('produtos')->findOrFail($idcompra);
        $medidas = Medida::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('compra_'.$compra->id.'.pdf');

        // Invocando a biblioteca mpdf e definindo as margens do arquivo
        $mpdf = new \Mpdf\Mpdf([
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 60,
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
                        '.$restaurante->identificacao.' <br> compra nº '.$compra->id.'
                    </td>
                </tr>
            </table>
            <table style="width:717px; border-collapse: collapse;">
                <tr>
                    <td style="width: 417px;" class="label-ficha">Município (Regional)</td>
                    <td style="width: 100px;" class="label-ficha">Semana</td>
                    <td style="width: 100px;" class="label-ficha">Data Inicial</td>
                    <td style="width: 100px;" class="label-ficha">Data Final</td>
                </tr>
                <tr>
                    <td style="width: 417px;" class="dados-ficha">'.$restaurante->municipio->nome.' ('.$restaurante->municipio->regional->nome.')</td>
                    <td style="width: 100px;" class="dados-ficha">'.mrc_extract_week($compra->semana).'</td>
                    <td style="width: 100px;" class="dados-ficha">'.mrc_turn_data($compra->data_ini).'</td>
                    <td style="width: 100px;" class="dados-ficha">'.mrc_turn_data($compra->data_fin).'</td>
                </tr>
            </table>

            <table style="width:717px; border-collapse: collapse;">
                <tr>
                    <td style="width: 417px;" class="label-ficha">Restaurante</td>
                    <td style="width: 100px;" class="label-ficha">Valor</td>
                    <td style="width: 100px;" class="label-ficha">Valor AF ('.intval(mrc_calc_percentaf($compra->valortotal, $compra->valoraf )).'%)</td>
                    <td style="width: 100px;" class="label-ficha">Valor Total</td>
                </tr>
                <tr>
                    <td style="width: 417px;" class="dados-ficha">'.$restaurante->identificacao.'</td>
                    <td style="width: 100px; text-align:right" class="dados-ficha">'.mrc_turn_value($compra->valor).'</td>
                    <td style="width: 100px; text-align:right" class="dados-ficha">'.mrc_turn_value($compra->valoraf).'</td>
                    <td style="width: 100px; text-align:right" class="dados-ficha">'.mrc_turn_value($compra->valortotal).'</td>
                </tr>
            </table>

            <table style="width:717px; border-collapse: collapse;">
                <tr>
                    <td style="width: 417px;" class="label-ficha">Nutricionista Empresa</td>
                    <td style="width: 300px;" class="label-ficha">Nutricionista SEDES</td>
                </tr>
                <tr>
                    <td style="width: 417px;" class="dados-ficha">'.$restaurante->nutricionista->nomecompleto.'</td>
                    <td style="width: 300px;" class="dados-ficha">'.$restaurante->user->nomecompleto.'</td>
                </tr>
                <tr>
                    <td colspan="2" style="width:717px;" class="close-ficha"></td>
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
                    <td width="239px">São Luis(MA) {DATE d/m/Y H:i}</td>
                    <td width="239px" align="center"></td>
                    <td width="239px" align="right">{PAGENO}/{nbpg}</td>
                </tr>
            </table>
        ');


        // Configurando marca D'agua
        //$mpdf->WriteHTML('Hello World');
        $mpdf->showWatermarkText = true;
        $mpdf->SetWatermarkText('SEDES');
        $mpdf->watermarkTextAlpha = 0.08;

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
