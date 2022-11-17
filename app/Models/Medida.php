<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Medida extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'simbolo',
        'ativo'
    ];


    public function qtdcomprasvinc($id)
    {
        $qtd = DB::table('compra_produto')->where('medida_id', '=', $id)->count();

        return $qtd;
    }
}
