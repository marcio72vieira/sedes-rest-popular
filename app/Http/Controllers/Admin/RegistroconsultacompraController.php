<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Regional;
use App\Models\Restaurante;
use App\Models\Compra;
use App\Models\Municipio;
use App\Models\Bairro;
use App\Models\Empresa;
use App\Models\User;
use App\Models\Bigtabledata;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\RestauranteCreateRequest;
use App\Http\Requests\RestauranteUpdateRequest;
use App\Models\Nutricionista;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

// class RegistroconsultaController extends Controller
class RegistroconsultacompraController extends Controller
{
    public function index(Request $request)
    {
        // Se ADMINISTRADOR, visualiza todos os RESTAURANTES, e a partir destes, vai para o processo de COMPRA, caso contrário irá presquisar apenas
        // o(s) restaurante(s) da NUTRICIONISTA responsável(logada) no momento.
        // if(Auth::user()->perfil == 'adm' && Auth::user()->ativo == 1 ){
        if(Auth::user()->perfil == 'adm'){

            //Regionais para compor o campo select no index
            $regionais = Regional::orderBy('nome', 'ASC')->get();

            //$restaurantes = Restaurante::with(['municipio', 'bairro', 'empresa', 'nutricionista', 'user', 'compras'])->orderBy('identificacao', 'ASC')->get();
            $restaurantes = Restaurante::with(['municipio', 'bairro', 'empresa', 'nutricionista', 'user', 'compras'])->orderBy('identificacao', 'ASC')->get();

            // Verifica se uma regional foi escolhida para fazer a pesquisa através do relacionamento cruzado hasManyThrough
            // no model Regional, uma vez que restaurante não possui relacionamento com Regional e sim com município, do tipo:
            // Restaurante --< Municipio --< Restaurante (Regional possui Municipios que possui Restaurantes).

            if($request->regional_id) {

                //Se a opção escolhida for 100 (todos), não há a necessidade de fazer relacionamento cruzado, busca-se todos os restaurantes independente da regional
                if($request->regional_id == 100) {
                    $idRegional = $request->regional_id;
                    $restaurantes = Restaurante::with(['municipio', 'bairro', 'empresa', 'nutricionista', 'user', 'compras'])->orderBy('identificacao', 'ASC')->get();

                //Se uma regional for escolhida, busca-se a regional primerio, depois os restaurantes dos municípios pertencentes a esta regional, através do relacionamento cruzado
                } else {
                    $idRegional = $request->regional_id;
                    $regional = Regional::findOrFail($idRegional);
                    $restaurantes =  $regional->restaurantes;
                }

            } else {

                //Regional fixa (metropolitana)
                $idRegional = 1;
                $regional = Regional::findOrFail($idRegional);
                $restaurantes =  $regional->restaurantes;

            }


            return view('admin.registrocompra.index', compact('regionais', 'restaurantes', 'idRegional'));



        //elseif (Auth::user()->perfil == 'nut' && Auth::user()->ativo == 1 )
        } else {
            //Obs:  Se a regra de negócio mudar e a nutricionista da SEDES for responsável por mais de um restaurante, utilizar query com ->get() no final,
            //      como comentado abaixo, pois retorna uma collection.

            //      $restaurantes = Restaurante::with(['municipio', 'bairro', 'empresa', 'nutricionista', 'user', 'compras'])->where('user_id', '=', Auth::user()->id)->get();
            //      $compras = Compra::where('restaurante_id', '=', $restaurantes[0]['id'])->orderBy('data_ini', 'DESC')->get();
            //      return view('admin.compra.index', compact('restaurantes', 'compras'));
            //Obs:  Na view (admin.compra.index), para acessar a identificacao do restarurante dever-se-ia colocar:
            //      <strong>COMPRAS: Restaurante {{ $restaurantes[0]['identificacao'] }}</strong> OU
            //      <strong>COMPRAS: Restaurante {{ $restaurantes[0]->'identificacao' }}</strong>


            //Obs:  Como a nutricionista da SEDES é responsável por apenas um restaurante, utiliza-se a query com ->first(), pois retorna só um objeto
            //      $restaurante = Restaurante::where('user_id', '=', Auth::user()->id)->first(); OU a query abaixo
            $restaurante = Restaurante::with(['municipio', 'bairro', 'empresa', 'nutricionista', 'user', 'compras'])->where('user_id', '=', Auth::user()->id)->first();


            //Se nenhum restaurante estiver associado ao User logado, desló-ga-o do sistema
            if($restaurante == null) {
                return redirect()->route('acesso.logout');
            }

            $compras = Compra::where('restaurante_id', '=', $restaurante->id)->orderBy('data_ini', 'DESC')->get();


            return view('admin.compra.index', compact('restaurante', 'compras'));

        //else
        // return view('uma view informando que o usuário não está ativo embora esteja cadastrado no sitema')
        }

    }



