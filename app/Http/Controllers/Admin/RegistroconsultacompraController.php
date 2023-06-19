<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Regional;
use App\Models\Restaurante;
use App\Models\Compra;
use App\Models\Municipio;
use App\Models\Produto;
use App\Models\Categoria;
use App\Models\Bigtabledata;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

// class RegistroconsultaController extends Controller
class RegistroconsultacompraController extends Controller
{
    public function index(Request $request)
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

        // Se ADMINISTRADOR, visualiza todos os RESTAURANTES, e a partir destes, vai para o processo de COMPRA, caso contrário irá presquisar apenas
        // o(s) restaurante(s) da NUTRICIONISTA responsável(logada) no momento.
        // if(Auth::user()->perfil == 'adm' && Auth::user()->ativo == 1 ){
        if(Auth::user()->perfil == 'adm'){

            //Regionais para compor o campo select no index
            $regionais = Regional::orderBy('nome', 'ASC')->get();

            //$restaurantes = Restaurante::with(['municipio', 'bairro', 'empresa', 'nutricionista', 'user', 'compras'])->orderBy('identificacao', 'ASC')->get();
            //Obs: aqui era para recuperar apenas os restaurantes da regional cujo id seja igual a 1 (Metropolitana / Grande Ilha de São Luis), mas restaurantes, não possui um vínculo direto com
            //     regionais e sim com municípios.
            //-----$restaurantes = Restaurante::with(['municipio', 'bairro', 'empresa', 'nutricionista', 'user', 'compras'])->orderBy('identificacao', 'ASC')->get();

            // Verifica se uma regional foi escolhida para fazer a pesquisa através do relacionamento cruzado hasManyThrough
            // no model Regional, uma vez que restaurante não possui relacionamento com Regional e sim com município, do tipo:
            // Restaurante --< Municipio --< Restaurante (Regional possui Municipios que possui Restaurantes).

            if($request->regional_id) {

                //Se a opção escolhida for 100 (todos), não há a necessidade de fazer relacionamento cruzado, busca-se todos os restaurantes independente da regional
                if($request->regional_id == 100) {
                    $idRegional = $request->regional_id;
                    $restaurantes = Restaurante::with(['municipio', 'bairro', 'empresa', 'nutricionista', 'user', 'compras'])->orderBy('identificacao', 'ASC')->get();

                //Se uma regional for escolhida, busca-se a regional primerio, depois os restaurantes dos municípios pertencentes a esta regional, através do relacionamento cruzado hasManyThrough
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

            //dd(Auth::user()->id);

            //Se nenhum restaurante estiver associado ao User logado, desló-ga-o do sistema
            //Se nenhum restaurante estiver associado ao User (nutricionista) logado desló-ga-o do sistema e o redireciona para a tela de login.
            if($restaurante == null) {
                //return redirect()->route('acesso.logout');  Linha original

                // Apresentar mensagem caso o usuário não esteja vinculado a um restaurante
                Auth::logout();
                return redirect()->back()->withInput()->withErrors(['Sem restaurante vinculado!']);
            }

            // Recupera todas as compras do restaurante
            //$compras = Compra::where('restaurante_id', '=', $restaurante->id)->orderBy('data_ini', 'DESC')->get();

            // Recupera as compras do restaurante limitando a 30 o número de registros
            //$compras = Compra::where('restaurante_id', '=', $restaurante->id)->limit(30)->orderBy('data_ini', 'DESC')->get();

            // Recupera só as compras realizadas nos últimos 3 mêses (3 months) ou 90 dias (90 days) ou 1 ano (1 year) atrás, conforme a necessidade
            $dataAtual = date("Y-m-d");             // obtém a data atual
            $dataAtual =  date_create($dataAtual);  // cria uma data a partir da data atual
            $dataRetroativa = date_sub($dataAtual, date_interval_create_from_date_string("3 months"));  // subtrai da dataATual do tempo necessário

            $compras = Compra::with('comprovantes')->where('restaurante_id', '=', $restaurante->id)->where('data_ini', '>=', $dataRetroativa)->orderBy('data_ini', 'DESC')->get();


            return view('admin.compra.index', compact('restaurante', 'compras', 'mesespesquisa', 'anospesquisa'));

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

        //$anospesquisa = [date("Y"), date("Y") - 1, date("Y") - 2];

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


        if(Auth::user()->perfil == 'adm') {


            $restaurantes =  Restaurante::select('id', 'identificacao')->orderBy('identificacao', 'ASC')->get();

            $municipios = Municipio::select('id', 'nome')->orderBy('nome', 'ASC')->get();

            $regioes = Regional::select('id', 'nome')->orderBy('nome', 'ASC')->get();

            $produtos = Produto::select('id', 'nome')->orderBY('nome', 'ASC')->get();

            $categorias = Categoria::select('id', 'nome')->orderBy('nome', 'ASC')->get();

            return view('admin.registrocompra.menuconsultasadm', compact('mesespesquisa', 'anospesquisa', 'restaurantes', 'municipios', 'regioes', 'produtos', 'categorias'));

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

    public function comprasemanalmensalrestaurante(Request $request)
    {


        if($request->restaurante_id && $request->mes_id && $request->ano_id ) {
            $rest_id = $request->restaurante_id;
            $sema_id = $request->semana;
            $mes_id = $request->mes_id;
            $ano_id = $request->ano_id;

            // No caso do usuário digitar uma semana ou mês inválidos diretamente na URL
            if((($sema_id != null) && (($sema_id < 1) || ($sema_id > 5))) || (($mes_id != null) && (($mes_id < 1) || ($mes_id > 12)))){
                return redirect()->route('acesso.logout');
            }

            // Semanas pesquisa
            $semanaspesquisa = ['1' => 'um', '2' => 'dois', '3' => 'três', '4' => 'quatro', '5' => 'cinco'];

            // Meses e anos para popular campos selects
            $mesespesquisa = [
                '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
                '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
            ];


            //$anospesquisa = [date("Y"), date("Y") - 1, date("Y") - 2];

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

            //Se o número da semana foi informado busca compras pela semana, caso contrário busca compras do mês inteiro (produção mensal)
            if($sema_id != ''){
                $descsemana = $semanaspesquisa[$sema_id];
                $descmesano = $mesespesquisa[$mes_id];
                $records = Bigtabledata::comprasemanal($restauranteId, $sema_id, $mes_id, $ano_id);
            }else {
                $descsemana = '';
                $descmesano = $mesespesquisa[$mes_id];
                $records = Bigtabledata::compramensal($restauranteId, $mes_id, $ano_id);
            }


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

                return view('admin.registrocompra.consultasnut.comprassemanames', compact('descsemana', 'descmesano', 'sema_id', 'mes_id', 'ano_id', 'restaurante', 'mesespesquisa', 'anospesquisa', 'records', 'compranormal', 'compraaf', 'dataInicial', 'dataFinal', 'somapreco', 'somaprecoaf', 'somafinal'));

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

            // Protege inserção de mês inexistente
            if($mes_id < 1 || $mes_id > 12) {
                return redirect()->route('acesso.logout');
            }

            // Meses e anos para popular campos selects
            $mesespesquisa = [
                '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
                '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro',
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

                return view('admin.registrocompra.consultasadm.producaorestaurantemesano', compact('records', 'mesano', 'rest_id', 'mes_id', 'ano_id'));
            }


        } else {

            return redirect()->route('admin.registroconsultacompra.search');
        }

    }


    public function compramensalmunicipiovalor(Request $request)
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

            // Protege inserção de mês inexistente
            if($mes_id < 1 || $mes_id > 12) {
                return redirect()->route('acesso.logout');
            }

            // Monta mês/ano de pesquisa
            $mesano = $mesespesquisa[$mes_id]."/".$ano_id;

            $records = Bigtabledata::compramensalmunicipiovalor($muni_id, $mes_id, $ano_id);


            if($records->count() <= 0) {

                $request->session()->flash('error_compramensalmunicipiovalor', 'Nenhum registro encontrado para esta pesquisa.');
                return redirect()->route('admin.registroconsultacompra.search');

            } else {

                return view('admin.registrocompra.consultasadm.compramensalmunicipiovalor', compact('records', 'mesano', 'muni_id', 'mes_id', 'ano_id'));
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

            // Protege inserção de mês inexistente
            if($mes_id < 1 || $mes_id > 12) {
                return redirect()->route('acesso.logout');
            }

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




    public function compramensalregionalproduto(Request $request)
    {
        if($request->regional_id && $request->mes_id && $request->ano_id ) {
            $regi_id = $request->regional_id;
            $mes_id = $request->mes_id;
            $ano_id = $request->ano_id;

            // Meses e anos para popular campos selects
            $mesespesquisa = [
                '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
                '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
            ];
            $anospesquisa = [date("Y"), date("Y") - 1, date("Y") - 2];

            // Protege inserção de mês inexistente
            if($mes_id < 1 || $mes_id > 12) {
                return redirect()->route('acesso.logout');
            }

            // Monta mês/ano de pesquisa
            $mesano = $mesespesquisa[$mes_id]."/".$ano_id;

            $records = Bigtabledata::compramensalregionalproduto($regi_id, $mes_id, $ano_id);

            if($records->count() <= 0) {

                $request->session()->flash('error_compramensalregionalproduto', 'Nenhum registro encontrado para esta pesquisa.');
                return redirect()->route('admin.registroconsultacompra.search');

            } else {

                return view('admin.registrocompra.consultasadm.compramensalregionalproduto', compact('records', 'mesano', 'regi_id', 'mes_id', 'ano_id'));
            }


        } else {

            return redirect()->route('admin.registroconsultacompra.search');
        }

    }



    public function compramensalregiaovalor(Request $request)
    {
        if($request->regiao_id && $request->mes_id && $request->ano_id ) {
            $reg_id = $request->regiao_id;
            $mes_id = $request->mes_id;
            $ano_id = $request->ano_id;

            // Meses e anos para popular campos selects
            $mesespesquisa = [
                '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
                '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
            ];
            $anospesquisa = [date("Y"), date("Y") - 1, date("Y") - 2];

            // Protege inserção de mês inexistente
            if($mes_id < 1 || $mes_id > 12) {
                return redirect()->route('acesso.logout');
            }

            // Monta mês/ano de pesquisa
            $mesano = $mesespesquisa[$mes_id]."/".$ano_id;

            $records = Bigtabledata::compramensalregiaovalor($reg_id, $mes_id, $ano_id);


            if($records->count() <= 0) {

                $request->session()->flash('error_compramensalregiaovalor', 'Nenhum registro encontrado para esta pesquisa.');
                return redirect()->route('admin.registroconsultacompra.search');

            } else {

                return view('admin.registrocompra.consultasadm.compramensalregiaovalor', compact('records', 'mesano', 'reg_id', 'mes_id', 'ano_id'));
            }


        } else {

            return redirect()->route('admin.registroconsultacompra.search');
        }

    }


    //========================================
    // MAPAS DE PRODUTOS MES/ANO
    //========================================
    // Mapa mensal produto restaurante
    public function mapamensalprodutorestaurante(Request $request)
    {
        if($request->restaurante_id && $request->mes_id && $request->ano_id ) {
            $rest_id = $request->restaurante_id;
            $mes_id = $request->mes_id;
            $ano_id = $request->ano_id;

            // Meses e anos para formatar perído da pesquisa
            $mesespesquisa = [
                '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
                '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
            ];
            $anospesquisa = [date("Y"), date("Y") - 1, date("Y") - 2];

            // Protege inserção de mês inexistente
            if($mes_id < 1 || $mes_id > 12) {
                return redirect()->route('acesso.logout');
            }

            //montando mes/ano
            $mesano = $mesespesquisa[$mes_id]. "/".$ano_id;

            $restaurante = Restaurante::findOrFail($rest_id);

            //Recupera só o id do restaurante
            $restauranteId =  $restaurante->id;

            $records = Bigtabledata::mapamensalprodutorestaurante($restauranteId, $mes_id, $ano_id);

            //die($records);

            if($records->count() <= 0){

                $request->session()->flash('error_mapamensalprodutorestaurante', 'Nenhum registro encontrado para esta pesquisa.');
                //return redirect()->route('admin.registroconsultacompra.search');

                //Redirecionamento com âncora
                return redirect()->to(route('admin.registroconsultacompra.search').'#anchor-sete');

            } else {

                return view('admin.registrocompra.consultasadm.mapamensalprodutorestaurante', compact('rest_id', 'mes_id', 'ano_id', 'restaurante', 'mesano', 'records'));

            }

        } else {

            return redirect()->route('admin.registroconsultacompra.search');
        }
    }



    // Mapa mensal produto municpio
    public function mapamensalprodutomunicipio(Request $request)
    {
        if($request->municipio_id && $request->mes_id && $request->ano_id ) {
            $muni_id = $request->municipio_id;
            $mes_id = $request->mes_id;
            $ano_id = $request->ano_id;

            // Meses e anos para formatar perído da pesquisa
            $mesespesquisa = [
                '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
                '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
            ];
            $anospesquisa = [date("Y"), date("Y") - 1, date("Y") - 2];

            // Protege inserção de mês inexistente
            if($mes_id < 1 || $mes_id > 12) {
                return redirect()->route('acesso.logout');
            }

            //montando mes/ano
            $mesano = $mesespesquisa[$mes_id]. "/".$ano_id;

            $municipio = Municipio::findOrFail($muni_id);

            //Recupera só o id do municipio
            $municipioId =  $municipio->id;

            $records = Bigtabledata::mapamensalprodutomunicipio($municipioId, $mes_id, $ano_id);

            //die($records);

            if($records->count() <= 0){

                $request->session()->flash('error_mapamensalprodutomunicipio', 'Nenhum registro encontrado para esta pesquisa.');
                //return redirect()->route('admin.registroconsultacompra.search');

                //Redirecionamento com âncora
                return redirect()->to(route('admin.registroconsultacompra.search').'#anchor-oito');


            } else {

                return view('admin.registrocompra.consultasadm.mapamensalprodutomunicipio', compact('muni_id', 'mes_id', 'ano_id', 'municipio', 'mesano', 'records'));

            }

        } else {

            return redirect()->route('admin.registroconsultacompra.search');
        }
    }




    // Mapa mensal produto regional
    public function mapamensalprodutoregional(Request $request)
    {
        if($request->regional_id && $request->mes_id && $request->ano_id ) {
            $regi_id = $request->regional_id;
            $mes_id = $request->mes_id;
            $ano_id = $request->ano_id;

            // Meses e anos para formatar perído da pesquisa
            $mesespesquisa = [
                '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
                '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
            ];
            $anospesquisa = [date("Y"), date("Y") - 1, date("Y") - 2];

            // Protege inserção de mês inexistente
            if($mes_id < 1 || $mes_id > 12) {
                return redirect()->route('acesso.logout');
            }

            //montando mes/ano
            $mesano = $mesespesquisa[$mes_id]. "/".$ano_id;

            $regional = Regional::findOrFail($regi_id);

            //Recupera só o id do regional
            $regionalId =  $regional->id;

            $records = Bigtabledata::mapamensalprodutoregional($regionalId, $mes_id, $ano_id);

            //die($records);

            if($records->count() <= 0){

                $request->session()->flash('error_mapamensalprodutoregional', 'Nenhum registro encontrado para esta pesquisa.');
                //return redirect()->route('admin.registroconsultacompra.search');

                //Redirecionamento com âncora
                return redirect()->to(route('admin.registroconsultacompra.search').'#anchor-nove');


            } else {

                return view('admin.registrocompra.consultasadm.mapamensalprodutoregional', compact('regi_id', 'mes_id', 'ano_id', 'regional', 'mesano', 'records'));

            }

        } else {

            return redirect()->route('admin.registroconsultacompra.search');
        }
    }




    // Mapa mensal geral produto
    public function mapamensalgeralproduto(Request $request)
    {
        if($request->mes_id && $request->ano_id ) {
            $mes_id = $request->mes_id;
            $ano_id = $request->ano_id;

            // Meses e anos para formatar perído da pesquisa
            $mesespesquisa = [
                '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
                '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
            ];
            $anospesquisa = [date("Y"), date("Y") - 1, date("Y") - 2];

            // Protege inserção de mês inexistente
            if($mes_id < 1 || $mes_id > 12) {
                return redirect()->route('acesso.logout');
            }

            //montando mes/ano
            $mesano = $mesespesquisa[$mes_id]. "/".$ano_id;


            $records = Bigtabledata::mapamensalgeralproduto($mes_id, $ano_id);

            //Crio uma coleção
            $regionaisnome = collect();

            foreach($records as $record) {
                //Adiciona à coleção criada, apenas o nome das regionais, duplicadas ou não
                $regionaisnome->push($record->regional_nome);
            }

            //Recupero o nome das regionais de forma única em uma outra collection
            $regionaisenvolvidas = $regionaisnome->unique();

            //Junto os elementos da colection como uma string ligadas por uma vírgula, pelo método ->join();
            $regionais = $regionaisenvolvidas->join(', ');


            if($records->count() <= 0){

                $request->session()->flash('error_mapamensalgeralproduto', 'Nenhum registro encontrado para esta pesquisa.');

                //Redirecionamento com âncora
                return redirect()->to(route('admin.registroconsultacompra.search').'#anchor-onze');

            } else {

                return view('admin.registrocompra.consultasadm.mapamensalgeralproduto', compact('mes_id', 'ano_id', 'mesano', 'records', 'regionais'));

            }

        } else {

            return redirect()->route('admin.registroconsultacompra.search');
        }
    }


    //========================================
    // MAPAS DE CATEGORIAS MÊS/ANO
    //========================================
    // Mapa mensal categoria restaurante
    public function mapamensalcategoriarestaurante(Request $request)
    {
        if($request->restaurante_id && $request->mes_id && $request->ano_id ) {
            $rest_id = $request->restaurante_id;
            $mes_id = $request->mes_id;
            $ano_id = $request->ano_id;

            // Meses e anos para formatar perído da pesquisa
            $mesespesquisa = [
                '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
                '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
            ];
            $anospesquisa = [date("Y"), date("Y") - 1, date("Y") - 2];

            // Protege inserção de mês inexistente
            if($mes_id < 1 || $mes_id > 12) {
                return redirect()->route('acesso.logout');
            }

            //montando mes/ano
            $mesano = $mesespesquisa[$mes_id]. "/".$ano_id;

            $restaurante = Restaurante::findOrFail($rest_id);

            //Recupera só o id do restaurante
            $restauranteId =  $restaurante->id;

            $records = Bigtabledata::mapamensalcategoriarestaurante($restauranteId, $mes_id, $ano_id);

            //die($records);

            if($records->count() <= 0){

                $request->session()->flash('error_mapamensalcategoriarestaurante', 'Nenhum registro encontrado para esta pesquisa.');

                //Redirecionamento com âncora
                return redirect()->to(route('admin.registroconsultacompra.search').'#anchor-onze');

            } else {

                return view('admin.registrocompra.consultasadm.mapamensalcategoriarestaurante', compact('rest_id', 'mes_id', 'ano_id', 'restaurante', 'mesano', 'records'));

            }

        } else {

            return redirect()->route('admin.registroconsultacompra.search');
        }
    }





    // Mapa mensal categoria municpio
    public function mapamensalcategoriamunicipio(Request $request)
    {
        if($request->municipio_id && $request->mes_id && $request->ano_id ) {
            $muni_id = $request->municipio_id;
            $mes_id = $request->mes_id;
            $ano_id = $request->ano_id;

            // Meses e anos para formatar perído da pesquisa
            $mesespesquisa = [
                '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
                '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
            ];
            $anospesquisa = [date("Y"), date("Y") - 1, date("Y") - 2];


            // Protege inserção de mês inexistente
            if($mes_id < 1 || $mes_id > 12) {
                return redirect()->route('acesso.logout');
            }


            //montando mes/ano
            $mesano = $mesespesquisa[$mes_id]. "/".$ano_id;

            $municipio = Municipio::findOrFail($muni_id);

            //Recupera só o id do municipio
            $municipioId =  $municipio->id;

            $records = Bigtabledata::mapamensalcategoriamunicipio($municipioId, $mes_id, $ano_id);

            //die($records);

            if($records->count() <= 0){

                $request->session()->flash('error_mapamensalcategoriamunicipio', 'Nenhum registro encontrado para esta pesquisa.');
                //return redirect()->route('admin.registroconsultacompra.search');

                //Redirecionamento com âncora
                return redirect()->to(route('admin.registroconsultacompra.search').'#anchor-doze');


            } else {

                return view('admin.registrocompra.consultasadm.mapamensalcategoriamunicipio', compact('muni_id', 'mes_id', 'ano_id', 'municipio', 'mesano', 'records'));

            }

        } else {

            return redirect()->route('admin.registroconsultacompra.search');
        }
    }




    // Mapa mensal categoria regional
    public function mapamensalcategoriaregional(Request $request)
    {
        if($request->regional_id && $request->mes_id && $request->ano_id ) {
            $regi_id = $request->regional_id;
            $mes_id = $request->mes_id;
            $ano_id = $request->ano_id;

            // Meses e anos para formatar perído da pesquisa
            $mesespesquisa = [
                '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
                '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
            ];
            $anospesquisa = [date("Y"), date("Y") - 1, date("Y") - 2];

            // Protege inserção de mês inexistente
            if($mes_id < 1 || $mes_id > 12) {
                return redirect()->route('acesso.logout');
            }

            //montando mes/ano
            $mesano = $mesespesquisa[$mes_id]. "/".$ano_id;

            $regional = Regional::findOrFail($regi_id);

            //Recupera só o id do regional
            $regionalId =  $regional->id;

            $records = Bigtabledata::mapamensalcategoriaregional($regionalId, $mes_id, $ano_id);

            //die($records);

            if($records->count() <= 0){

                $request->session()->flash('error_mapamensalcategoriaregional', 'Nenhum registro encontrado para esta pesquisa.');
                //return redirect()->route('admin.registroconsultacompra.search');

                //Redirecionamento com âncora
                return redirect()->to(route('admin.registroconsultacompra.search').'#anchor-treze');


            } else {

                return view('admin.registrocompra.consultasadm.mapamensalcategoriaregional', compact('regi_id', 'mes_id', 'ano_id', 'regional', 'mesano', 'records'));

            }

        } else {

            return redirect()->route('admin.registroconsultacompra.search');
        }
    }



    // Mapa mensal geral categoria
    public function mapamensalgeralcategoria(Request $request)
    {
        if($request->mes_id && $request->ano_id ) {
            $mes_id = $request->mes_id;
            $ano_id = $request->ano_id;

            // Meses e anos para formatar perído da pesquisa
            $mesespesquisa = [
                '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
                '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
            ];
            //$anospesquisa = [date("Y"), date("Y") - 1, date("Y") - 2];

            // Protege inserção de mês inexistente
            if($mes_id < 1 || $mes_id > 12) {
                return redirect()->route('acesso.logout');
            }

            //montando mes/ano
            $mesano = $mesespesquisa[$mes_id]. "/".$ano_id;


            $records = Bigtabledata::mapamensalgeralcategoria($mes_id, $ano_id);

            //Crio uma coleção
            $regionaisnome = collect();

            foreach($records as $record) {
                //Adiciona à coleção criada, apenas o nome das regionais, duplicadas ou não
                $regionaisnome->push($record->regional_nome);
            }

            //Recupero o nome das regionais de forma única em uma outra collection
            $regionaisenvolvidas = $regionaisnome->unique();

            //Junto os elementos da colection como uma string ligadas por uma vírgula, pelo método ->join();
            $regionais = $regionaisenvolvidas->join(', ');


            if($records->count() <= 0){

                $request->session()->flash('error_mapamensalgeralcategoria', 'Nenhum registro encontrado para esta pesquisa.');

                //Redirecionamento com âncora
                return redirect()->to(route('admin.registroconsultacompra.search').'#anchor-quatorze');

            } else {

                return view('admin.registrocompra.consultasadm.mapamensalgeralcategoria', compact('mes_id', 'ano_id', 'mesano', 'records', 'regionais'));

            }

        } else {

            return redirect()->route('admin.registroconsultacompra.search');
        }
    }


    //========================================
    // COMPARATIVO DE PRODUTOS MES/ANO
    //========================================

    // Comparativo mensal de produto por município
    public function comparativomensalprodutomunicipio(Request $request)
    {

        //dd($request);

        if($request->produto_id && $request->medida_id && $request->municipio_id && $request->mes_id && $request->ano_id ) {
            $prod_id = $request->produto_id;
            $medi_id = $request->medida_id;
            $muni_id = $request->municipio_id;
            $mes_id = $request->mes_id;
            $ano_id = $request->ano_id;

            // Meses e anos para formatar perído da pesquisa
            $mesespesquisa = [
                '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
                '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
            ];
            $anospesquisa = [date("Y"), date("Y") - 1, date("Y") - 2];

            // Protege inserção de mês inexistente
            if($mes_id < 1 || $mes_id > 12) {
                return redirect()->route('acesso.logout');
            }

            //montando mes/ano
            $mesano = $mesespesquisa[$mes_id]. "/".$ano_id;

            $municipio = Municipio::findOrFail($muni_id);

            //Recupera só o id do municipio
            $municipioId =  $municipio->id;

            $records = Bigtabledata::comparativomensalprodutomunicipio($prod_id, $medi_id, $municipioId, $mes_id, $ano_id);

            //die($records);

            if($records->count() <= 0){

                $request->session()->flash('error_comparativomensalprodutomunicipio', 'Nenhum registro encontrado para esta pesquisa.');
                //return redirect()->route('admin.registroconsultacompra.search');

                //Redirecionamento com âncora
                return redirect()->to(route('admin.registroconsultacompra.search').'#anchor-quinze');


            } else {

                return view('admin.registrocompra.consultasadm.comparativomensalprodutomunicipio', compact('prod_id', 'medi_id', 'muni_id', 'mes_id', 'ano_id', 'municipio', 'mesano', 'records'));

            }

        } else {

            return redirect()->route('admin.registroconsultacompra.search');
        }
    }



    // Comparativo mensal de produto por regional
    public function comparativomensalprodutoregional(Request $request)
    {
        if($request->produto_id && $request->medida_id && $request->regional_id && $request->mes_id && $request->ano_id ) {
            $prod_id = $request->produto_id;
            $medi_id = $request->medida_id;
            $regi_id = $request->regional_id;
            $mes_id = $request->mes_id;
            $ano_id = $request->ano_id;

            // Meses e anos para formatar perído da pesquisa
            $mesespesquisa = [
                '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
                '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
            ];
            $anospesquisa = [date("Y"), date("Y") - 1, date("Y") - 2];

            // Protege inserção de mês inexistente
            if($mes_id < 1 || $mes_id > 12) {
                return redirect()->route('acesso.logout');
            }

            //montando mes/ano
            $mesano = $mesespesquisa[$mes_id]. "/".$ano_id;

            $regional = Regional::findOrFail($regi_id);

            //Recupera só o id do regional
            $regionalId =  $regional->id;

            $records = Bigtabledata::comparativomensalprodutoregional($prod_id, $medi_id, $regionalId, $mes_id, $ano_id);

            //die($records);

            if($records->count() <= 0){

                $request->session()->flash('error_comparativomensalprodutoregional', 'Nenhum registro encontrado para esta pesquisa.');
                //return redirect()->route('admin.registroconsultacompra.search');

                //Redirecionamento com âncora
                return redirect()->to(route('admin.registroconsultacompra.search').'#anchor-dezesseis');


            } else {

                return view('admin.registrocompra.consultasadm.comparativomensalprodutoregional', compact('prod_id', 'medi_id', 'regi_id', 'mes_id', 'ano_id', 'regional', 'mesano', 'records'));

            }

        } else {

            return redirect()->route('admin.registroconsultacompra.search');
        }
    }








    // Comparativo mensal geral produto
    public function comparativomensalgeralproduto(Request $request)
    {
        if($request->mes_id && $request->ano_id ) {
            $prod_id = $request->produto_id;
            $medi_id = $request->medida_id;
            $mes_id = $request->mes_id;
            $ano_id = $request->ano_id;

            // Meses e anos para formatar perído da pesquisa
            $mesespesquisa = [
                '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
                '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
            ];
            $anospesquisa = [date("Y"), date("Y") - 1, date("Y") - 2];

            // Protege inserção de mês inexistente
            if($mes_id < 1 || $mes_id > 12) {
                return redirect()->route('acesso.logout');
            }

            //montando mes/ano
            $mesano = $mesespesquisa[$mes_id]. "/".$ano_id;


            $records = Bigtabledata::comparativomensalgeralproduto($prod_id, $medi_id, $mes_id, $ano_id);

            /*
            //Crio uma coleção
            $regionaisnome = collect();

            foreach($records as $record) {
                //Adiciona à coleção criada, apenas o nome das regionais, duplicadas ou não
                $regionaisnome->push($record->regional_nome);
            }

            //Recupero o nome das regionais de forma única em uma outra collection
            $regionaisenvolvidas = $regionaisnome->unique();

            //Junto os elementos da colection como uma string ligadas por uma vírgula, pelo método ->join();
            $regionais = $regionaisenvolvidas->join(', ');
            */


            if($records->count() <= 0){

                $request->session()->flash('error_comparativomensalgeralproduto', 'Nenhum registro encontrado para esta pesquisa.');

                //Redirecionamento com âncora
                return redirect()->to(route('admin.registroconsultacompra.search').'#anchor-onze');

            } else {

                return view('admin.registrocompra.consultasadm.comparativomensalgeralproduto', compact('prod_id', 'medi_id', 'mes_id', 'ano_id', 'mesano', 'records'));

            }

        } else {

            return redirect()->route('admin.registroconsultacompra.search');
        }
    }



    //========================================
    // COMPARATIVO DE CATEGORIAS MES/ANO
    //========================================
    // Comparativo mensal de categoria por município
    public function comparativomensalcategoriamunicipio(Request $request)
    {
        //dd($request);

        if($request->categoria_id && $request->medida_id && $request->municipio_id && $request->mes_id && $request->ano_id ) {
            $categ_id = $request->categoria_id;
            $medi_id = $request->medida_id;
            $muni_id = $request->municipio_id;
            $mes_id = $request->mes_id;
            $ano_id = $request->ano_id;

            // Meses e anos para formatar perído da pesquisa
            $mesespesquisa = [
                '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
                '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
            ];
            //$anospesquisa = [date("Y"), date("Y") - 1, date("Y") - 2];

            // Protege inserção de mês inexistente
            if($mes_id < 1 || $mes_id > 12) {
                return redirect()->route('acesso.logout');
            }

            //montando mes/ano
            $mesano = $mesespesquisa[$mes_id]. "/".$ano_id;

            $municipio = Municipio::findOrFail($muni_id);

            //Recupera só o id do municipio
            $municipioId =  $municipio->id;

            $records = Bigtabledata::comparativomensalcategoriamunicipio($categ_id, $medi_id, $municipioId, $mes_id, $ano_id);

            //die($records);

            if($records->count() <= 0){

                $request->session()->flash('error_comparativomensalcategoriamunicipio', 'Nenhum registro encontrado para esta pesquisa.');
                //return redirect()->route('admin.registroconsultacompra.search');

                //Redirecionamento com âncora
                return redirect()->to(route('admin.registroconsultacompra.search').'#anchor-dezoito');


            } else {

                return view('admin.registrocompra.consultasadm.comparativomensalcategoriamunicipio', compact('categ_id', 'medi_id', 'muni_id', 'mes_id', 'ano_id', 'municipio', 'mesano', 'records'));

            }

        } else {

            return redirect()->route('admin.registroconsultacompra.search');
        }
    }



    // Comparativo mensal de categoria por regional
    public function comparativomensalcategoriaregional(Request $request)
    {
        if($request->categoria_id && $request->medida_id && $request->regional_id && $request->mes_id && $request->ano_id ) {
            $categ_id = $request->categoria_id;
            $medi_id = $request->medida_id;
            $regi_id = $request->regional_id;
            $mes_id = $request->mes_id;
            $ano_id = $request->ano_id;

            // Meses e anos para formatar perído da pesquisa
            $mesespesquisa = [
                '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
                '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
            ];
            //$anospesquisa = [date("Y"), date("Y") - 1, date("Y") - 2];

            // Protege inserção de mês inexistente
            if($mes_id < 1 || $mes_id > 12) {
                return redirect()->route('acesso.logout');
            }

            //montando mes/ano
            $mesano = $mesespesquisa[$mes_id]. "/".$ano_id;

            $regional = Regional::findOrFail($regi_id);

            //Recupera só o id do regional
            $regionalId =  $regional->id;

            $records = Bigtabledata::comparativomensalcategoriaregional($categ_id, $medi_id, $regionalId, $mes_id, $ano_id);

            //die($records);

            if($records->count() <= 0){

                $request->session()->flash('error_comparativomensalcategoriaregional', 'Nenhum registro encontrado para esta pesquisa.');
                //return redirect()->route('admin.registroconsultacompra.search');

                //Redirecionamento com âncora
                return redirect()->to(route('admin.registroconsultacompra.search').'#anchor-dezenove');


            } else {

                return view('admin.registrocompra.consultasadm.comparativomensalcategoriaregional', compact('categ_id', 'medi_id', 'regi_id', 'mes_id', 'ano_id', 'regional', 'mesano', 'records'));

            }

        } else {

            return redirect()->route('admin.registroconsultacompra.search');
        }
    }



    // Comparativo mensal geral categoria
    public function comparativomensalgeralcategoria(Request $request)
    {
        if($request->mes_id && $request->ano_id ) {
            $categ_id = $request->categoria_id;
            $medi_id = $request->medida_id;
            $mes_id = $request->mes_id;
            $ano_id = $request->ano_id;

            // Meses e anos para formatar perído da pesquisa
            $mesespesquisa = [
                '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
                '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
            ];
            //$anospesquisa = [date("Y"), date("Y") - 1, date("Y") - 2];

            // Protege inserção de mês inexistente
            if($mes_id < 1 || $mes_id > 12) {
                return redirect()->route('acesso.logout');
            }

            //montando mes/ano
            $mesano = $mesespesquisa[$mes_id]. "/".$ano_id;


            $records = Bigtabledata::comparativomensalgeralcategoria($categ_id, $medi_id, $mes_id, $ano_id);

            /*
            //Crio uma coleção
            $regionaisnome = collect();

            foreach($records as $record) {
                //Adiciona à coleção criada, apenas o nome das regionais, duplicadas ou não
                $regionaisnome->push($record->regional_nome);
            }

            //Recupero o nome das regionais de forma única em uma outra collection
            $regionaisenvolvidas = $regionaisnome->unique();

            //Junto os elementos da colection como uma string ligadas por uma vírgula, pelo método ->join();
            $regionais = $regionaisenvolvidas->join(', ');
            */


            if($records->count() <= 0){

                $request->session()->flash('error_comparativomensalgeralcategoria', 'Nenhum registro encontrado para esta pesquisa.');

                //Redirecionamento com âncora
                return redirect()->to(route('admin.registroconsultacompra.search').'#anchor-vinte');

            } else {

                return view('admin.registrocompra.consultasadm.comparativomensalgeralcategoria', compact('categ_id', 'medi_id', 'mes_id', 'ano_id', 'mesano', 'records'));

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





    public function ajaxgetdetalhecompramensalregiaovalor(Request $request)
    {
        if($request->municipio && $request->mes && $request->ano ) {
            $muni_id = $request->municipio;
            $mes_id = $request->mes;
            $ano_id = $request->ano;

            // Meses e anos para formatar período da pesquisa
            $mesespesquisa = [
                '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
                '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
            ];

            //montando mes/ano e depois cria-se um índice com essa composição
            $meseano = $mesespesquisa[$mes_id]. "/".$ano_id;

            //recupera o município
            $municipio = Municipio::findOrFail($muni_id);

            //Recupera só o id do municipio
            $municipioId =  $municipio->id;

            $records = Bigtabledata::compramensalmunicipiovalor($municipioId, $mes_id, $ano_id);

            //Criando índices a serem enviados para a utilização na view
            $data['mesano']  = $meseano;        //um índice arbitrário para ser utilizado na view
            $data['records'] = $records;        //resultado vindo do banco de dados

            //Retornando os dados juntamente com o índice criado acima para a view que chamou este json para serem exibidos.
            return response()->json($data);

        } else {

            return redirect()->route('admin.registroconsultacompra.search');
        }
    }


    public function ajaxgetmedidaproduto(Request $request)
    {
        $condicoes = [
            ['produto_id', '=', $request->produto_id]
        ];

        //Obs: Com o método 'DISTINCT', é necessário colocar os campos que se deseja retornar no método GET
        $data['medidas'] = Bigtabledata::distinct()->where($condicoes)->orderBy('medida_simbolo', 'ASC')->get(['medida_id', 'medida_simbolo']);

        return response()->json($data);
    }


    public function ajaxgetmedidacategoria(Request $request)
    {
        $condicoes = [
            ['categoria_id', '=', $request->categoria_id]
        ];

        //Obs: Com o método 'DISTINCT', é necessário colocar os campos que se deseja retornar no método GET
        $data['medidas'] = Bigtabledata::distinct()->where($condicoes)->orderBy('medida_simbolo', 'ASC')->get(['medida_id', 'medida_simbolo']);

        return response()->json($data);
    }





    /***************************************/
    /*    RELATÓRIOS PDF's, Excel e CSV    */
    /***************************************/

    public function relpdfcomprassemana($rest, $sema, $mes, $ano)
    {
        // Meses para compor cabeçalho do relatório
        $meses = [
            '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
            '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
        ];

        // Semanas para compor o cabeçalho do relatório
        $semanas = ['1' => 'um', '2' => 'dois', '3' => 'três', '4' => 'quatro', '5' => 'cinco'];

        $restaurante = Restaurante::findOrFail($rest);

        $restauranteId = $restaurante->id;

        // Obtendo os dados
        $records = Bigtabledata::comprasemanal($restauranteId, $sema, $mes, $ano);

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
        $fileName = ('compras_semana'.'.pdf');

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
                        <img src="images/logo-ma.png" width="100"/>
                    </td>
                    <td style="width: 282px; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                        Governo do Estado do Maranhão<br>
                        Secretaria de Governo<br>
                        Secreatia Adjunta de Tecnologia da Informação/SEATI<br>
                        Secretaria do Estado de Desenvolvimento Social/SEDES
                    </td>
                    <td style="width: 352px;" class="titulo-rel">
                        '.$records[0]->identificacao.' <br> compras ref.: semana '.Str::upper($semanas[$sema]). " de ".$meses[$mes].'/'.$ano.'
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
                    <td style="width: 100px;" class="dados-ficha">'.Str::upper($semanas[$sema]).'</td>
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
        $html = \View::make('admin.registrocompra.pdf.pdfcomprassemana', compact('records', 'compranormal', 'compraaf', 'somapreco', 'somaprecoaf', 'somafinal'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.produto.pdf.pdfproduto')
        $stylesheet = file_get_contents('pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }



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
        //$records = Bigtabledata::comprasMes($restauranteId, $mes, $ano);
        $records = Bigtabledata::compramensal($restauranteId, $mes, $ano);

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
                        <img src="images/logo-ma.png" width="100"/>
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
                    <td style="width: 100px;" class="label-ficha">Mês</td>
                    <td style="width: 100px;" class="label-ficha">Data Inicial</td>
                    <td style="width: 100px;" class="label-ficha">Data Final</td>
                </tr>
                <tr>
                    <td style="width: 417px;" class="dados-ficha">'.$records[0]->municipio_nome.' ('.$records[0]->regional_nome.')</td>
                    <td style="width: 100px;" class="dados-ficha">'.$meses[$mes].'</td>
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
                        <img src="images/logo-ma.png" width="100"/>
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



    // Relatório PDF Compra mensal de produtos por restaurante
    public function relpdfproducaorestaurantemesano($rest, $mes, $ano)
    {
        // Meses para compor cabeçalho do relatório
        $meses = [
            '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
            '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
        ];

        $restaurante = Restaurante::findOrFail($rest);

        $restauranteId = $restaurante->id;

        // Obtendo os dados
        $records = Bigtabledata::producaorestaurantemesano($restauranteId, $mes, $ano);

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('producaorestaurante'.'.pdf');

        // Invocando a biblioteca mpdf e definindo as margens do arquivo
        $mpdf = new \Mpdf\Mpdf([
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 42,
            'margin_bottom' => 15,
            'margin-header' => 10,
            'margin_footer' => 5
        ]);

        // Configurando o cabeçalho da página
        $mpdf->SetHTMLHeader('
            <table style="width:717px; border-bottom: 1px solid #000000; margin-bottom: 3px;">
                <tr>
                    <td style="width: 83px">
                        <img src="images/logo-ma.png" width="100"/>
                    </td>
                    <td style="width: 282px; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                        Governo do Estado do Maranhão<br>
                        Secretaria de Governo<br>
                        Secreatia Adjunta de Tecnologia da Informação/SEATI<br>
                        Secretaria do Estado de Desenvolvimento Social/SEDES
                    </td>
                    <td style="width: 352px" class="titulo-rel">
                        PRODUÇÃO MÊS <br>'.$records[0]->identificacao.': '.$meses[$mes].'/'.$ano.'
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
        $html = \View::make('admin.registrocompra.pdf.pdfproducaorestaurantemesano', compact('records'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.produto.pdf.pdfproduto')
        $stylesheet = file_get_contents('pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }



    // Relatório PDF Compra mensal de produtos por regional
    public function relpdfcompramensalregionalproduto($regi, $mes, $ano)
    {
        // Meses para compor cabeçalho do relatório
        $meses = [
            '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
            '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
        ];

        $regional = Regional::findOrFail($regi);

        $regionalId = $regional->id;

        // Obtendo os dados
        $records = Bigtabledata::compramensalregionalproduto($regionalId, $mes, $ano);

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('compramensalregionalproduto'.'.pdf');

        // Invocando a biblioteca mpdf e definindo as margens do arquivo
        $mpdf = new \Mpdf\Mpdf([
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 31,
            'margin_bottom' => 15,
            'margin-header' => 10,
            'margin_footer' => 5
        ]);

        // Configurando o cabeçalho da página
        $mpdf->SetHTMLHeader('
            <table style="width:717px; border-bottom: 1px solid #000000; margin-bottom: 3px;">
                <tr>
                    <td style="width: 83px">
                        <img src="images/logo-ma.png" width="100"/>
                    </td>
                    <td style="width: 282px; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                        Governo do Estado do Maranhão<br>
                        Secretaria de Governo<br>
                        Secreatia Adjunta de Tecnologia da Informação/SEATI<br>
                        Secretaria do Estado de Desenvolvimento Social/SEDES
                    </td>
                    <td style="width: 352px;" class="titulo-rel">
                        COMPRA MENSAL DE PRODUTOS NA REGIONAL<br>'.$records[0]->regional_nome.': '.$meses[$mes].'/'.$ano.'
                    </td>
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
        $html = \View::make('admin.registrocompra.pdf.pdfcompramensalregionalproduto', compact('records'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.produto.pdf.pdfproduto')
        $stylesheet = file_get_contents('pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }



    // Relatório PDF Compra mensal por município valor
    public function relpdfcompramensalmunicipiovalor($mun, $mes, $ano)
    {
        // Meses para compor cabeçalho do relatório
        $meses = [
            '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
            '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
        ];

        $municipio = Municipio::findOrFail($mun);

        $municipioId = $municipio->id;

        // Obtendo os dados
        $records = Bigtabledata::compramensalmunicipiovalor($municipioId, $mes, $ano);

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('compramensalmunicipiovalor'.'.pdf');

        // Invocando a biblioteca mpdf e definindo as margens do arquivo
        $mpdf = new \Mpdf\Mpdf([
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 37,
            'margin_bottom' => 15,
            'margin-header' => 10,
            'margin_footer' => 5
        ]);

        // Configurando o cabeçalho da página
        $mpdf->SetHTMLHeader('
            <table style="width:717px; border-bottom: 1px solid #000000; margin-bottom: 3px;">
                <tr>
                    <td style="width: 83px">
                        <img src="images/logo-ma.png" width="100"/>
                    </td>
                    <td style="width: 282px; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                        Governo do Estado do Maranhão<br>
                        Secretaria de Governo<br>
                        Secreatia Adjunta de Tecnologia da Informação/SEATI<br>
                        Secretaria do Estado de Desenvolvimento Social/SEDES
                    </td>
                    <td style="width: 352px;" class="titulo-rel">
                        VALORES COMPRADOS NO MUNICÍPIO <br>'.$records[0]->municipio_nome.': '.$meses[$mes].'/'.$ano.'
                    </td>
                </tr>
            </table>

            <table style="width:717px; border-collapse: collapse">
                <tr>
                    <td rowspan="2" width="30px" class="col-header-table" style="text-align:center">Id</td>
                    <td rowspan="2" width="387px" class="col-header-table" style="text-align:center">Restaurantes</td>
                    <td colspan="2" width="160px" class="col-header-table" style="text-align:center">Compras</td>
                    <td rowspan="2" width="60px" class="col-header-table" style="text-align:center">% AF</td>
                    <td rowspan="2" width="80px" class="col-header-table" style="text-align:center">Total</td>
                </tr>
                <tr>
                    <td width="80px" class="col-header-table" style="text-align:center">Normal (R$)</td>
                    <td width="80px" class="col-header-table" style="text-align:center">AF (R$)</td>
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
        $html = \View::make('admin.registrocompra.pdf.pdfcompramensalmunicipiovalor', compact('records'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.produto.pdf.pdfproduto')
        $stylesheet = file_get_contents('pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }


    // Relatório PDF Compra mensal por região valor
    public function relpdfcompramensalregiaovalor($reg, $mes, $ano)
    {
        // Meses para compor cabeçalho do relatório
        $meses = [
            '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
            '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
        ];

        $regional = Regional::findOrFail($reg);

        $regionalId = $regional->id;

        // Obtendo os dados
        $records = Bigtabledata::compramensalregiaovalor($regionalId, $mes, $ano);

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('compramensalregiaovalor'.'.pdf');

        // Invocando a biblioteca mpdf e definindo as margens do arquivo
        $mpdf = new \Mpdf\Mpdf([
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 37,
            'margin_bottom' => 15,
            'margin-header' => 10,
            'margin_footer' => 5
        ]);

        // Configurando o cabeçalho da página
        $mpdf->SetHTMLHeader('
            <table style="width:717px; border-bottom: 1px solid #000000; margin-bottom: 3px;">
                <tr>
                    <td style="width: 83px">
                        <img src="images/logo-ma.png" width="100"/>
                    </td>
                    <td style="width: 282px; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                        Governo do Estado do Maranhão<br>
                        Secretaria de Governo<br>
                        Secreatia Adjunta de Tecnologia da Informação/SEATI<br>
                        Secretaria do Estado de Desenvolvimento Social/SEDES
                    </td>
                    <td style="width: 352px;" class="titulo-rel">
                        VALORES COMPRADOS NA REGIONAL <br>'.$records[0]->regional_nome.': '.$meses[$mes].'/'.$ano.'
                    </td>
                </tr>
            </table>

            <table style="width:717px; border-collapse: collapse">
                <tr>
                    <td rowspan="2" width="30px" class="col-header-table" style="text-align:center">Id</td>
                    <td rowspan="2" width="387px" class="col-header-table" style="text-align:center">Municípios</td>
                    <td colspan="2" width="160px" class="col-header-table" style="text-align:center">Compras</td>
                    <td rowspan="2" width="60px" class="col-header-table" style="text-align:center">% AF</td>
                    <td rowspan="2" width="80px" class="col-header-table" style="text-align:center">Total</td>
                </tr>
                <tr>
                    <td width="80px" class="col-header-table" style="text-align:center">Normal (R$)</td>
                    <td width="80px" class="col-header-table" style="text-align:center">AF (R$)</td>
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
        $html = \View::make('admin.registrocompra.pdf.pdfcompramensalregiaovalor', compact('records'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.produto.pdf.pdfproduto')
        $stylesheet = file_get_contents('pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }


    // Relatório PDF Mapa mensal de produtos adquiridos por unidade no restaurante
    public function relpdfmapamensalprodutorestaurante($rest, $mes, $ano)
    {
        // Meses para compor cabeçalho do relatório
        $meses = [
            '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
            '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
        ];

        $restaurante = Restaurante::findOrFail($rest);

        $restauranteId = $restaurante->id;

        // Obtendo os dados
        $records = Bigtabledata::mapamensalprodutorestaurante($restauranteId, $mes, $ano);

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('mapamensalprodutorestaurante'.'.pdf');

        // Invocando a biblioteca mpdf e definindo as margens do arquivo
        $mpdf = new \Mpdf\Mpdf([
            'orientation' => 'L',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 43,
            'margin_bottom' => 15,
            'margin-header' => 10,
            'margin_footer' => 5
        ]);

        // Configurando o cabeçalho da página
        $mpdf->SetHTMLHeader('
            <table style="width:1080px; border-bottom: 1px solid #000000; margin-bottom: 3px;">
                <tr>
                    <td style="width: 108px">
                        <img src="images/logo-ma.png" width="100"/>
                    </td>
                    <td style="width: 432px; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                        Governo do Estado do Maranhão<br>
                        Secretaria de Governo<br>
                        Secreatia Adjunta de Tecnologia da Informação/SEATI<br>
                        Secretaria do Estado de Desenvolvimento Social/SEDES
                    </td>
                    <td style="width: 540px;" class="titulo-rel">
                        MAPA MENSAL DE PRODUTOS ADQUIRIDOS POR UNIDADE <br>'.$records[0]->identificacao.': '.$meses[$mes].'/'.$ano.'
                    </td>
                </tr>
            </table>

            <table style="width:1080px; border-collapse: collapse">
                <tr>
                    <td rowspan="3" width="40px" class="col-header-table" style="text-align: center">Id</td>
                    <td rowspan="3" width="280px" class="col-header-table" style="text-align: center">Produto</td>
                    <td rowspan="3" width="40px" class="col-header-table" style="text-align: center">Und.</td>
                    <td colspan="8" width="480px" class="col-header-table" style="text-align: center">COMPRAS</td>
                    <td rowspan="2" colspan="2" width="120px" class="col-header-table" style="text-align: center">TOTAL</td>
                    <td rowspan="2" colspan="2" width="120px" class="col-header-table" style="text-align: center"> &#177; (%) AF</td>
                </tr>
                <tr>
                    <td colspan="4" width="240px" class="col-header-table" style="text-align: center">Normal</td>
                    <td colspan="4" width="240px" class="col-header-table" style="text-align: center">AF</td>
                </tr>
                <tr>
                    <td width="50px" class="col-header-table" style="text-align: center">nº vz</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="70px" class="col-header-table" style="text-align: center">p.m (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">nº vz</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="70px" class="col-header-table" style="text-align: center">p.m (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">% Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">% Valor (R$)</td>
                </tr>
            </table>
        ');

        // Configurando o rodapé da página
        $mpdf->SetHTMLFooter('
            <table style="width:1080px; border-top: 1px solid #000000; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                <tr>
                    <td width="200px">São Luis(MA) {DATE d/m/Y H:i}</td>
                    <td width="830px" align="left">
                        <span style="margin-right: 50px"><strong>Und.</strong> = unidade de medida;</span>
                        <span style="margin-right: 50px"><strong>nº vz</strong> = número de vezes comprado;</span>
                        <span style="margin-right: 50px"><strong>Qtd.</strong> = quantidade comprada;</span>
                        <span style="margin-right: 50px"><strong>p.m</strong> = preço médio;</span>
                    </td>
                    <td width="50px" align="right">{PAGENO}/{nbpg}</td>
                </tr>
            </table>
        ');


        // Definindo a view que deverá ser renderizada como arquivo .pdf e passando os dados da pesquisa
        $html = \View::make('admin.registrocompra.pdf.pdfmapamensalprodutorestaurante', compact('records'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.produto.pdf.pdfproduto')
        $stylesheet = file_get_contents('pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }








    // Relatório PDF Mapa mensal de produtos adquiridos por unidade no municipio
    public function relpdfmapamensalprodutomunicipio($muni, $mes, $ano)
    {
        // Meses para compor cabeçalho do relatório
        $meses = [
            '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
            '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
        ];

        $municipio = Municipio::findOrFail($muni);

        $municipioId = $municipio->id;

        // Obtendo os dados
        $records = Bigtabledata::mapamensalprodutomunicipio($municipioId, $mes, $ano);

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('mapamensalprodutomunicipio'.'.pdf');

        // Invocando a biblioteca mpdf e definindo as margens do arquivo
        $mpdf = new \Mpdf\Mpdf([
            'orientation' => 'L',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 43,
            'margin_bottom' => 15,
            'margin-header' => 10,
            'margin_footer' => 5
        ]);

        // Configurando o cabeçalho da página
        $mpdf->SetHTMLHeader('
            <table style="width:1080px; border-bottom: 1px solid #000000; margin-bottom: 3px;">
                <tr>
                    <td style="width: 108px">
                        <img src="images/logo-ma.png" width="100"/>
                    </td>
                    <td style="width: 432px; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                        Governo do Estado do Maranhão<br>
                        Secretaria de Governo<br>
                        Secreatia Adjunta de Tecnologia da Informação/SEATI<br>
                        Secretaria do Estado de Desenvolvimento Social/SEDES
                    </td>
                    <td style="width: 540px;" class="titulo-rel">
                        MAPA MENSAL DE PRODUTOS ADQUIRIDOS POR UNIDADE <br>'.$records[0]->municipio_nome.': '.$meses[$mes].'/'.$ano.'
                    </td>
                </tr>
            </table>

            <table style="width:1080px; border-collapse: collapse">
                <tr>
                    <td rowspan="3" width="40px" class="col-header-table" style="text-align: center">Id</td>
                    <td rowspan="3" width="280px" class="col-header-table" style="text-align: center">Produto</td>
                    <td rowspan="3" width="40px" class="col-header-table" style="text-align: center">Und.</td>
                    <td colspan="8" width="480px" class="col-header-table" style="text-align: center">COMPRAS</td>
                    <td rowspan="2" colspan="2" width="120px" class="col-header-table" style="text-align: center">TOTAL</td>
                    <td rowspan="2" colspan="2" width="120px" class="col-header-table" style="text-align: center"> &#177; (%) AF</td>
                </tr>
                <tr>
                    <td colspan="4" width="240px" class="col-header-table" style="text-align: center">Normal</td>
                    <td colspan="4" width="240px" class="col-header-table" style="text-align: center">AF</td>
                </tr>
                <tr>
                    <td width="50px" class="col-header-table" style="text-align: center">nº vz</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="70px" class="col-header-table" style="text-align: center">p.m (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">nº vz</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="70px" class="col-header-table" style="text-align: center">p.m (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">% Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">% Valor (R$)</td>
                </tr>
            </table>
        ');

        // Configurando o rodapé da página
        $mpdf->SetHTMLFooter('
            <table style="width:1080px; border-top: 1px solid #000000; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                <tr>
                    <td width="200px">São Luis(MA) {DATE d/m/Y H:i}</td>
                    <td width="830px" align="left">
                        <span style="margin-right: 50px"><strong>Und.</strong> = unidade de medida;</span>
                        <span style="margin-right: 50px"><strong>nº vz</strong> = número de vezes comprado;</span>
                        <span style="margin-right: 50px"><strong>Qtd.</strong> = quantidade comprada;</span>
                        <span style="margin-right: 50px"><strong>p.m</strong> = preço médio;</span>
                    </td>
                    <td width="50px" align="right">{PAGENO}/{nbpg}</td>
                </tr>
            </table>
        ');


        // Definindo a view que deverá ser renderizada como arquivo .pdf e passando os dados da pesquisa
        $html = \View::make('admin.registrocompra.pdf.pdfmapamensalprodutomunicipio', compact('records'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.produto.pdf.pdfproduto')
        $stylesheet = file_get_contents('pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }




    // Relatório PDF Mapa mensal de produtos adquiridos por unidade na regional
    public function relpdfmapamensalprodutoregional($regi, $mes, $ano)
    {
        // Meses para compor cabeçalho do relatório
        $meses = [
            '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
            '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
        ];

        $regional = Regional::findOrFail($regi);

        $regionalId = $regional->id;

        // Obtendo os dados
        $records = Bigtabledata::mapamensalprodutoregional($regionalId, $mes, $ano);

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('mapamensalprodutoregional'.'.pdf');

        // Invocando a biblioteca mpdf e definindo as margens do arquivo
        $mpdf = new \Mpdf\Mpdf([
            'orientation' => 'L',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 43,
            'margin_bottom' => 15,
            'margin-header' => 10,
            'margin_footer' => 5
        ]);

        // Configurando o cabeçalho da página
        $mpdf->SetHTMLHeader('
            <table style="width:1080px; border-bottom: 1px solid #000000; margin-bottom: 3px;">
                <tr>
                    <td style="width: 108px">
                        <img src="images/logo-ma.png" width="100"/>
                    </td>
                    <td style="width: 432px; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                        Governo do Estado do Maranhão<br>
                        Secretaria de Governo<br>
                        Secreatia Adjunta de Tecnologia da Informação/SEATI<br>
                        Secretaria do Estado de Desenvolvimento Social/SEDES
                    </td>
                    <td style="width: 540px;" class="titulo-rel">
                        MAPA MENSAL DE PRODUTOS ADQUIRIDOS POR UNIDADE <br> Região '.$records[0]->regional_nome.': '.$meses[$mes].'/'.$ano.'
                    </td>
                </tr>
            </table>

            <table style="width:1080px; border-collapse: collapse">
                <tr>
                    <td rowspan="3" width="40px" class="col-header-table" style="text-align: center">Id</td>
                    <td rowspan="3" width="280px" class="col-header-table" style="text-align: center">Produto</td>
                    <td rowspan="3" width="40px" class="col-header-table" style="text-align: center">Und.</td>
                    <td colspan="8" width="480px" class="col-header-table" style="text-align: center">COMPRAS</td>
                    <td rowspan="2" colspan="2" width="120px" class="col-header-table" style="text-align: center">TOTAL</td>
                    <td rowspan="2" colspan="2" width="120px" class="col-header-table" style="text-align: center"> &#177; (%) AF</td>
                </tr>
                <tr>
                    <td colspan="4" width="240px" class="col-header-table" style="text-align: center">Normal</td>
                    <td colspan="4" width="240px" class="col-header-table" style="text-align: center">AF</td>
                </tr>
                <tr>
                    <td width="50px" class="col-header-table" style="text-align: center">nº vz</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="70px" class="col-header-table" style="text-align: center">p.m (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">nº vz</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="70px" class="col-header-table" style="text-align: center">p.m (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">% Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">% Valor (R$)</td>
                </tr>
            </table>
        ');

        // Configurando o rodapé da página
        $mpdf->SetHTMLFooter('
            <table style="width:1080px; border-top: 1px solid #000000; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                <tr>
                    <td width="200px">São Luis(MA) {DATE d/m/Y H:i}</td>
                    <td width="830px" align="left">
                        <span style="margin-right: 50px"><strong>Und.</strong> = unidade de medida;</span>
                        <span style="margin-right: 50px"><strong>nº vz</strong> = número de vezes comprado;</span>
                        <span style="margin-right: 50px"><strong>Qtd.</strong> = quantidade comprada;</span>
                        <span style="margin-right: 50px"><strong>p.m</strong> = preço médio;</span>
                    </td>
                    <td width="50px" align="right">{PAGENO}/{nbpg}</td>
                </tr>
            </table>
        ');


        // Definindo a view que deverá ser renderizada como arquivo .pdf e passando os dados da pesquisa
        $html = \View::make('admin.registrocompra.pdf.pdfmapamensalprodutoregional', compact('records'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.produto.pdf.pdfproduto')
        $stylesheet = file_get_contents('pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }





    // Relatório PDF Mapa mensal geral de produtos adquiridos por unidade
    public function relpdfmapamensalgeralproduto($mes, $ano)
    {
        // Meses para compor cabeçalho do relatório
        $meses = [
            '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
            '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
        ];


        // Obtendo os dados
        $records = Bigtabledata::mapamensalgeralproduto($mes, $ano);

        //Crio uma coleção
        $regionaisnome = collect();
        foreach($records as $record) {
            //Adiciona à coleção criada, apenas o nome das regionais, duplicadas ou não
            $regionaisnome->push($record->regional_nome);
        }
        //Recupero o nome das regionais de forma única em uma outra collection
        $regionaisenvolvidas = $regionaisnome->unique();

        //Junto os elementos da colection como uma string ligadas por uma vírgula
        $regionais = $regionaisenvolvidas->join(', ');


        // Definindo o nome do arquivo a ser baixado
        $fileName = ('mapamensalgeralproduto'.'.pdf');

        // Invocando a biblioteca mpdf e definindo as margens do arquivo
        $mpdf = new \Mpdf\Mpdf([
            'orientation' => 'L',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 47,
            'margin_bottom' => 15,
            'margin-header' => 10,
            'margin_footer' => 5
        ]);

        // Configurando o cabeçalho da página
        $mpdf->SetHTMLHeader('
            <table style="width:1080px; border-bottom: 1px solid #000000; margin-bottom: 3px;">
                <tr>
                    <td style="width: 108px">
                        <img src="images/logo-ma.png" width="100"/>
                    </td>
                    <td style="width: 432px; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                        Governo do Estado do Maranhão<br>
                        Secretaria de Governo<br>
                        Secreatia Adjunta de Tecnologia da Informação/SEATI<br>
                        Secretaria do Estado de Desenvolvimento Social/SEDES
                    </td>
                    <td style="width: 540px;" class="titulo-rel">
                        MAPA MENSAL GERAL DE PRODUTOS ADQUIRIDOS POR UNIDADE <br>'.$meses[$mes].'/'.$ano.'
                    </td>
                </tr>
            </table>

            <table style="width:1080px; border-collapse: collapse">
                <tr>
                    <td colspan="21" width="1080px" class="col-header-table" style="text-left: center"><strong>Regiões: </strong>'.$regionais.'</td>
                </tr>
            </table>

            <table style="width:1080px; border-collapse: collapse">
                <tr>
                    <td rowspan="3" width="40px" class="col-header-table" style="text-align: center">Id</td>
                    <td rowspan="3" width="280px" class="col-header-table" style="text-align: center">Produto</td>
                    <td rowspan="3" width="40px" class="col-header-table" style="text-align: center">Und.</td>
                    <td colspan="8" width="480px" class="col-header-table" style="text-align: center">COMPRAS</td>
                    <td rowspan="2" colspan="2" width="120px" class="col-header-table" style="text-align: center">TOTAL</td>
                    <td rowspan="2" colspan="2" width="120px" class="col-header-table" style="text-align: center"> &#177; (%) AF</td>
                </tr>
                <tr>
                    <td colspan="4" width="240px" class="col-header-table" style="text-align: center">Normal</td>
                    <td colspan="4" width="240px" class="col-header-table" style="text-align: center">AF</td>
                </tr>
                <tr>
                    <td width="50px" class="col-header-table" style="text-align: center">nº vz</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="70px" class="col-header-table" style="text-align: center">p.m (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">nº vz</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="70px" class="col-header-table" style="text-align: center">p.m (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">% Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">% Valor (R$)</td>
                </tr>
            </table>
        ');

        // Configurando o rodapé da página
        $mpdf->SetHTMLFooter('
            <table style="width:1080px; border-top: 1px solid #000000; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                <tr>
                    <td width="200px">São Luis(MA) {DATE d/m/Y H:i}</td>
                    <td width="830px" align="left">
                        <span style="margin-right: 50px"><strong>Und.</strong> = unidade de medida;</span>
                        <span style="margin-right: 50px"><strong>nº vz</strong> = número de vezes comprado;</span>
                        <span style="margin-right: 50px"><strong>Qtd.</strong> = quantidade comprada;</span>
                        <span style="margin-right: 50px"><strong>p.m</strong> = preço médio;</span>
                    </td>
                    <td width="50px" align="right">{PAGENO}/{nbpg}</td>
                </tr>
            </table>
        ');


        // Definindo a view que deverá ser renderizada como arquivo .pdf e passando os dados da pesquisa
        $html = \View::make('admin.registrocompra.pdf.pdfmapamensalgeralproduto', compact('records'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.produto.pdf.pdfproduto')
        $stylesheet = file_get_contents('pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }


    // Relatório PDF Mapa mensal de categorias de produtos adquiridos por unidade no restaurante
    public function relpdfmapamensalcategoriarestaurante($rest, $mes, $ano)
    {
        // Meses para compor cabeçalho do relatório
        $meses = [
            '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
            '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
        ];

        $restaurante = Restaurante::findOrFail($rest);

        $restauranteId = $restaurante->id;

        // Obtendo os dados
        $records = Bigtabledata::mapamensalcategoriarestaurante($restauranteId, $mes, $ano);

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('mapamensalcategoriarestaurante'.'.pdf');

        // Invocando a biblioteca mpdf e definindo as margens do arquivo
        $mpdf = new \Mpdf\Mpdf([
            'orientation' => 'L',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 43,
            'margin_bottom' => 15,
            'margin-header' => 10,
            'margin_footer' => 5
        ]);

        // Configurando o cabeçalho da página
        $mpdf->SetHTMLHeader('
            <table style="width:1080px; border-bottom: 1px solid #000000; margin-bottom: 3px;">
                <tr>
                    <td style="width: 108px">
                        <img src="images/logo-ma.png" width="100"/>
                    </td>
                    <td style="width: 432px; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                        Governo do Estado do Maranhão<br>
                        Secretaria de Governo<br>
                        Secreatia Adjunta de Tecnologia da Informação/SEATI<br>
                        Secretaria do Estado de Desenvolvimento Social/SEDES
                    </td>
                    <td style="width: 540px;" class="titulo-rel">
                        MAPA MENSAL DE PRODUTOS ADQUIRIDOS POR CATEGORIAS EM UNIDADE <br>'.$records[0]->identificacao.': '.$meses[$mes].'/'.$ano.'
                    </td>
                </tr>
            </table>

            <table style="width:1080px; border-collapse: collapse">
                <tr>
                    <td rowspan="3" width="40px" class="col-header-table" style="text-align: center">Id</td>
                    <td rowspan="3" width="280px" class="col-header-table" style="text-align: center">Categoria</td>
                    <td rowspan="3" width="40px" class="col-header-table" style="text-align: center">Und.</td>
                    <td colspan="8" width="480px" class="col-header-table" style="text-align: center">COMPRAS</td>
                    <td rowspan="2" colspan="2" width="120px" class="col-header-table" style="text-align: center">TOTAL</td>
                    <td rowspan="2" colspan="2" width="120px" class="col-header-table" style="text-align: center"> &#177; (%) AF</td>
                </tr>
                <tr>
                    <td colspan="4" width="240px" class="col-header-table" style="text-align: center">Normal</td>
                    <td colspan="4" width="240px" class="col-header-table" style="text-align: center">AF</td>
                </tr>
                <tr>
                    <td width="50px" class="col-header-table" style="text-align: center">nº vz</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="70px" class="col-header-table" style="text-align: center">p.m (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">nº vz</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="70px" class="col-header-table" style="text-align: center">p.m (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">% Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">% Valor (R$)</td>
                </tr>
            </table>
        ');

        // Configurando o rodapé da página
        $mpdf->SetHTMLFooter('
            <table style="width:1080px; border-top: 1px solid #000000; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                <tr>
                    <td width="200px">São Luis(MA) {DATE d/m/Y H:i}</td>
                    <td width="830px" align="left">
                        <span style="margin-right: 50px"><strong>Und.</strong> = unidade de medida;</span>
                        <span style="margin-right: 50px"><strong>nº vz</strong> = número de vezes comprado;</span>
                        <span style="margin-right: 50px"><strong>Qtd.</strong> = quantidade comprada;</span>
                        <span style="margin-right: 50px"><strong>p.m</strong> = preço médio;</span>
                    </td>
                    <td width="50px" align="right">{PAGENO}/{nbpg}</td>
                </tr>
            </table>
        ');


        // Definindo a view que deverá ser renderizada como arquivo .pdf e passando os dados da pesquisa
        $html = \View::make('admin.registrocompra.pdf.pdfmapamensalcategoriarestaurante', compact('records'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.produto.pdf.pdfproduto')
        $stylesheet = file_get_contents('pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }







    // Relatório PDF Mapa mensal de produtos por categoria adquiridos por unidade no municipio
    public function relpdfmapamensalcategoriamunicipio($muni, $mes, $ano)
    {
        // Meses para compor cabeçalho do relatório
        $meses = [
            '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
            '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
        ];

        $municipio = Municipio::findOrFail($muni);

        $municipioId = $municipio->id;

        // Obtendo os dados
        $records = Bigtabledata::mapamensalcategoriamunicipio($municipioId, $mes, $ano);

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('mapamensalcategoriamunicipio'.'.pdf');

        // Invocando a biblioteca mpdf e definindo as margens do arquivo
        $mpdf = new \Mpdf\Mpdf([
            'orientation' => 'L',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 43,
            'margin_bottom' => 15,
            'margin-header' => 10,
            'margin_footer' => 5
        ]);

        // Configurando o cabeçalho da página
        $mpdf->SetHTMLHeader('
            <table style="width:1080px; border-bottom: 1px solid #000000; margin-bottom: 3px;">
                <tr>
                    <td style="width: 108px">
                        <img src="images/logo-ma.png" width="100"/>
                    </td>
                    <td style="width: 432px; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                        Governo do Estado do Maranhão<br>
                        Secretaria de Governo<br>
                        Secreatia Adjunta de Tecnologia da Informação/SEATI<br>
                        Secretaria do Estado de Desenvolvimento Social/SEDES
                    </td>
                    <td style="width: 540px;" class="titulo-rel">
                        MAPA MENSAL DE PRODUTOS ADQUIRIDOS POR CATEGORIA EM UNIDADE <br>'.$records[0]->municipio_nome.': '.$meses[$mes].'/'.$ano.'
                    </td>
                </tr>
            </table>

            <table style="width:1080px; border-collapse: collapse">
                <tr>
                    <td rowspan="3" width="40px" class="col-header-table" style="text-align: center">Id</td>
                    <td rowspan="3" width="280px" class="col-header-table" style="text-align: center">Categoria</td>
                    <td rowspan="3" width="40px" class="col-header-table" style="text-align: center">Und.</td>
                    <td colspan="8" width="480px" class="col-header-table" style="text-align: center">COMPRAS</td>
                    <td rowspan="2" colspan="2" width="120px" class="col-header-table" style="text-align: center">TOTAL</td>
                    <td rowspan="2" colspan="2" width="120px" class="col-header-table" style="text-align: center"> &#177; (%) AF</td>
                </tr>
                <tr>
                    <td colspan="4" width="240px" class="col-header-table" style="text-align: center">Normal</td>
                    <td colspan="4" width="240px" class="col-header-table" style="text-align: center">AF</td>
                </tr>
                <tr>
                    <td width="50px" class="col-header-table" style="text-align: center">nº vz</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="70px" class="col-header-table" style="text-align: center">p.m (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">nº vz</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="70px" class="col-header-table" style="text-align: center">p.m (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">% Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">% Valor (R$)</td>
                </tr>
            </table>
        ');

        // Configurando o rodapé da página
        $mpdf->SetHTMLFooter('
            <table style="width:1080px; border-top: 1px solid #000000; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                <tr>
                    <td width="200px">São Luis(MA) {DATE d/m/Y H:i}</td>
                    <td width="830px" align="left">
                        <span style="margin-right: 50px"><strong>Und.</strong> = unidade de medida;</span>
                        <span style="margin-right: 50px"><strong>nº vz</strong> = número de vezes comprado;</span>
                        <span style="margin-right: 50px"><strong>Qtd.</strong> = quantidade comprada;</span>
                        <span style="margin-right: 50px"><strong>p.m</strong> = preço médio;</span>
                    </td>
                    <td width="50px" align="right">{PAGENO}/{nbpg}</td>
                </tr>
            </table>
        ');


        // Definindo a view que deverá ser renderizada como arquivo .pdf e passando os dados da pesquisa
        $html = \View::make('admin.registrocompra.pdf.pdfmapamensalcategoriamunicipio', compact('records'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.categoria.pdf.pdfproduto')
        $stylesheet = file_get_contents('pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }






    // Relatório PDF Mapa mensal de categoria de produtos adquiridos por unidade na regional
    public function relpdfmapamensalcategoriaregional($regi, $mes, $ano)
    {
        // Meses para compor cabeçalho do relatório
        $meses = [
            '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
            '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
        ];

        $regional = Regional::findOrFail($regi);

        $regionalId = $regional->id;

        // Obtendo os dados
        $records = Bigtabledata::mapamensalcategoriaregional($regionalId, $mes, $ano);

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('mapamensalcategoriaregional'.'.pdf');

        // Invocando a biblioteca mpdf e definindo as margens do arquivo
        $mpdf = new \Mpdf\Mpdf([
            'orientation' => 'L',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 43,
            'margin_bottom' => 15,
            'margin-header' => 10,
            'margin_footer' => 5
        ]);

        // Configurando o cabeçalho da página
        $mpdf->SetHTMLHeader('
            <table style="width:1080px; border-bottom: 1px solid #000000; margin-bottom: 3px;">
                <tr>
                    <td style="width: 108px">
                        <img src="images/logo-ma.png" width="100"/>
                    </td>
                    <td style="width: 432px; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                        Governo do Estado do Maranhão<br>
                        Secretaria de Governo<br>
                        Secreatia Adjunta de Tecnologia da Informação/SEATI<br>
                        Secretaria do Estado de Desenvolvimento Social/SEDES
                    </td>
                    <td style="width: 540px;" class="titulo-rel">
                        MAPA MENSAL DE PRODUTOS ADQUIRIDOS POR CATEGORIA EM UNIDADE <br> Região '.$records[0]->regional_nome.': '.$meses[$mes].'/'.$ano.'
                    </td>
                </tr>
            </table>

            <table style="width:1080px; border-collapse: collapse">
                <tr>
                    <td rowspan="3" width="40px" class="col-header-table" style="text-align: center">Id</td>
                    <td rowspan="3" width="280px" class="col-header-table" style="text-align: center">Categoria</td>
                    <td rowspan="3" width="40px" class="col-header-table" style="text-align: center">Und.</td>
                    <td colspan="8" width="480px" class="col-header-table" style="text-align: center">COMPRAS</td>
                    <td rowspan="2" colspan="2" width="120px" class="col-header-table" style="text-align: center">TOTAL</td>
                    <td rowspan="2" colspan="2" width="120px" class="col-header-table" style="text-align: center"> &#177; (%) AF</td>
                </tr>
                <tr>
                    <td colspan="4" width="240px" class="col-header-table" style="text-align: center">Normal</td>
                    <td colspan="4" width="240px" class="col-header-table" style="text-align: center">AF</td>
                </tr>
                <tr>
                    <td width="50px" class="col-header-table" style="text-align: center">nº vz</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="70px" class="col-header-table" style="text-align: center">p.m (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">nº vz</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="70px" class="col-header-table" style="text-align: center">p.m (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">% Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">% Valor (R$)</td>
                </tr>
            </table>
        ');

        // Configurando o rodapé da página
        $mpdf->SetHTMLFooter('
            <table style="width:1080px; border-top: 1px solid #000000; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                <tr>
                    <td width="200px">São Luis(MA) {DATE d/m/Y H:i}</td>
                    <td width="830px" align="left">
                        <span style="margin-right: 50px"><strong>Und.</strong> = unidade de medida;</span>
                        <span style="margin-right: 50px"><strong>nº vz</strong> = número de vezes comprado;</span>
                        <span style="margin-right: 50px"><strong>Qtd.</strong> = quantidade comprada;</span>
                        <span style="margin-right: 50px"><strong>p.m</strong> = preço médio;</span>
                    </td>
                    <td width="50px" align="right">{PAGENO}/{nbpg}</td>
                </tr>
            </table>
        ');


        // Definindo a view que deverá ser renderizada como arquivo .pdf e passando os dados da pesquisa
        $html = \View::make('admin.registrocompra.pdf.pdfmapamensalcategoriaregional', compact('records'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.categoria.pdf.pdfcategoria')
        $stylesheet = file_get_contents('pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }




    // Relatório PDF Mapa mensal geral de produtos adquiridos por Categoria em unidade
    public function relpdfmapamensalgeralcategoria($mes, $ano)
    {
        // Meses para compor cabeçalho do relatório
        $meses = [
            '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
            '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
        ];


        // Obtendo os dados
        $records = Bigtabledata::mapamensalgeralcategoria($mes, $ano);

        //Crio uma coleção
        $regionaisnome = collect();
        foreach($records as $record) {
            //Adiciona à coleção criada, apenas o nome das regionais, duplicadas ou não
            $regionaisnome->push($record->regional_nome);
        }
        //Recupero o nome das regionais de forma única em uma outra collection
        $regionaisenvolvidas = $regionaisnome->unique();

        //Junto os elementos da colection como uma string ligadas por uma vírgula
        $regionais = $regionaisenvolvidas->join(', ');


        // Definindo o nome do arquivo a ser baixado
        $fileName = ('mapamensalgeralcategoria'.'.pdf');

        // Invocando a biblioteca mpdf e definindo as margens do arquivo
        $mpdf = new \Mpdf\Mpdf([
            'orientation' => 'L',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 47,
            'margin_bottom' => 15,
            'margin-header' => 10,
            'margin_footer' => 5
        ]);

        // Configurando o cabeçalho da página
        $mpdf->SetHTMLHeader('
            <table style="width:1080px; border-bottom: 1px solid #000000; margin-bottom: 3px;">
                <tr>
                    <td style="width: 108px">
                        <img src="images/logo-ma.png" width="100"/>
                    </td>
                    <td style="width: 432px; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                        Governo do Estado do Maranhão<br>
                        Secretaria de Governo<br>
                        Secreatia Adjunta de Tecnologia da Informação/SEATI<br>
                        Secretaria do Estado de Desenvolvimento Social/SEDES
                    </td>
                    <td style="width: 540px;" class="titulo-rel">
                        MAPA MENSAL GERAL DE PRODUTOS ADQUIRIDOS POR CATEGORIA <br>'.$meses[$mes].'/'.$ano.'
                    </td>
                </tr>
            </table>

            <table style="width:1080px; border-collapse: collapse">
                <tr>
                    <td colspan="21" width="1080px" class="col-header-table" style="text-left: center"><strong>Regiões: </strong>'.$regionais.'</td>
                </tr>
            </table>

            <table style="width:1080px; border-collapse: collapse">
                <tr>
                    <td rowspan="3" width="40px" class="col-header-table" style="text-align: center">Id</td>
                    <td rowspan="3" width="280px" class="col-header-table" style="text-align: center">Produto</td>
                    <td rowspan="3" width="40px" class="col-header-table" style="text-align: center">Und.</td>
                    <td colspan="8" width="480px" class="col-header-table" style="text-align: center">COMPRAS</td>
                    <td rowspan="2" colspan="2" width="120px" class="col-header-table" style="text-align: center">TOTAL</td>
                    <td rowspan="2" colspan="2" width="120px" class="col-header-table" style="text-align: center"> &#177; (%) AF</td>
                </tr>
                <tr>
                    <td colspan="4" width="240px" class="col-header-table" style="text-align: center">Normal</td>
                    <td colspan="4" width="240px" class="col-header-table" style="text-align: center">AF</td>
                </tr>
                <tr>
                    <td width="50px" class="col-header-table" style="text-align: center">nº vz</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="70px" class="col-header-table" style="text-align: center">p.m (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">nº vz</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="70px" class="col-header-table" style="text-align: center">p.m (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">% Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">% Valor (R$)</td>
                </tr>
            </table>
        ');

        // Configurando o rodapé da página
        $mpdf->SetHTMLFooter('
            <table style="width:1080px; border-top: 1px solid #000000; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                <tr>
                    <td width="200px">São Luis(MA) {DATE d/m/Y H:i}</td>
                    <td width="830px" align="left">
                        <span style="margin-right: 50px"><strong>Und.</strong> = unidade de medida;</span>
                        <span style="margin-right: 50px"><strong>nº vz</strong> = número de vezes comprado;</span>
                        <span style="margin-right: 50px"><strong>Qtd.</strong> = quantidade comprada;</span>
                        <span style="margin-right: 50px"><strong>p.m</strong> = preço médio;</span>
                    </td>
                    <td width="50px" align="right">{PAGENO}/{nbpg}</td>
                </tr>
            </table>
        ');


        // Definindo a view que deverá ser renderizada como arquivo .pdf e passando os dados da pesquisa
        $html = \View::make('admin.registrocompra.pdf.pdfmapamensalgeralcategoria', compact('records'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.categoria.pdf.pdfcategoria')
        $stylesheet = file_get_contents('pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }






    // Relatório PDF Comparativo mensal de produtos adquiridos no municipio
    public function relpdfcomparativomensalprodutomunicipio($prod, $medi, $muni, $mes, $ano)
    {
        // Meses para compor cabeçalho do relatório
        $meses = [
            '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
            '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
        ];

        $municipio = Municipio::findOrFail($muni);

        $municipioId = $municipio->id;

        // Obtendo os dados
        $records = Bigtabledata::comparativomensalprodutomunicipio($prod, $medi, $municipioId, $mes, $ano);

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('comparativomensalprodutomunicipio'.'.pdf');

        // Invocando a biblioteca mpdf e definindo as margens do arquivo
        $mpdf = new \Mpdf\Mpdf([
            'orientation' => 'L',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 43,
            'margin_bottom' => 15,
            'margin-header' => 10,
            'margin_footer' => 5
        ]);

        // Configurando o cabeçalho da página
        $mpdf->SetHTMLHeader('
            <table style="width:1080px; border-bottom: 1px solid #000000; margin-bottom: 3px;">
                <tr>
                    <td style="width: 108px">
                        <img src="images/logo-ma.png" width="100"/>
                    </td>
                    <td style="width: 432px; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                        Governo do Estado do Maranhão<br>
                        Secretaria de Governo<br>
                        Secreatia Adjunta de Tecnologia da Informação/SEATI<br>
                        Secretaria do Estado de Desenvolvimento Social/SEDES
                    </td>
                    <td style="width: 540px;" class="titulo-rel">
                        COMPARATIVO MENSAL DE PRODUTOS ADQUIRIDOS NO MUNICÍPIO <br>'.$records[0]->municipio_nome.': '.$meses[$mes].'/'.$ano.' - '.Str::upper($records[0]->produto_nome).' ('.Str::upper($records[0]->medida_simbolo).')
                    </td>
                </tr>
            </table>

            <table style="width:1080px; border-collapse: collapse">
                <tr>
                    <td rowspan="3" width="40px" class="col-header-table" style="text-align: center">Id</td>
                    <td rowspan="3" width="320px" class="col-header-table" style="text-align: center">Restaurantes</td>
                    <td colspan="8" width="480px" class="col-header-table" style="text-align: center">COMPRAS</td>
                    <td rowspan="2" colspan="2" width="120px" class="col-header-table" style="text-align: center">TOTAL</td>
                    <td rowspan="2" colspan="2" width="120px" class="col-header-table" style="text-align: center"> &#177; (%) AF</td>
                </tr>
                <tr>
                    <td colspan="4" width="240px" class="col-header-table" style="text-align: center">Normal</td>
                    <td colspan="4" width="240px" class="col-header-table" style="text-align: center">AF</td>
                </tr>
                <tr>
                    <td width="50px" class="col-header-table" style="text-align: center">nº vz</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="70px" class="col-header-table" style="text-align: center">p.m (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">nº vz</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="70px" class="col-header-table" style="text-align: center">p.m (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">% Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">% Valor (R$)</td>
                </tr>
            </table>
        ');

        // Configurando o rodapé da página
        $mpdf->SetHTMLFooter('
            <table style="width:1080px; border-top: 1px solid #000000; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                <tr>
                    <td width="200px">São Luis(MA) {DATE d/m/Y H:i}</td>
                    <td width="830px" align="left">
                        <span style="margin-right: 50px"><strong>Und.</strong> = unidade de medida;</span>
                        <span style="margin-right: 50px"><strong>nº vz</strong> = número de vezes comprado;</span>
                        <span style="margin-right: 50px"><strong>Qtd.</strong> = quantidade comprada;</span>
                        <span style="margin-right: 50px"><strong>p.m</strong> = preço médio;</span>
                    </td>
                    <td width="50px" align="right">{PAGENO}/{nbpg}</td>
                </tr>
            </table>
        ');


        // Definindo a view que deverá ser renderizada como arquivo .pdf e passando os dados da pesquisa
        $html = \View::make('admin.registrocompra.pdf.pdfcomparativomensalprodutomunicipio', compact('records'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.produto.pdf.pdfproduto')
        $stylesheet = file_get_contents('pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }



    // Relatório PDF Comparativo mensal de produtos adquiridos na regional
    public function relpdfcomparativomensalprodutoregional($prod, $medi, $regi, $mes, $ano)
    {
        // Meses para compor cabeçalho do relatório
        $meses = [
            '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
            '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
        ];

        $regional = Regional::findOrFail($regi);

        $regionalId = $regional->id;

        // Obtendo os dados
        $records = Bigtabledata::comparativomensalprodutoregional($prod, $medi, $regionalId, $mes, $ano);

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('comparativomensalprodutoregional'.'.pdf');

        // Invocando a biblioteca mpdf e definindo as margens do arquivo
        $mpdf = new \Mpdf\Mpdf([
            'orientation' => 'L',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 43,
            'margin_bottom' => 15,
            'margin-header' => 10,
            'margin_footer' => 5
        ]);

        // Configurando o cabeçalho da página
        $mpdf->SetHTMLHeader('
            <table style="width:1080px; border-bottom: 1px solid #000000; margin-bottom: 3px;">
                <tr>
                    <td style="width: 108px">
                        <img src="images/logo-ma.png" width="100"/>
                    </td>
                    <td style="width: 432px; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                        Governo do Estado do Maranhão<br>
                        Secretaria de Governo<br>
                        Secreatia Adjunta de Tecnologia da Informação/SEATI<br>
                        Secretaria do Estado de Desenvolvimento Social/SEDES
                    </td>
                    <td style="width: 540px;" class="titulo-rel">
                        COMPARATIVO MENSAL DE PRODUTOS ADQUIRIDOS NA REGIONAL <br>'.$records[0]->regional_nome.': '.$meses[$mes].'/'.$ano.' - '.Str::upper($records[0]->produto_nome).' ('.Str::upper($records[0]->medida_simbolo).')
                    </td>
                </tr>
            </table>

            <table style="width:1080px; border-collapse: collapse">
                <tr>
                    <td rowspan="3" width="40px" class="col-header-table" style="text-align: center">Id</td>
                    <td rowspan="3" width="320px" class="col-header-table" style="text-align: center">Municípios</td>
                    <td colspan="8" width="480px" class="col-header-table" style="text-align: center">COMPRAS</td>
                    <td rowspan="2" colspan="2" width="120px" class="col-header-table" style="text-align: center">TOTAL</td>
                    <td rowspan="2" colspan="2" width="120px" class="col-header-table" style="text-align: center"> &#177; (%) AF</td>
                </tr>
                <tr>
                    <td colspan="4" width="240px" class="col-header-table" style="text-align: center">Normal</td>
                    <td colspan="4" width="240px" class="col-header-table" style="text-align: center">AF</td>
                </tr>
                <tr>
                    <td width="50px" class="col-header-table" style="text-align: center">nº vz</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="70px" class="col-header-table" style="text-align: center">p.m (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">nº vz</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="70px" class="col-header-table" style="text-align: center">p.m (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">% Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">% Valor (R$)</td>
                </tr>
            </table>
        ');

        // Configurando o rodapé da página
        $mpdf->SetHTMLFooter('
            <table style="width:1080px; border-top: 1px solid #000000; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                <tr>
                    <td width="200px">São Luis(MA) {DATE d/m/Y H:i}</td>
                    <td width="830px" align="left">
                        <span style="margin-right: 50px"><strong>Und.</strong> = unidade de medida;</span>
                        <span style="margin-right: 50px"><strong>nº vz</strong> = número de vezes comprado;</span>
                        <span style="margin-right: 50px"><strong>Qtd.</strong> = quantidade comprada;</span>
                        <span style="margin-right: 50px"><strong>p.m</strong> = preço médio;</span>
                    </td>
                    <td width="50px" align="right">{PAGENO}/{nbpg}</td>
                </tr>
            </table>
        ');


        // Definindo a view que deverá ser renderizada como arquivo .pdf e passando os dados da pesquisa
        $html = \View::make('admin.registrocompra.pdf.pdfcomparativomensalprodutoregional', compact('records'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.produto.pdf.pdfproduto')
        $stylesheet = file_get_contents('pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }






    // Relatório PDF Comparativo mensal Geral de produtos adquirido
    public function relpdfcomparativomensalgeralproduto($prod, $medi, $mes, $ano)
    {
        // Meses para compor cabeçalho do relatório
        $meses = [
            '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
            '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
        ];

        // Obtendo os dados
        $records = Bigtabledata::comparativomensalgeralproduto($prod, $medi, $mes, $ano);

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('comparativomensalgeralproduto'.'.pdf');

        // Invocando a biblioteca mpdf e definindo as margens do arquivo
        $mpdf = new \Mpdf\Mpdf([
            'orientation' => 'L',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 43,
            'margin_bottom' => 15,
            'margin-header' => 10,
            'margin_footer' => 5
        ]);

        // Configurando o cabeçalho da página
        $mpdf->SetHTMLHeader('
            <table style="width:1080px; border-bottom: 1px solid #000000; margin-bottom: 3px;">
                <tr>
                    <td style="width: 108px">
                        <img src="images/logo-ma.png" width="100"/>
                    </td>
                    <td style="width: 432px; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                        Governo do Estado do Maranhão<br>
                        Secretaria de Governo<br>
                        Secreatia Adjunta de Tecnologia da Informação/SEATI<br>
                        Secretaria do Estado de Desenvolvimento Social/SEDES
                    </td>
                    <td style="width: 540px;" class="titulo-rel">
                        COMPARATIVO MENSAL DE PRODUTO ADQUIRIDO<br> Todas as Regionais em '.$meses[$mes].'/'.$ano.' - '.Str::upper($records[0]->produto_nome).' ('.Str::upper($records[0]->medida_simbolo).')
                    </td>
                </tr>
            </table>

            <table style="width:1080px; border-collapse: collapse">
                <tr>
                    <td rowspan="3" width="40px" class="col-header-table" style="text-align: center">Id</td>
                    <td rowspan="3" width="320px" class="col-header-table" style="text-align: center">Regionais</td>
                    <td colspan="8" width="480px" class="col-header-table" style="text-align: center">COMPRAS</td>
                    <td rowspan="2" colspan="2" width="120px" class="col-header-table" style="text-align: center">TOTAL</td>
                    <td rowspan="2" colspan="2" width="120px" class="col-header-table" style="text-align: center"> &#177; (%) AF</td>
                </tr>
                <tr>
                    <td colspan="4" width="240px" class="col-header-table" style="text-align: center">Normal</td>
                    <td colspan="4" width="240px" class="col-header-table" style="text-align: center">AF</td>
                </tr>
                <tr>
                    <td width="50px" class="col-header-table" style="text-align: center">nº vz</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="70px" class="col-header-table" style="text-align: center">p.m (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">nº vz</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="70px" class="col-header-table" style="text-align: center">p.m (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">% Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">% Valor (R$)</td>
                </tr>
            </table>
        ');

        // Configurando o rodapé da página
        $mpdf->SetHTMLFooter('
            <table style="width:1080px; border-top: 1px solid #000000; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                <tr>
                    <td width="200px">São Luis(MA) {DATE d/m/Y H:i}</td>
                    <td width="830px" align="left">
                        <span style="margin-right: 50px"><strong>Und.</strong> = unidade de medida;</span>
                        <span style="margin-right: 50px"><strong>nº vz</strong> = número de vezes comprado;</span>
                        <span style="margin-right: 50px"><strong>Qtd.</strong> = quantidade comprada;</span>
                        <span style="margin-right: 50px"><strong>p.m</strong> = preço médio;</span>
                    </td>
                    <td width="50px" align="right">{PAGENO}/{nbpg}</td>
                </tr>
            </table>
        ');


        // Definindo a view que deverá ser renderizada como arquivo .pdf e passando os dados da pesquisa
        $html = \View::make('admin.registrocompra.pdf.pdfcomparativomensalgeralproduto', compact('records'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.produto.pdf.pdfproduto')
        $stylesheet = file_get_contents('pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }




    //########### INICIO REL's PDF's COMPARATIVO CATEGORIA

    // Relatório PDF Comparativo mensal de categorias adquiridas no municipio
    public function relpdfcomparativomensalcategoriamunicipio($categ, $medi, $muni, $mes, $ano)
    {
        // Meses para compor cabeçalho do relatório
        $meses = [
            '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
            '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
        ];

        $municipio = Municipio::findOrFail($muni);

        $municipioId = $municipio->id;

        // Obtendo os dados
        $records = Bigtabledata::comparativomensalcategoriamunicipio($categ, $medi, $municipioId, $mes, $ano);

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('comparativomensalcategoriamunicipio'.'.pdf');

        // Invocando a biblioteca mpdf e definindo as margens do arquivo
        $mpdf = new \Mpdf\Mpdf([
            'orientation' => 'L',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 43,
            'margin_bottom' => 15,
            'margin-header' => 10,
            'margin_footer' => 5
        ]);

        // Configurando o cabeçalho da página
        $mpdf->SetHTMLHeader('
            <table style="width:1080px; border-bottom: 1px solid #000000; margin-bottom: 3px;">
                <tr>
                    <td style="width: 108px">
                        <img src="images/logo-ma.png" width="100"/>
                    </td>
                    <td style="width: 432px; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                        Governo do Estado do Maranhão<br>
                        Secretaria de Governo<br>
                        Secreatia Adjunta de Tecnologia da Informação/SEATI<br>
                        Secretaria do Estado de Desenvolvimento Social/SEDES
                    </td>
                    <td style="width: 540px;" class="titulo-rel">
                        COMPARATIVO MENSAL DE CATEGORIAS ADQUIRIDAS NO MUNICÍPIO <br>'.$records[0]->municipio_nome.': '.$meses[$mes].'/'.$ano.' - '.Str::upper($records[0]->categoria_nome).' ('.Str::upper($records[0]->medida_simbolo).')
                    </td>
                </tr>
            </table>

            <table style="width:1080px; border-collapse: collapse">
                <tr>
                    <td rowspan="3" width="40px" class="col-header-table" style="text-align: center">Id</td>
                    <td rowspan="3" width="320px" class="col-header-table" style="text-align: center">Restaurantes</td>
                    <td colspan="8" width="480px" class="col-header-table" style="text-align: center">COMPRAS</td>
                    <td rowspan="2" colspan="2" width="120px" class="col-header-table" style="text-align: center">TOTAL</td>
                    <td rowspan="2" colspan="2" width="120px" class="col-header-table" style="text-align: center"> &#177; (%) AF</td>
                </tr>
                <tr>
                    <td colspan="4" width="240px" class="col-header-table" style="text-align: center">Normal</td>
                    <td colspan="4" width="240px" class="col-header-table" style="text-align: center">AF</td>
                </tr>
                <tr>
                    <td width="50px" class="col-header-table" style="text-align: center">nº vz</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="70px" class="col-header-table" style="text-align: center">p.m (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">nº vz</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="70px" class="col-header-table" style="text-align: center">p.m (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">% Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">% Valor (R$)</td>
                </tr>
            </table>
        ');

        // Configurando o rodapé da página
        $mpdf->SetHTMLFooter('
            <table style="width:1080px; border-top: 1px solid #000000; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                <tr>
                    <td width="200px">São Luis(MA) {DATE d/m/Y H:i}</td>
                    <td width="830px" align="left">
                        <span style="margin-right: 50px"><strong>Und.</strong> = unidade de medida;</span>
                        <span style="margin-right: 50px"><strong>nº vz</strong> = número de vezes comprado;</span>
                        <span style="margin-right: 50px"><strong>Qtd.</strong> = quantidade comprada;</span>
                        <span style="margin-right: 50px"><strong>p.m</strong> = preço médio;</span>
                    </td>
                    <td width="50px" align="right">{PAGENO}/{nbpg}</td>
                </tr>
            </table>
        ');


        // Definindo a view que deverá ser renderizada como arquivo .pdf e passando os dados da pesquisa
        $html = \View::make('admin.registrocompra.pdf.pdfcomparativomensalcategoriamunicipio', compact('records'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.categoria.pdf.pdfcategoria')
        $stylesheet = file_get_contents('pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }



    // Relatório PDF Comparativo mensal de categorias adquiridas na regional
    public function relpdfcomparativomensalcategoriaregional($categ, $medi, $regi, $mes, $ano)
    {
        // Meses para compor cabeçalho do relatório
        $meses = [
            '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
            '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
        ];

        $regional = Regional::findOrFail($regi);

        $regionalId = $regional->id;

        // Obtendo os dados
        $records = Bigtabledata::comparativomensalcategoriaregional($categ, $medi, $regionalId, $mes, $ano);

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('comparativomensalcategoriaregional'.'.pdf');

        // Invocando a biblioteca mpdf e definindo as margens do arquivo
        $mpdf = new \Mpdf\Mpdf([
            'orientation' => 'L',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 43,
            'margin_bottom' => 15,
            'margin-header' => 10,
            'margin_footer' => 5
        ]);

        // Configurando o cabeçalho da página
        $mpdf->SetHTMLHeader('
            <table style="width:1080px; border-bottom: 1px solid #000000; margin-bottom: 3px;">
                <tr>
                    <td style="width: 108px">
                        <img src="images/logo-ma.png" width="100"/>
                    </td>
                    <td style="width: 432px; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                        Governo do Estado do Maranhão<br>
                        Secretaria de Governo<br>
                        Secreatia Adjunta de Tecnologia da Informação/SEATI<br>
                        Secretaria do Estado de Desenvolvimento Social/SEDES
                    </td>
                    <td style="width: 540px;" class="titulo-rel">
                        COMPARATIVO MENSAL DE CATEGORIAS ADQUIRIDAS NA REGIONAL <br>'.$records[0]->regional_nome.': '.$meses[$mes].'/'.$ano.' - '.Str::upper($records[0]->categoria_nome).' ('.Str::upper($records[0]->medida_simbolo).')
                    </td>
                </tr>
            </table>

            <table style="width:1080px; border-collapse: collapse">
                <tr>
                    <td rowspan="3" width="40px" class="col-header-table" style="text-align: center">Id</td>
                    <td rowspan="3" width="320px" class="col-header-table" style="text-align: center">Municípios</td>
                    <td colspan="8" width="480px" class="col-header-table" style="text-align: center">COMPRAS</td>
                    <td rowspan="2" colspan="2" width="120px" class="col-header-table" style="text-align: center">TOTAL</td>
                    <td rowspan="2" colspan="2" width="120px" class="col-header-table" style="text-align: center"> &#177; (%) AF</td>
                </tr>
                <tr>
                    <td colspan="4" width="240px" class="col-header-table" style="text-align: center">Normal</td>
                    <td colspan="4" width="240px" class="col-header-table" style="text-align: center">AF</td>
                </tr>
                <tr>
                    <td width="50px" class="col-header-table" style="text-align: center">nº vz</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="70px" class="col-header-table" style="text-align: center">p.m (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">nº vz</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="70px" class="col-header-table" style="text-align: center">p.m (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">% Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">% Valor (R$)</td>
                </tr>
            </table>
        ');

        // Configurando o rodapé da página
        $mpdf->SetHTMLFooter('
            <table style="width:1080px; border-top: 1px solid #000000; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                <tr>
                    <td width="200px">São Luis(MA) {DATE d/m/Y H:i}</td>
                    <td width="830px" align="left">
                        <span style="margin-right: 50px"><strong>Und.</strong> = unidade de medida;</span>
                        <span style="margin-right: 50px"><strong>nº vz</strong> = número de vezes comprado;</span>
                        <span style="margin-right: 50px"><strong>Qtd.</strong> = quantidade comprada;</span>
                        <span style="margin-right: 50px"><strong>p.m</strong> = preço médio;</span>
                    </td>
                    <td width="50px" align="right">{PAGENO}/{nbpg}</td>
                </tr>
            </table>
        ');


        // Definindo a view que deverá ser renderizada como arquivo .pdf e passando os dados da pesquisa
        $html = \View::make('admin.registrocompra.pdf.pdfcomparativomensalcategoriaregional', compact('records'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.categoria.pdf.pdfcategoria')
        $stylesheet = file_get_contents('pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }


    // Relatório PDF Comparativo mensal Geral de categorias adquirida
    public function relpdfcomparativomensalgeralcategoria($categ, $medi, $mes, $ano)
    {
        // Meses para compor cabeçalho do relatório
        $meses = [
            '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
            '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
        ];

        // Obtendo os dados
        $records = Bigtabledata::comparativomensalgeralcategoria($categ, $medi, $mes, $ano);

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('comparativomensalgeralcategoria'.'.pdf');

        // Invocando a biblioteca mpdf e definindo as margens do arquivo
        $mpdf = new \Mpdf\Mpdf([
            'orientation' => 'L',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 43,
            'margin_bottom' => 15,
            'margin-header' => 10,
            'margin_footer' => 5
        ]);

        // Configurando o cabeçalho da página
        $mpdf->SetHTMLHeader('
            <table style="width:1080px; border-bottom: 1px solid #000000; margin-bottom: 3px;">
                <tr>
                    <td style="width: 108px">
                        <img src="images/logo-ma.png" width="100"/>
                    </td>
                    <td style="width: 432px; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                        Governo do Estado do Maranhão<br>
                        Secretaria de Governo<br>
                        Secreatia Adjunta de Tecnologia da Informação/SEATI<br>
                        Secretaria do Estado de Desenvolvimento Social/SEDES
                    </td>
                    <td style="width: 540px;" class="titulo-rel">
                        COMPARATIVO MENSAL DE CATEGORIA ADQUIRIDA<br> Todas as Regionais em '.$meses[$mes].'/'.$ano.' - '.Str::upper($records[0]->categoria_nome).' ('.Str::upper($records[0]->medida_simbolo).')
                    </td>
                </tr>
            </table>

            <table style="width:1080px; border-collapse: collapse">
                <tr>
                    <td rowspan="3" width="40px" class="col-header-table" style="text-align: center">Id</td>
                    <td rowspan="3" width="320px" class="col-header-table" style="text-align: center">Regionais</td>
                    <td colspan="8" width="480px" class="col-header-table" style="text-align: center">COMPRAS</td>
                    <td rowspan="2" colspan="2" width="120px" class="col-header-table" style="text-align: center">TOTAL</td>
                    <td rowspan="2" colspan="2" width="120px" class="col-header-table" style="text-align: center"> &#177; (%) AF</td>
                </tr>
                <tr>
                    <td colspan="4" width="240px" class="col-header-table" style="text-align: center">Normal</td>
                    <td colspan="4" width="240px" class="col-header-table" style="text-align: center">AF</td>
                </tr>
                <tr>
                    <td width="50px" class="col-header-table" style="text-align: center">nº vz</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="70px" class="col-header-table" style="text-align: center">p.m (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">nº vz</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="70px" class="col-header-table" style="text-align: center">p.m (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">Valor (R$)</td>
                    <td width="50px" class="col-header-table" style="text-align: center">% Qtd.</td>
                    <td width="70px" class="col-header-table" style="text-align: center">% Valor (R$)</td>
                </tr>
            </table>
        ');

        // Configurando o rodapé da página
        $mpdf->SetHTMLFooter('
            <table style="width:1080px; border-top: 1px solid #000000; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                <tr>
                    <td width="200px">São Luis(MA) {DATE d/m/Y H:i}</td>
                    <td width="830px" align="left">
                        <span style="margin-right: 50px"><strong>Und.</strong> = unidade de medida;</span>
                        <span style="margin-right: 50px"><strong>nº vz</strong> = número de vezes comprado;</span>
                        <span style="margin-right: 50px"><strong>Qtd.</strong> = quantidade comprada;</span>
                        <span style="margin-right: 50px"><strong>p.m</strong> = preço médio;</span>
                    </td>
                    <td width="50px" align="right">{PAGENO}/{nbpg}</td>
                </tr>
            </table>
        ');


        // Definindo a view que deverá ser renderizada como arquivo .pdf e passando os dados da pesquisa
        $html = \View::make('admin.registrocompra.pdf.pdfcomparativomensalgeralcategoria', compact('records'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.categoria.pdf.pdfcategoria')
        $stylesheet = file_get_contents('pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }



}
