<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Monitor extends Model
{
    use HasFactory;

    public static function comprasdogrupo($informacao)
    {
        switch ($informacao)
        {
            case "regi":
                $grupo = "regional_nome";
            break;

            case "muni":
                $grupo = "municipio_nome";
            break;

            case "rest":
                $grupo = "identificacao";
            break;
        }

        $dadoscompradogrupomensal = DB::table('bigtable_data')
                        ->select($grupo)
                        ->orderBy($grupo);
        
        return $dadoscompradogrupomensal;

        

    }
}