    public function search()
    {
        // Meses e anos para popular campos selects
        $mesespesquisa = [
            '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
            '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
        ];

        $anospesquisa = [date("Y"), date("Y") - 1, date("Y") - 2];

        if(Auth::user()->perfil == 'adm') {


            $restaurantes =  Restaurante::select('id', 'identificacao')->orderBy('identificacao', 'ASC')->get();

            $municipios = Municipio::select('id', 'nome')->orderBy('nome', 'ASC')->get();

            return view('admin.registrocompra.menuconsultasadm', compact('mesespesquisa', 'anospesquisa', 'restaurantes', 'municipios'));

        } else {
            //Fazer um teste aqui, se o usuário logado está ativo (depois de incluir esse campo na tabela e no model User)
            //if( Auth::user()->ativo == 'sim') { fazer uma coisa } else { fazer outra coisa }

            //Recupera o restaurante do usuário-nutricionista logado. ->first(), porque um usuário é responsável por um único restaurante.
            $restaurante = Restaurante::where('user_id', '=', Auth::user()->id)->first();

            //Se nenhum restaurante estiver associado ao User logado, desló-ga-o do sistema
            if($restaurante == null) {
                return redirect()->route('acesso.logout');
            }

            return view('admin.registrocompra.consultasnut.formularioconsultanut', compact('restaurante', 'mesespesquisa', 'anospesquisa'));

        }
    }

    public function compramensalrestaurante(Request $request)
    {


        if($request->restaurante_id && $request->mes_id && $request->ano_id ) {
            $rest_id = $request->restaurante_id;
            $mes_id = $request->mes_id;
            $ano_id = $request->ano_id;


            // Meses e anos para popular campos selects
            $mesespesquisa = [
                '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
                '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
            ];
            $anospesquisa = [date("Y"), date("Y") - 1, date("Y") - 2];


            if(Auth::user()->perfil == 'adm') {
                //Abaixo, se usuário colocar id de restaurante que não existe diretamente na URL "quebra" a aplicacao
                //$restaurante = Restaurante::where('id', '=', $rest_id)->first();

                //Com findOrFail, evita a quebra, mesmo se o usuário colocar um ID de um restaurante que não exista
                //diretamente na URL, ançando-o para a página de error 404
                $restaurante = Restaurante::findOrFail($rest_id);
            } else {
                $restaurante = Restaurante::where('user_id', '=', Auth::user()->id)->first();
            }

            //Recupera só o id do restaurante
            $restauranteId =  $restaurante->id;

            $records = Bigtabledata::compramensal($restauranteId, $mes_id, $ano_id);

            if($records->count() > 0){

                // Criando um array para deposita todas as datas inicial e final das compras retornadas em "$records"
                $arrDatasIniFin = [];

                // Criando arrays para guardar produtos adquiridos em compra normal e compra pela agricultura familiar
                $compranormal = [];
                $compraaf = [];

                // Variáveis para calcular totais
                $somapreco = 0;
                $somaprecoaf = 0;
                $somafinal = 0;


                foreach($records as $datarecords) {
                    // populando array com datainicial e datafinal
                    $arrDatasIniFin[] = $datarecords->data_ini;
                    $arrDatasIniFin[] = $datarecords->data_fin;

                    // somatório preco normal e precoaf
                    // $somapreco += $datarecords->af == 'nao' ? $datarecords->precototal : 0;
                    // $somaprecoaf += $datarecords->af == 'sim' ? $datarecords->precototal : 0;


                    // Verifica se o registro atual é uma compra da AF ou não para popular os respectivos arrays
                    // bem como faz o somatório de seus respectivos preços. A separação em arrays é para serem
                    // exibidos na view separadamente.
                    if($datarecords->af == 'sim') {

                        $compraaf[] = $datarecords;
                        $somaprecoaf += $datarecords->precototal;

                    } else {

                        $compranormal[] = $datarecords;
                        $somapreco += $datarecords->precototal;
                    }
                }

                $somafinal += ($somaprecoaf + $somapreco);

                // Atribuindo a menor e a maior data (do array de datas "$arrDatasIniFin") para data inicial e data final
                $dataInicial =  min($arrDatasIniFin);
                $dataFinal = max($arrDatasIniFin);

                return view('admin.registrocompra.consultasnut.comprasmes', compact('mes_id', 'ano_id', 'restaurante', 'mesespesquisa', 'anospesquisa', 'records', 'compranormal', 'compraaf', 'dataInicial', 'dataFinal', 'somapreco', 'somaprecoaf', 'somafinal'));

            } else {

                $request->session()->flash('error_compramensalrestaurante', 'Nenhum registro encontrado para esta pesquisa.');
                return redirect()->route('admin.registroconsultacompra.search');

            }

        } else {

            return redirect()->route('admin.registroconsultacompra.search');
        }
    }



