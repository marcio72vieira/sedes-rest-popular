<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Monitor extends Model
{
    use HasFactory;

    public static function entidade($informacao)
    {
        switch ($informacao)
        {
            case "regional":
                $dadostabela = "regional_nome";
            break;

            case "municipio":
                $dadostabela = "municipio_nome";
            break;

            case "restaurante":
                $dadostabela = "identificacao";
            break;
        }

        $dadoscompramensal = DB::table('bigtable_data')
                        ->select($dadostabela)
                        ->orderBy('companhias.id');
        
        return $dadoscompramensal;

        

    }
}
