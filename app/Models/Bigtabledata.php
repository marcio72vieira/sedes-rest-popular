<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Bigtabledata extends Model
{
    use HasFactory;

    protected $table = "bigtable_data";


    public static function comprasDoMes($restauranteId, $mes)
    {

        $records = DB::table('bigtable_data')->where('restaurante_id', '=', $restauranteId)->whereMonth('data_ini', $mes)->get();

        return $records;
    }

    public static function comprasMes($restauranteId, $mes, $ano)
    {
        // $dia = date("d"); $mes = date("m"); $ano = date("Y");

        $records = DB::table('bigtable_data')->where('restaurante_id', '=', $restauranteId)->whereMonth('data_ini', $mes)->whereYear('data_ini', $ano)->orderBy('semana', 'ASC')->get();

        return $records;
    }


    public static function compramensal($restauranteId, $mes, $ano)
    {

        $records = DB::table('bigtable_data')->where('restaurante_id', '=', $restauranteId)->whereMonth('data_ini', $mes)->whereYear('data_ini', $ano)->orderBy('semana', 'ASC')->get();

        return $records;
    }


    //Produção Restaurante por Mês e Ano
    public static function producaorestaurantemesano ($idrest, $mes, $ano)
    {
        $records = Bigtabledata::groupBy('produto_id', 'medida_simbolo')
            ->selectRaw('regional_nome, municipio_nome, identificacao, produto_id, produto_nome, medida_simbolo, count(*) as numvezescomprado, data_ini, avg(preco) as mediapreco, sum(precototal) as somaprecototal, sum(quantidade) as somaquantidade')
            ->orderBy('produto_nome', 'ASC')
            ->orderBy('medida_simbolo', 'ASC')
            ->where('restaurante_id', '=', $idrest)
            ->whereMonth('data_ini', '=', $mes)
            ->whereYear('data_ini', '=', $ano)
            ->get();

        return $records;
    }


     //Compra mensal município
     public static function compramensalmunicipio ($idmun, $mes, $ano)
     {
         $records = Bigtabledata::groupBy('produto_id', 'medida_simbolo')
             ->selectRaw('regional_nome, municipio_nome, produto_id, produto_nome, medida_simbolo, count(*) as numvezescomprado, avg(preco) as mediapreco, sum(precototal) as somaprecototal, sum(quantidade) as somaquantidade')
             ->orderBy('produto_nome', 'ASC')
             ->orderBy('medida_simbolo', 'ASC')
             ->where('municipio_id', '=', $idmun)
             ->whereMonth('data_ini', '=', $mes)
             ->whereYear('data_ini', '=', $ano)
             ->get();

         return $records;
     }
}