    public function producaorestmesano(Request $request)
    {
        if($request->restaurante_id && $request->mes_id && $request->ano_id ) {
            $rest_id = $request->restaurante_id;
            $mes_id = $request->mes_id;
            $ano_id = $request->ano_id;

            // Meses e anos para popular campos selects
            $mesespesquisa = [
                '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
                '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
            ];
            $anospesquisa = [date("Y"), date("Y") - 1, date("Y") - 2];

            // Monta mês/ano de pesquisa
            $mesano = $mesespesquisa[$mes_id]."/".$ano_id;


            /*
            // Recuperação de regitros pode ser feita a partir daqui ou no model Bigtabledata
            $records = Bigtabledata::groupBy('produto_nome', 'medida_simbolo')
            ->selectRaw('regional_nome, municipio_nome, identificacao, produto_id, produto_nome, medida_simbolo, avg(preco) as mediapreco, sum(precototal) as somaprecototal, sum(quantidade) as somaquantidade')
            ->orderBy('produto_nome', 'ASC')
            ->orderBy('medida_simbolo', 'ASC')
            ->where('restaurante_id', '=', $rest_id)
            ->whereMonth('data_ini', '=', $mes_id)
            ->whereYear('data_ini', '=', $ano_id)
            ->get();
            */

            $records = Bigtabledata::producaorestaurantemesano($rest_id, $mes_id, $ano_id);

            if($records->count() <= 0) {

                $request->session()->flash('error_prodrestmesano', 'Nenhum registro encontrado para esta pesquisa.');
                return redirect()->route('admin.registroconsultacompra.search');

            } else {

                return view('admin.registrocompra.consultasadm.producaorestaurantemesano', compact('records', 'mesano'));
            }


        } else {

            return redirect()->route('admin.registroconsultacompra.search');
        }

    }


    public function compramensalmunicipioagrupado(Request $request)
    {
        if($request->municipio_id && $request->mes_id && $request->ano_id ) {
            $muni_id = $request->municipio_id;
            $mes_id = $request->mes_id;
            $ano_id = $request->ano_id;

            // Meses e anos para popular campos selects
            $mesespesquisa = [
                '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
                '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
            ];
            $anospesquisa = [date("Y"), date("Y") - 1, date("Y") - 2];

            // Monta mês/ano de pesquisa
            $mesano = $mesespesquisa[$mes_id]."/".$ano_id;

            $records = Bigtabledata::compramensalmunicipioagrupado($muni_id, $mes_id, $ano_id);


            if($records->count() <= 0) {

                $request->session()->flash('error_compramensalmunicipioagrupado', 'Nenhum registro encontrado para esta pesquisa.');
                return redirect()->route('admin.registroconsultacompra.search');

            } else {

                return view('admin.registrocompra.consultasadm.compramensalmunicipioagrupado', compact('records', 'mesano', 'muni_id', 'mes_id', 'ano_id'));
            }


        } else {

            return redirect()->route('admin.registroconsultacompra.search');
        }

    }



