<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
class RegistrocompraController extends Controller
{
    public function index()
    {
        // Se ADMINISTRADOR, visualiza todos os RESTAURANTES, e a partir destes, vai para o processo de COMPRA, caso contrário irá presquisar apenas
        // o(s) restaurante(s) da NUTRICIONISTA responsável(logada) no momento.
        // if(Auth::user()->perfil == 'adm' && Auth::user()->ativo == 1 ){
        if(Auth::user()->perfil == 'adm'){
            $restaurantes = Restaurante::with(['municipio', 'bairro', 'empresa', 'nutricionista', 'user', 'compras'])->orderBy('identificacao', 'ASC')->get();

            return view('admin.registrocompra.index', compact('restaurantes'));

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
            $compras = Compra::where('restaurante_id', '=', $restaurante->id)->orderBy('data_ini', 'DESC')->get();


            return view('admin.compra.index', compact('restaurante', 'compras'));

        //else
        // return view('uma view informando que o usuário não está ativo embora esteja cadastrado no sitema')
        }

    }

    public function search()
    {
        if(Auth::user()->perfil == 'adm') {

            $records = Bigtabledata::comprasDoMes(1, 10);
            return view('admin.registrocompra.search', compact('records'));

        } else {
            //Fazer um teste aqui, se o usuário logado está ativo (depois de incluir esse campo na tabela e no model User)
            //if( Auth::user()->ativo == 'sim') { fazer uma coisa } else { fazer outra coisa }

            //Recupera o restaurante do usuário-nutricionista logado. ->first(), porque um usuário é responsável por um único restaurante.
            $restaurante = Restaurante::where('user_id', '=', Auth::user()->id)->first();

            //Recupera só o id do restaurante
            $restauranteId =  $restaurante->id;

            $records = Bigtabledata::comprasMes($restauranteId, 10);

            if($records->count() > 0){

                // Criando um array para deposita todas as datas inicial e final das compras retornadas em "$records"
                $arrDatasIniFin = [];
                
                // Variáveis para calcular totais
                $somapreco = 0;
                $somaprecoaf = 0;
                $somafinal = 0;
                
                foreach($records as $datarecords) {
                    // populando array com datainicial e datafinal
                    $arrDatasIniFin[] = $datarecords->data_ini;
                    $arrDatasIniFin[] = $datarecords->data_fin;
                
                    // somatório preco normal e precoaf
                    $somapreco += $datarecords->af == 'nao' ? $datarecords->precototal : 0; 
                    $somaprecoaf += $datarecords->af == 'sim' ? $datarecords->precototal : 0; 
                }
    
                $somafinal += ($somapreco + $somaprecoaf);
    
                // Atribuindo a menor e a maior data (do array de datas "$arrDatasIniFin") para data inicial e data final
                $dataInicial =  min($arrDatasIniFin);
                $dataFinal = max($arrDatasIniFin);
    
                return view('admin.registrocompra.consultasnut.comprasmes', compact('records', 'dataInicial', 'dataFinal', 'somapreco', 'somaprecoaf', 'somafinal'));
                
            }     
        }
    }



    /***************************************/
    /*    RELATÓRIOS PDF's, Excel e CSV    */
    /***************************************/

    public function relpdfcomprasmes($restauranteId)
    {
        // Obtendo os dados
        $records = Bigtabledata::comprasMes($restauranteId, 10);

        // Criando um array para deposita todas as datas inicial e final das compras retornadas em "$records"
        $arrDatasIniFin = [];
                
        // Variáveis para calcular totais
        $somapreco = 0;
        $somaprecoaf = 0;
        $somafinal = 0;
        
        foreach($records as $datarecords) {
            // populando array com datainicial e datafinal
            $arrDatasIniFin[] = $datarecords->data_ini;
            $arrDatasIniFin[] = $datarecords->data_fin;
        
            // somatório preco normal e precoaf
            $somapreco += $datarecords->af == 'nao' ? $datarecords->precototal : 0; 
            $somaprecoaf += $datarecords->af == 'sim' ? $datarecords->precototal : 0; 
        }

        $somafinal += ($somapreco + $somaprecoaf);

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
            'margin_top' => 58,
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
                        '.$records[0]->identificacao.' <br> mês nº 10
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
                    <td style="width: 100px;" class="label-ficha">Valor AF (%)</td>
                    <td style="width: 100px;" class="label-ficha">Valor Total</td>
                </tr>
                <tr>
                    <td style="width: 417px;" class="dados-ficha">'.$records[0]->identificacao.'</td>
                    <td style="width: 100px; text-align:right" class="dados-ficha">'.$somapreco.'</td>
                    <td style="width: 100px; text-align:right" class="dados-ficha">'.$somaprecoaf.'</td>
                    <td style="width: 100px; text-align:right" class="dados-ficha">'.$somafinal.'</td>
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
        $html = \View::make('admin.registrocompra.pdf.pdfcomprasmes', compact('records', 'somapreco', 'somaprecoaf', 'somafinal'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.produto.pdf.pdfproduto')
        $stylesheet = file_get_contents('pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }
}
