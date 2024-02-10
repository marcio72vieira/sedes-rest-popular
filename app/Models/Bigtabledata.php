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


    public static function comprasemanal($restauranteId, $semana, $mes, $ano)
    {

        //$records = DB::table('bigtable_data')->where('restaurante_id', '=', $restauranteId)->where('semana', '=', $semana)->whereMonth('data_ini', $mes)->whereYear('data_ini', $ano)->orderBy('semana', 'ASC')->get();
        $records = DB::table('bigtable_data')->where('restaurante_id', '=', $restauranteId)->where('semana', '=', $semana)->whereMonth('data_ini', $mes)->whereYear('data_ini', $ano)->orderBy('produto_nome', 'ASC')->get();

        return $records;
    }


    public static function compramensal($restauranteId, $mes, $ano)
    {

        //$records = DB::table('bigtable_data')->where('restaurante_id', '=', $restauranteId)->whereMonth('data_ini', $mes)->whereYear('data_ini', $ano)->orderBy('semana', 'ASC')->get();
        $records = DB::table('bigtable_data')->where('restaurante_id', '=', $restauranteId)->whereMonth('data_ini', $mes)->whereYear('data_ini', $ano)->orderBy('produto_nome', 'ASC')->get();

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

    /* //Compra mensal município por grupo de restaurantes ORIGINAL
    public static function compramensalmunicipioagrupado ($idmun, $mes, $ano)
    {
        $records = Bigtabledata::groupBy('restaurante_id')
            ->selectRaw('regional_nome, municipio_nome, restaurante_id, identificacao, sum(precototal) as somaprecototal')
            ->orderBy('identificacao', 'ASC')
            ->where('municipio_id', '=', $idmun)
            ->whereMonth('data_ini', '=', $mes)
            ->whereYear('data_ini', '=', $ano)
            ->get();

        return $records;
    } */

    /*
    //Compra mensal realizada por todos os restaurantes do município
    public static function compramensalmunicipioagrupado ($idmun, $mes, $ano)
    {
        $records = Bigtabledata::groupBy('restaurante_id')
            ->selectRaw('regional_nome, municipio_nome, restaurante_id, identificacao, sum(IF(af = "sim", precototal, 0)) as somaprecoaf,  sum(IF(af = "nao", precototal, 0)) as somapreconormal, sum(precototal) as somaprecototal')
            ->orderBy('identificacao', 'ASC')
            ->where('municipio_id', '=', $idmun)
            ->whereMonth('data_ini', '=', $mes)
            ->whereYear('data_ini', '=', $ano)
            ->get();

        return $records;
    }
    */


    //Compra mensal realizada por todos os restaurantes do município
    public static function compramensalmunicipiovalor ($idmun, $mes, $ano)
    {
        $records = Bigtabledata::groupBy('restaurante_id')
            ->selectRaw('regional_nome, municipio_nome, restaurante_id, identificacao, sum(IF(af = "sim", precototal, 0)) as somaprecoaf,  sum(IF(af = "nao", precototal, 0)) as somapreconormal, sum(precototal) as somaprecototal')
            ->orderBy('identificacao', 'ASC')
            ->where('municipio_id', '=', $idmun)
            ->whereMonth('data_ini', '=', $mes)
            ->whereYear('data_ini', '=', $ano)
            ->get();

        return $records;
    }



    //Compra mensal realizada por todos os municípios da região
    public static function compramensalregiaovalor ($idreg, $mes, $ano)
    {
        $records = Bigtabledata::groupBy('municipio_id')
            ->selectRaw('regional_nome, municipio_id, municipio_nome as nomemunicipio,  sum(IF(af = "sim", precototal, 0)) as somaprecoaf,  sum(IF(af = "nao", precototal, 0)) as somapreconormal, sum(precototal) as somaprecototal')
            ->orderBy('nomemunicipio', 'ASC')
            ->where('regional_id', '=', $idreg)
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


     //Compra mensal de produtos feitos na regional
     public static function compramensalregionalproduto ($idreg, $mes, $ano)
     {
         $records = Bigtabledata::groupBy('produto_id', 'medida_simbolo')
             ->selectRaw('regional_nome, municipio_nome, produto_id, produto_nome, medida_simbolo, count(*) as numvezescomprado, avg(preco) as mediapreco, sum(precototal) as somaprecototal, sum(quantidade) as somaquantidade')
             ->orderBy('produto_nome', 'ASC')
             ->orderBy('medida_simbolo', 'ASC')
             ->where('regional_id', '=', $idreg)
             ->whereMonth('data_ini', '=', $mes)
             ->whereYear('data_ini', '=', $ano)
             ->get();

         return $records;
     }



     public static function mapamensalprodutorestaurante ($idrest, $mes, $ano)
     {
         $records = Bigtabledata::groupBy('produto_id', 'medida_simbolo')
            //->selectRaw('regional_nome, municipio_nome, identificacao, produto_id, produto_nome, medida_simbolo, sum(IF(af = "sim", quantidade, 0)) as somaquantidadeaf, sum(IF(af = "sim", precototal, 0)) as somaprecoaf, sum(IF(af = "nao", quantidade, 0)) as somaquantidadenormal,  sum(IF(af = "nao", precototal, 0)) as somapreconormal')
            //->selectRaw('regional_nome, municipio_nome, identificacao, produto_id, produto_nome, medida_simbolo, count(IF(af = "sim", 1, null)) numvezesaf, count(IF(af = "nao", 1, null)) numvezesnormal,  sum(IF(af = "sim", quantidade, 0)) as somaquantidadeaf, sum(IF(af = "sim", precototal, 0)) as somaprecoaf, sum(IF(af = "nao", quantidade, 0)) as somaquantidadenormal,  sum(IF(af = "nao", precototal, 0)) as somapreconormal')
            ->selectRaw('regional_nome, municipio_nome, identificacao, produto_id, produto_nome, medida_simbolo, count(IF(af = "sim", 1, null)) numvezesaf, count(IF(af = "nao", 1, null)) numvezesnormal, avg(IF(af = "sim", preco, NULL)) as mediaprecoaf, avg(IF(af = "nao", preco, NULL)) as mediapreconormal, sum(IF(af = "sim", quantidade, 0)) as somaquantidadeaf, sum(IF(af = "sim", precototal, 0)) as somaprecoaf, sum(IF(af = "nao", quantidade, 0)) as somaquantidadenormal,  sum(IF(af = "nao", precototal, 0)) as somapreconormal')
            ->orderBy('produto_nome', 'ASC')
            ->orderBy('medida_simbolo', 'ASC')
            ->where('restaurante_id', '=', $idrest)
            ->whereMonth('data_ini', '=', $mes)
            ->whereYear('data_ini', '=', $ano)
            ->get();

            return $records;
     }



     public static function mapamensalprodutomunicipio ($idmuni, $mes, $ano)
     {
         $records = Bigtabledata::groupBy('produto_id', 'medida_simbolo')
            //->selectRaw('regional_nome, municipio_nome, produto_id, produto_nome, medida_simbolo, sum(IF(af = "sim", quantidade, 0)) as somaquantidadeaf, sum(IF(af = "sim", precototal, 0)) as somaprecoaf, sum(IF(af = "nao", quantidade, 0)) as somaquantidadenormal,  sum(IF(af = "nao", precototal, 0)) as somapreconormal')
            //->selectRaw('regional_nome, municipio_nome, produto_id, produto_nome, medida_simbolo, count(IF(af = "sim", 1, null)) numvezesaf, count(IF(af = "nao", 1, null)) numvezesnormal,  sum(IF(af = "sim", quantidade, 0)) as somaquantidadeaf, sum(IF(af = "sim", precototal, 0)) as somaprecoaf, sum(IF(af = "nao", quantidade, 0)) as somaquantidadenormal,  sum(IF(af = "nao", precototal, 0)) as somapreconormal')
            ->selectRaw('regional_nome, municipio_nome, produto_id, produto_nome, medida_simbolo, count(IF(af = "sim", 1, null)) numvezesaf, count(IF(af = "nao", 1, null)) numvezesnormal, avg(IF(af = "sim", preco, NULL)) as mediaprecoaf, avg(IF(af = "nao", preco, NULL)) as mediapreconormal, sum(IF(af = "sim", quantidade, 0)) as somaquantidadeaf, sum(IF(af = "sim", precototal, 0)) as somaprecoaf, sum(IF(af = "nao", quantidade, 0)) as somaquantidadenormal,  sum(IF(af = "nao", precototal, 0)) as somapreconormal')
            ->orderBy('produto_nome', 'ASC')
            ->orderBy('medida_simbolo', 'ASC')
            ->where('municipio_id', '=', $idmuni)
            ->whereMonth('data_ini', '=', $mes)
            ->whereYear('data_ini', '=', $ano)
            ->get();

            return $records;
     }



     public static function mapamensalprodutoregional ($idregi, $mes, $ano)
     {
         $records = Bigtabledata::groupBy('produto_id', 'medida_simbolo')
            //->selectRaw('regional_nome, municipio_nome, produto_id, produto_nome, medida_simbolo, sum(IF(af = "sim", quantidade, 0)) as somaquantidadeaf, sum(IF(af = "sim", precototal, 0)) as somaprecoaf, sum(IF(af = "nao", quantidade, 0)) as somaquantidadenormal,  sum(IF(af = "nao", precototal, 0)) as somapreconormal')
            //->selectRaw('regional_nome, municipio_nome, produto_id, produto_nome, medida_simbolo, count(IF(af = "sim", 1, null)) numvezesaf, count(IF(af = "nao", 1, null)) numvezesnormal,  sum(IF(af = "sim", quantidade, 0)) as somaquantidadeaf, sum(IF(af = "sim", precototal, 0)) as somaprecoaf, sum(IF(af = "nao", quantidade, 0)) as somaquantidadenormal,  sum(IF(af = "nao", precototal, 0)) as somapreconormal')
            ->selectRaw('regional_nome, municipio_nome, produto_id, produto_nome, medida_simbolo, count(IF(af = "sim", 1, null)) numvezesaf, count(IF(af = "nao", 1, null)) numvezesnormal, avg(IF(af = "sim", preco, NULL)) as mediaprecoaf, avg(IF(af = "nao", preco, NULL)) as mediapreconormal, sum(IF(af = "sim", quantidade, 0)) as somaquantidadeaf, sum(IF(af = "sim", precototal, 0)) as somaprecoaf, sum(IF(af = "nao", quantidade, 0)) as somaquantidadenormal,  sum(IF(af = "nao", precototal, 0)) as somapreconormal')
            ->orderBy('produto_nome', 'ASC')
            ->orderBy('medida_simbolo', 'ASC')
            ->where('regional_id', '=', $idregi)
            ->whereMonth('data_ini', '=', $mes)
            ->whereYear('data_ini', '=', $ano)
            ->get();

            return $records;
     }



     /* public static function mapamensalgeralproduto ($mes, $ano)
     {
         $records = Bigtabledata::groupBy('produto_id', 'medida_simbolo', 'regional_id')
            ->selectRaw('regional_id, regional_nome, produto_id, produto_nome, medida_simbolo, count(IF(af = "sim", 1, null)) numvezesaf, count(IF(af = "nao", 1, null)) numvezesnormal, avg(IF(af = "sim", preco, NULL)) as mediaprecoaf, avg(IF(af = "nao", preco, NULL)) as mediapreconormal, sum(IF(af = "sim", quantidade, 0)) as somaquantidadeaf, sum(IF(af = "sim", precototal, 0)) as somaprecoaf, sum(IF(af = "nao", quantidade, 0)) as somaquantidadenormal,  sum(IF(af = "nao", precototal, 0)) as somapreconormal')
            ->orderBy('regional_nome', 'ASC')
            ->orderBy('produto_nome', 'ASC')
            ->orderBy('medida_simbolo', 'ASC')
            ->whereMonth('data_ini', '=', $mes)
            ->whereYear('data_ini', '=', $ano)
            ->get();

            return $records;
     } */


     public static function mapamensalgeralproduto ($mes, $ano)
     {
         $records = Bigtabledata::groupBy('produto_id', 'medida_simbolo')
            ->selectRaw('regional_id, regional_nome, produto_id, produto_nome, medida_simbolo, count(IF(af = "sim", 1, null)) numvezesaf, count(IF(af = "nao", 1, null)) numvezesnormal, avg(IF(af = "sim", preco, NULL)) as mediaprecoaf, avg(IF(af = "nao", preco, NULL)) as mediapreconormal, sum(IF(af = "sim", quantidade, 0)) as somaquantidadeaf, sum(IF(af = "sim", precototal, 0)) as somaprecoaf, sum(IF(af = "nao", quantidade, 0)) as somaquantidadenormal,  sum(IF(af = "nao", precototal, 0)) as somapreconormal')
            ->orderBy('produto_nome', 'ASC')
            ->orderBy('medida_simbolo', 'ASC')
            ->whereMonth('data_ini', '=', $mes)
            ->whereYear('data_ini', '=', $ano)
            ->get();

            return $records;
     }




     public static function mapamensalcategoriarestaurante ($idrest, $mes, $ano)
     {
         $records = Bigtabledata::groupBy('categoria_id', 'medida_simbolo')
            ->selectRaw('regional_nome, municipio_nome, identificacao, categoria_id, categoria_nome, medida_simbolo, count(IF(af = "sim", 1, null)) numvezesaf, count(IF(af = "nao", 1, null)) numvezesnormal, avg(IF(af = "sim", preco, NULL)) as mediaprecoaf, avg(IF(af = "nao", preco, NULL)) as mediapreconormal, sum(IF(af = "sim", quantidade, 0)) as somaquantidadeaf, sum(IF(af = "sim", precototal, 0)) as somaprecoaf, sum(IF(af = "nao", quantidade, 0)) as somaquantidadenormal,  sum(IF(af = "nao", precototal, 0)) as somapreconormal')
            ->orderBy('categoria_nome', 'ASC')
            ->orderBy('medida_simbolo', 'ASC')
            ->where('restaurante_id', '=', $idrest)
            ->whereMonth('data_ini', '=', $mes)
            ->whereYear('data_ini', '=', $ano)
            ->get();

            return $records;
     }


     public static function mapamensalcategoriamunicipio ($idmuni, $mes, $ano)
     {
         $records = Bigtabledata::groupBy('categoria_id', 'medida_simbolo')
            ->selectRaw('regional_nome, municipio_nome, categoria_id, categoria_nome, medida_simbolo, count(IF(af = "sim", 1, null)) numvezesaf, count(IF(af = "nao", 1, null)) numvezesnormal, avg(IF(af = "sim", preco, NULL)) as mediaprecoaf, avg(IF(af = "nao", preco, NULL)) as mediapreconormal, sum(IF(af = "sim", quantidade, 0)) as somaquantidadeaf, sum(IF(af = "sim", precototal, 0)) as somaprecoaf, sum(IF(af = "nao", quantidade, 0)) as somaquantidadenormal,  sum(IF(af = "nao", precototal, 0)) as somapreconormal')
            ->orderBy('categoria_nome', 'ASC')
            ->orderBy('medida_simbolo', 'ASC')
            ->where('municipio_id', '=', $idmuni)
            ->whereMonth('data_ini', '=', $mes)
            ->whereYear('data_ini', '=', $ano)
            ->get();

            return $records;
     }


     public static function mapamensalcategoriaregional ($idregi, $mes, $ano)
     {
         $records = Bigtabledata::groupBy('categoria_id', 'medida_simbolo')
            ->selectRaw('regional_nome, municipio_nome, categoria_id, categoria_nome, medida_simbolo, count(IF(af = "sim", 1, null)) numvezesaf, count(IF(af = "nao", 1, null)) numvezesnormal, avg(IF(af = "sim", preco, NULL)) as mediaprecoaf, avg(IF(af = "nao", preco, NULL)) as mediapreconormal, sum(IF(af = "sim", quantidade, 0)) as somaquantidadeaf, sum(IF(af = "sim", precototal, 0)) as somaprecoaf, sum(IF(af = "nao", quantidade, 0)) as somaquantidadenormal,  sum(IF(af = "nao", precototal, 0)) as somapreconormal')
            ->orderBy('categoria_nome', 'ASC')
            ->orderBy('medida_simbolo', 'ASC')
            ->where('regional_id', '=', $idregi)
            ->whereMonth('data_ini', '=', $mes)
            ->whereYear('data_ini', '=', $ano)
            ->get();

            return $records;
     }



     public static function mapamensalgeralcategoria ($mes, $ano)
     {
         $records = Bigtabledata::groupBy('categoria_id', 'medida_simbolo')
            ->selectRaw('regional_id, regional_nome, categoria_id, categoria_nome, medida_simbolo, count(IF(af = "sim", 1, null)) numvezesaf, count(IF(af = "nao", 1, null)) numvezesnormal, avg(IF(af = "sim", preco, NULL)) as mediaprecoaf, avg(IF(af = "nao", preco, NULL)) as mediapreconormal, sum(IF(af = "sim", quantidade, 0)) as somaquantidadeaf, sum(IF(af = "sim", precototal, 0)) as somaprecoaf, sum(IF(af = "nao", quantidade, 0)) as somaquantidadenormal,  sum(IF(af = "nao", precototal, 0)) as somapreconormal')
            ->orderBy('categoria_nome', 'ASC')
            ->orderBy('medida_simbolo', 'ASC')
            ->whereMonth('data_ini', '=', $mes)
            ->whereYear('data_ini', '=', $ano)
            ->get();

            return $records;
     }

     /*
     //Query Original, faz a busca no banco independente da unidade de medida, ou seja, busca todas
     public static function comparativomensalprodutomunicipio ($idprod, $idmuni, $mes, $ano)
     {
         $records = Bigtabledata::groupBy('restaurante_id','produto_id', 'medida_simbolo')
            ->selectRaw('regional_nome, municipio_nome, restaurante_id, identificacao, produto_id, produto_nome, medida_simbolo, count(IF(af = "sim", 1, null)) numvezesaf, count(IF(af = "nao", 1, null)) numvezesnormal, avg(IF(af = "sim", preco, NULL)) as mediaprecoaf, avg(IF(af = "nao", preco, NULL)) as mediapreconormal, sum(IF(af = "sim", quantidade, 0)) as somaquantidadeaf, sum(IF(af = "sim", precototal, 0)) as somaprecoaf, sum(IF(af = "nao", quantidade, 0)) as somaquantidadenormal,  sum(IF(af = "nao", precototal, 0)) as somapreconormal')
            ->orderBy('produto_nome', 'ASC')
            ->orderBy('medida_simbolo', 'ASC')
            ->orderBy('identificacao', 'ASC')
            ->where('produto_id', '=', $idprod)
            ->where('municipio_id', '=', $idmuni)
            ->whereMonth('data_ini', '=', $mes)
            ->whereYear('data_ini', '=', $ano)
            ->get();

            return $records;
     }
     */


     public static function comparativomensalprodutomunicipio ($idprod, $idmedi, $idmuni, $mes, $ano)
     {
         $records = Bigtabledata::groupBy('restaurante_id','produto_id')
            //->selectRaw('regional_nome, municipio_nome, restaurante_id, identificacao, produto_id, produto_nome, medida_simbolo, count(IF(af = "sim", 1, null)) numvezesaf, count(IF(af = "nao", 1, null)) numvezesnormal, avg(IF(af = "sim", preco, NULL)) as mediaprecoaf, avg(IF(af = "nao", preco, NULL)) as mediapreconormal, sum(IF(af = "sim", quantidade, 0)) as somaquantidadeaf, sum(IF(af = "sim", precototal, 0)) as somaprecoaf, sum(IF(af = "nao", quantidade, 0)) as somaquantidadenormal,  sum(IF(af = "nao", precototal, 0)) as somapreconormal')
            ->selectRaw('regional_nome, municipio_nome, restaurante_id, identificacao, produto_id, produto_nome, medida_simbolo, count(IF(af = "sim", 1, null)) numvezesaf, count(IF(af = "nao", 1, null)) numvezesnormal, avg(IF(af = "sim", preco, NULL)) as mediaprecoaf, avg(IF(af = "nao", preco, NULL)) as mediapreconormal, sum(IF(af = "sim", quantidade, 0)) as somaquantidadeaf, sum(IF(af = "sim", precototal, 0)) as somaprecoaf, sum(IF(af = "nao", quantidade, 0)) as somaquantidadenormal,  sum(IF(af = "nao", precototal, 0)) as somapreconormal, sum(IF(af = "nao", preco, 0)) as somaprecounitarionormal, sum(IF(af = "sim", preco, 0)) as somaprecounitarioaf')
            ->orderBy('produto_nome', 'ASC')
            ->orderBy('medida_simbolo', 'ASC')
            ->orderBy('identificacao', 'ASC')
            ->where('produto_id', '=', $idprod)
            ->where('medida_id', '=', $idmedi)
            ->where('municipio_id', '=', $idmuni)
            ->whereMonth('data_ini', '=', $mes)
            ->whereYear('data_ini', '=', $ano)
            ->get();

            return $records;
     }


     public static function comparativomensalprodutoregional ($idprod, $idmedi, $idregi, $mes, $ano)
     {
         $records = Bigtabledata::groupBy('municipio_id','produto_id')
            //->selectRaw('regional_nome, municipio_id, municipio_nome, produto_id, produto_nome, medida_simbolo, count(IF(af = "sim", 1, null)) numvezesaf, count(IF(af = "nao", 1, null)) numvezesnormal, avg(IF(af = "sim", preco, NULL)) as mediaprecoaf, avg(IF(af = "nao", preco, NULL)) as mediapreconormal, sum(IF(af = "sim", quantidade, 0)) as somaquantidadeaf, sum(IF(af = "sim", precototal, 0)) as somaprecoaf, sum(IF(af = "nao", quantidade, 0)) as somaquantidadenormal,  sum(IF(af = "nao", precototal, 0)) as somapreconormal')
            ->selectRaw('regional_nome, municipio_id, municipio_nome, produto_id, produto_nome, medida_simbolo, count(IF(af = "sim", 1, null)) numvezesaf, count(IF(af = "nao", 1, null)) numvezesnormal, avg(IF(af = "sim", preco, NULL)) as mediaprecoaf, avg(IF(af = "nao", preco, NULL)) as mediapreconormal, sum(IF(af = "sim", quantidade, 0)) as somaquantidadeaf, sum(IF(af = "sim", precototal, 0)) as somaprecoaf, sum(IF(af = "nao", quantidade, 0)) as somaquantidadenormal,  sum(IF(af = "nao", precototal, 0)) as somapreconormal, sum(IF(af = "nao", preco, 0)) as somaprecounitarionormal, sum(IF(af = "sim", preco, 0)) as somaprecounitarioaf')
            ->orderBy('municipio_nome', 'ASC')
            ->where('produto_id', '=', $idprod)
            ->where('medida_id', '=', $idmedi)
            ->where('regional_id', '=', $idregi)
            ->whereMonth('data_ini', '=', $mes)
            ->whereYear('data_ini', '=', $ano)
            ->get();

            return $records;
     }


     //Este método agrupa pela regional (diferentemente do método mapamensalgeralproduto), porque este método
     //já possui o produto_id e a medida_id definidos previamente, ou seja, deve-se procurar por eles especificamente
     //nas cláusulas where enquanto que no método mapamensalgeralproduto não, ou seja, deve-se agrupar os registros
     //pelo produto_id e medida_id.
     public static function comparativomensalgeralproduto ($idprod, $idmedi, $mes, $ano)
     {
         $records = Bigtabledata::groupBy('regional_id')
            //->selectRaw('regional_id, regional_nome, produto_id, produto_nome, medida_simbolo, count(IF(af = "sim", 1, null)) numvezesaf, count(IF(af = "nao", 1, null)) numvezesnormal, avg(IF(af = "sim", preco, NULL)) as mediaprecoaf, avg(IF(af = "nao", preco, NULL)) as mediapreconormal, sum(IF(af = "sim", quantidade, 0)) as somaquantidadeaf, sum(IF(af = "sim", precototal, 0)) as somaprecoaf, sum(IF(af = "nao", quantidade, 0)) as somaquantidadenormal,  sum(IF(af = "nao", precototal, 0)) as somapreconormal')
            ->selectRaw('regional_id, regional_nome, produto_id, produto_nome, medida_simbolo, count(IF(af = "sim", 1, null)) numvezesaf, count(IF(af = "nao", 1, null)) numvezesnormal, avg(IF(af = "sim", preco, NULL)) as mediaprecoaf, avg(IF(af = "nao", preco, NULL)) as mediapreconormal, sum(IF(af = "sim", quantidade, 0)) as somaquantidadeaf, sum(IF(af = "sim", precototal, 0)) as somaprecoaf, sum(IF(af = "nao", quantidade, 0)) as somaquantidadenormal,  sum(IF(af = "nao", precototal, 0)) as somapreconormal, sum(IF(af = "nao", preco, 0)) as somaprecounitarionormal, sum(IF(af = "sim", preco, 0)) as somaprecounitarioaf')
            ->orderBy('regional_nome', 'ASC')
            ->where('produto_id', '=', $idprod)
            ->where('medida_id', '=', $idmedi)
            ->whereMonth('data_ini', '=', $mes)
            ->whereYear('data_ini', '=', $ano)
            ->get();

            return $records;
     }



     //#######################
     // COMPARATIVO CATEGORIA
     //######################
     public static function comparativomensalcategoriamunicipio ($idcateg, $idmedi, $idmuni, $mes, $ano)
     {
         $records = Bigtabledata::groupBy('restaurante_id','categoria_id')
            //->selectRaw('regional_nome, municipio_nome, restaurante_id, identificacao, categoria_id, categoria_nome, medida_simbolo, count(IF(af = "sim", 1, null)) numvezesaf, count(IF(af = "nao", 1, null)) numvezesnormal, avg(IF(af = "sim", preco, NULL)) as mediaprecoaf, avg(IF(af = "nao", preco, NULL)) as mediapreconormal, sum(IF(af = "sim", quantidade, 0)) as somaquantidadeaf, sum(IF(af = "sim", precototal, 0)) as somaprecoaf, sum(IF(af = "nao", quantidade, 0)) as somaquantidadenormal,  sum(IF(af = "nao", precototal, 0)) as somapreconormal')
            ->selectRaw('regional_nome, municipio_nome, restaurante_id, identificacao, categoria_id, categoria_nome, medida_simbolo, count(IF(af = "sim", 1, null)) numvezesaf, count(IF(af = "nao", 1, null)) numvezesnormal, avg(IF(af = "sim", preco, NULL)) as mediaprecoaf, avg(IF(af = "nao", preco, NULL)) as mediapreconormal, sum(IF(af = "sim", quantidade, 0)) as somaquantidadeaf, sum(IF(af = "sim", precototal, 0)) as somaprecoaf, sum(IF(af = "nao", quantidade, 0)) as somaquantidadenormal,  sum(IF(af = "nao", precototal, 0)) as somapreconormal, sum(IF(af = "nao", preco, 0)) as somaprecounitarionormal, sum(IF(af = "sim", preco, 0)) as somaprecounitarioaf')
            ->orderBy('categoria_nome', 'ASC')
            ->orderBy('medida_simbolo', 'ASC')
            ->orderBy('identificacao', 'ASC')
            ->where('categoria_id', '=', $idcateg)
            ->where('medida_id', '=', $idmedi)
            ->where('municipio_id', '=', $idmuni)
            ->whereMonth('data_ini', '=', $mes)
            ->whereYear('data_ini', '=', $ano)
            ->get();

            return $records;
     }


     public static function comparativomensalcategoriaregional ($idcateg, $idmedi, $idregi, $mes, $ano)
     {
         $records = Bigtabledata::groupBy('municipio_id','categoria_id')
            //->selectRaw('regional_nome, municipio_id, municipio_nome, categoria_id, categoria_nome, medida_simbolo, count(IF(af = "sim", 1, null)) numvezesaf, count(IF(af = "nao", 1, null)) numvezesnormal, avg(IF(af = "sim", preco, NULL)) as mediaprecoaf, avg(IF(af = "nao", preco, NULL)) as mediapreconormal, sum(IF(af = "sim", quantidade, 0)) as somaquantidadeaf, sum(IF(af = "sim", precototal, 0)) as somaprecoaf, sum(IF(af = "nao", quantidade, 0)) as somaquantidadenormal,  sum(IF(af = "nao", precototal, 0)) as somapreconormal')
            ->selectRaw('regional_nome, municipio_id, municipio_nome, categoria_id, categoria_nome, medida_simbolo, count(IF(af = "sim", 1, null)) numvezesaf, count(IF(af = "nao", 1, null)) numvezesnormal, avg(IF(af = "sim", preco, NULL)) as mediaprecoaf, avg(IF(af = "nao", preco, NULL)) as mediapreconormal, sum(IF(af = "sim", quantidade, 0)) as somaquantidadeaf, sum(IF(af = "sim", precototal, 0)) as somaprecoaf, sum(IF(af = "nao", quantidade, 0)) as somaquantidadenormal,  sum(IF(af = "nao", precototal, 0)) as somapreconormal, sum(IF(af = "nao", preco, 0)) as somaprecounitarionormal, sum(IF(af = "sim", preco, 0)) as somaprecounitarioaf')
            ->orderBy('municipio_nome', 'ASC')
            ->where('categoria_id', '=', $idcateg)
            ->where('medida_id', '=', $idmedi)
            ->where('regional_id', '=', $idregi)
            ->whereMonth('data_ini', '=', $mes)
            ->whereYear('data_ini', '=', $ano)
            ->get();

            return $records;
     }


     //Este método agrupa pela regional (diferentemente do método mapamensalgeralcategoria), porque este método
     //já possui o categoria_id e a medida_id definidos previamente, ou seja, deve-se procurar por eles especificamente
     //nas cláusulas where enquanto que no método mapamensalgeralcategoria não, ou seja, deve-se agrupar os registros
     //pelo categoria_id e medida_id.
     public static function comparativomensalgeralcategoria ($idcateg, $idmedi, $mes, $ano)
     {
         $records = Bigtabledata::groupBy('regional_id')
            //->selectRaw('regional_id, regional_nome, categoria_id, categoria_nome, medida_simbolo, count(IF(af = "sim", 1, null)) numvezesaf, count(IF(af = "nao", 1, null)) numvezesnormal, avg(IF(af = "sim", preco, NULL)) as mediaprecoaf, avg(IF(af = "nao", preco, NULL)) as mediapreconormal, sum(IF(af = "sim", quantidade, 0)) as somaquantidadeaf, sum(IF(af = "sim", precototal, 0)) as somaprecoaf, sum(IF(af = "nao", quantidade, 0)) as somaquantidadenormal,  sum(IF(af = "nao", precototal, 0)) as somapreconormal')
            ->selectRaw('regional_id, regional_nome, categoria_id, categoria_nome, medida_simbolo, count(IF(af = "sim", 1, null)) numvezesaf, count(IF(af = "nao", 1, null)) numvezesnormal, avg(IF(af = "sim", preco, NULL)) as mediaprecoaf, avg(IF(af = "nao", preco, NULL)) as mediapreconormal, sum(IF(af = "sim", quantidade, 0)) as somaquantidadeaf, sum(IF(af = "sim", precototal, 0)) as somaprecoaf, sum(IF(af = "nao", quantidade, 0)) as somaquantidadenormal,  sum(IF(af = "nao", precototal, 0)) as somapreconormal, sum(IF(af = "nao", preco, 0)) as somaprecounitarionormal, sum(IF(af = "sim", preco, 0)) as somaprecounitarioaf')
            ->orderBy('regional_nome', 'ASC')
            ->where('categoria_id', '=', $idcateg)
            ->where('medida_id', '=', $idmedi)
            ->whereMonth('data_ini', '=', $mes)
            ->whereYear('data_ini', '=', $ano)
            ->get();

            return $records;
     }


     // relatorio excel
    public static function getBigtabledatasExcel($mes, $ano){
        $records = DB::table('bigtable_data')->select('id', 'compra_id', 'produto_id', 'quantidade', 'medida_id', 'preco', 'af', 'precototal', 'produto_nome', 'medida_nome')->whereMonth('data_ini', $mes)->whereYear('data_ini', $ano)->get()->toArray();
        return $records;
    }


}