    public function compramensalmunicipio(Request $request)
    {
        if($request->municipio_id && $request->mes_id && $request->ano_id ) {
            $muni_id = $request->municipio_id;
            $mes_id = $request->mes_id;
            $ano_id = $request->ano_id;

            // Meses e anos para popular campos selects
            $mesespesquisa = [
                '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
                '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
            ];
            $anospesquisa = [date("Y"), date("Y") - 1, date("Y") - 2];

            // Monta mês/ano de pesquisa
            $mesano = $mesespesquisa[$mes_id]."/".$ano_id;

            $records = Bigtabledata::compramensalmunicipio($muni_id, $mes_id, $ano_id);

            if($records->count() <= 0) {

                $request->session()->flash('error_compramensalmunicipio', 'Nenhum registro encontrado para esta pesquisa.');
                return redirect()->route('admin.registroconsultacompra.search');

            } else {

                return view('admin.registrocompra.consultasadm.compramensalmunicipio', compact('records', 'mesano', 'muni_id', 'mes_id', 'ano_id'));
            }


        } else {

            return redirect()->route('admin.registroconsultacompra.search');
        }

    }


    //================================================================================
    // Método invocado pelo AJAX para Preecher modal detalhes da compra do restaurante
    //================================================================================
    public function ajaxgetdetalhecompra(Request $request)
    {

        /* $id = $request->municipio_id;
        $data['qtd_bairros'] = DB::table('bairros')->where('municipio_id', '=', $id)->count();
        return response()->json($data); */



        if($request->restaurante && $request->mes && $request->ano ) {
            $rest_id = $request->restaurante;
            $mes_id = $request->mes;
            $ano_id = $request->ano;

            // Meses e anos para formatar perído da pesquisa
            $mesespesquisa = [
                '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
                '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
            ];
            $anospesquisa = [date("Y"), date("Y") - 1, date("Y") - 2];

            //montando mes/ano
            $meseano = $mesespesquisa[$mes_id]. "/".$ano_id;


            if(Auth::user()->perfil == 'adm') {
                $restaurante = Restaurante::findOrFail($rest_id);
            } else {
                $restaurante = Restaurante::where('user_id', '=', Auth::user()->id)->first();
            }

            //Recupera só o id do restaurante
            $restauranteId =  $restaurante->id;

            $records = Bigtabledata::compramensal($restauranteId, $mes_id, $ano_id);

            if($records->count() > 0){

                // Criando um array para deposita todas as datas inicial e final das compras retornadas em "$records"
                $arrDatasIniFin = [];

                // Criando arrays para guardar produtos adquiridos em compra normal e compra pela agricultura familiar
                $compranormal = [];
                $compraaf = [];

                // Variáveis para calcular totais
                $somapreconormal = 0;
                $somaprecoaf = 0;
                $somaprecofinal = 0;


                foreach($records as $datarecords) {
                    // populando array com datainicial e datafinal
                    $arrDatasIniFin[] = $datarecords->data_ini;
                    $arrDatasIniFin[] = $datarecords->data_fin;

                    if($datarecords->af == 'sim') {

                        $compraaf[] = $datarecords;
                        $somaprecoaf += $datarecords->precototal;

                    } else {

                        $compranormal[] = $datarecords;
                        $somapreconormal += $datarecords->precototal;
                    }
                }

                $somaprecofinal += ($somaprecoaf + $somapreconormal);

                $dataInicial =  min($arrDatasIniFin);
                $dataFinal = max($arrDatasIniFin);

                // retornando os dados para a requisição AJAX
                $data['numregs'] = $records->count();
                $data['records'] = $records;

                $data['numregscompraaf']        = count($compraaf);
                $data['numregscompranormal']    = count($compranormal);

                $data['regional']               = $records[0]->regional_nome;
                $data['municipio']              = $records[0]->municipio_nome;
                $data['identificacao']          = $records[0]->identificacao;
                $data['nutricionistaempresa']   = $records[0]->nutricionista_nomecompleto;
                $data['nutricionistasedes']     = $records[0]->user_nomecompleto;
                $data['mesano']                 = $meseano;

                $data['compraaf']               = $compraaf;
                $data['somaprecoaf']            = mrc_turn_value($somaprecoaf);

                $data['compranormal']           = $compranormal;
                $data['somapreconormal']        = mrc_turn_value($somapreconormal);

                $data['somaprecofinal']         = mrc_turn_value($somaprecofinal);

                $data['porcentagemaf']          = intval(mrc_calc_percentaf($somaprecofinal, $somaprecoaf));

                $data['datainicial']            = mrc_turn_data($dataInicial);
                $data['datafinal']              = mrc_turn_data($dataFinal);


                return response()->json($data);


                //return view('admin.registrocompra.consultasnut.comprasmes', compact('mes_id', 'ano_id', 'restaurante', 'mesespesquisa', 'anospesquisa', 'records', 'compranormal', 'compraaf', 'dataInicial', 'dataFinal', 'somapreco', 'somaprecoaf', 'somafinal'));

            } else {

                $request->session()->flash('error_compramensalrestaurante', 'Nenhum registro encontrado para esta pesquisa.');
                return redirect()->route('admin.registroconsultacompra.search');

            }

        } else {

            return redirect()->route('admin.registroconsultacompra.search');
        }
    }



