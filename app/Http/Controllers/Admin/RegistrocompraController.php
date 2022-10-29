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
            //$records = DB::table('bigtable_data')->get();
            //$records = DB::table('bigtable_data')->where('restaurante_id', '=', 1)->where('categoria_id', '=', 1)->get();
            //$records = DB::table('bigtable_data')->where('restaurante_id', '=', 1)->where('semana', '=', 1)->get();

            //$records = Bigtabledata::comprasDoMes(1, 10);
            $records = Bigtabledata::comprasMes(1, 10);

            // Recupera só as datas inicial e final de todas as compras retornadas em "$records" e atribui a um array
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