    /***************************************/
    /*    RELATÓRIOS PDF's, Excel e CSV    */
    /***************************************/

    public function relpdfcomprasmes($rest, $mes, $ano)
    {
        // Meses para compor cabeçalho do relatório
        $meses = [
            '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
            '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
        ];

        $restaurante = Restaurante::findOrFail($rest);

        $restauranteId = $restaurante->id;

        // Obtendo os dados
        $records = Bigtabledata::comprasMes($restauranteId, $mes, $ano);

        // Criando um array para deposita todas as datas inicial e final das compras retornadas em "$records"
        $arrDatasIniFin = [];

        // Criando arrays para guardar produtos adquiridos em compra normal e compra pela agricultura familiar
        $compranormal = [];
        $compraaf = [];

        // Variáveis para calcular totais
        $somapreco = 0;
        $somaprecoaf = 0;
        $somafinal = 0;

        foreach($records as $datarecords) {
            // populando array com datainicial e datafinal
            $arrDatasIniFin[] = $datarecords->data_ini;
            $arrDatasIniFin[] = $datarecords->data_fin;

            if($datarecords->af == 'sim') {

                $compraaf[] = $datarecords;
                $somaprecoaf += $datarecords->precototal;

            } else {

                $compranormal[] = $datarecords;
                $somapreco += $datarecords->precototal;
            }
        }

        $somafinal += ($somaprecoaf + $somapreco);

        // Atribuindo a menor e a maior data (do array de datas "$arrDatasIniFin") para data inicial e data final
        $dataInicial =  min($arrDatasIniFin);
        $dataFinal = max($arrDatasIniFin);

        //dd($records);


        // Definindo o nome do arquivo a ser baixado
        $fileName = ('compras_mes10'.'.pdf');

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
                        '.$records[0]->identificacao.' <br> compras ref.: '.$meses[$mes].'/'.$ano.'
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
                    <td style="width: 417px;" class="dados-ficha">'.$records[0]->municipio_nome.' ('.$records[0]->regional_nome.')</td>
                    <td style="width: 100px;" class="dados-ficha">todas do mes</td>
                    <td style="width: 100px;" class="dados-ficha">'.mrc_turn_data($dataInicial).'</td>
                    <td style="width: 100px;" class="dados-ficha">'.mrc_turn_data($dataFinal).'</td>
                </tr>
            </table>

            <table style="width:717px; border-collapse: collapse;">
                <tr>
                    <td style="width: 417px;" class="label-ficha">Restaurante</td>
                    <td style="width: 100px;" class="label-ficha">Valor</td>
                    <td style="width: 100px;" class="label-ficha">Valor AF ('.intval(mrc_calc_percentaf($somafinal, $somaprecoaf )).'%)</td>
                    <td style="width: 100px;" class="label-ficha">Valor Total</td>
                </tr>
                <tr>
                    <td style="width: 417px;" class="dados-ficha">'.$records[0]->identificacao.'</td>
                    <td style="width: 100px; text-align:right" class="dados-ficha">'.mrc_turn_value($somapreco).' </td>
                    <td style="width: 100px; text-align:right" class="dados-ficha">'.mrc_turn_value($somaprecoaf).' </td>
                    <td style="width: 100px; text-align:right" class="dados-ficha">'.mrc_turn_value($somafinal).' </td>
                </tr>
            </table>

            <table style="width:717px; border-collapse: collapse;">
                <tr>
                    <td style="width: 417px;" class="label-ficha">Nutricionista Empresa</td>
                    <td style="width: 300px;" class="label-ficha">Nutricionista SEDES</td>
                </tr>
                <tr>
                    <td style="width: 417px;" class="dados-ficha">'.$records[0]->nutricionista_nomecompleto.'</td>
                    <td style="width: 300px;" class="dados-ficha">'.$records[0]->user_nomecompleto.'</td>
                </tr>
                <tr>
                    <td colspan="2" style="width:717px;" class="close-ficha"></td>
                </tr>
            </table>

            <table style="width:717px; border-collapse: collapse">
                <tr>
                    <td width="30px" class="col-header-table" style="text-align:center">Id</td>
                    <td width="200px" class="col-header-table" style="text-align:center">Produto</td>
                    <td width="200px" class="col-header-table" style="text-align:center">Detalhe</td>
                    <td width="35px" class="col-header-table" style="text-align:center">AF</td>
                    <td width="50px" class="col-header-table" style="text-align:center">Quant.</td>
                    <td width="50px" class="col-header-table" style="text-align:center">Unid.</td>
                    <td width="72px" class="col-header-table" style="text-align:center">Preço</td>
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


        // Definindo a view que deverá ser renderizada como arquivo .pdf e passando os dados da pesquisa
        $html = \View::make('admin.registrocompra.pdf.pdfcomprasmes', compact('records', 'compranormal', 'compraaf', 'somapreco', 'somaprecoaf', 'somafinal'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.produto.pdf.pdfproduto')
        $stylesheet = file_get_contents('pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }


    // Relatório PDF Compra mensal por município
    public function relpdfcompramensalmunicipio($muni, $mes, $ano)
    {
        // Meses para compor cabeçalho do relatório
        $meses = [
            '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
            '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
        ];

        $municipio = Municipio::findOrFail($muni);

        $municipioId = $municipio->id;

        // Obtendo os dados
        $records = Bigtabledata::compramensalmunicipio($municipioId, $mes, $ano);

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('compramensalmunicipio'.'.pdf');

        // Invocando a biblioteca mpdf e definindo as margens do arquivo
        $mpdf = new \Mpdf\Mpdf([
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 40,
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
                        COMPRA MENSAL <br>'.$records[0]->municipio_nome.': '.$meses[$mes].'/'.$ano.'
                    </td>
                </tr>
            </table>
            <table style="width:717px; border-collapse: collapse;">
                <tr>
                    <td style="width: 717px;" class="label-ficha">Região - Município</td>
                </tr>
                <tr>
                    <td style="width: 717px;" class="dados-ficha">'.$records[0]->regional_nome.' - '.$records[0]->municipio_nome.'</td>
                </tr>
            </table>

            <table style="width:717px; border-collapse: collapse">
                <tr>
                    <td width="30px" class="col-header-table" style="text-align:center">Id</td>
                    <td width="200px" class="col-header-table" style="text-align:center">Produto</td>
                    <td width="235px" class="col-header-table" style="text-align:center">Nº de ocorrências no mês</td>
                    <td width="50px" class="col-header-table" style="text-align:center">Quant.</td>
                    <td width="50px" class="col-header-table" style="text-align:center">Unid.</td>
                    <td width="72px" class="col-header-table" style="text-align:center">Preço Médio</td>
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


        // Definindo a view que deverá ser renderizada como arquivo .pdf e passando os dados da pesquisa
        $html = \View::make('admin.registrocompra.pdf.pdfcompramensalmunicipio', compact('records'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.produto.pdf.pdfproduto')
        $stylesheet = file_get_contents('pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }


}
