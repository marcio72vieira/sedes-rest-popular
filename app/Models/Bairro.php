<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Bairro extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'ativo',
        'municipio_id',
    ];

    public function municipio(){
        return $this->belongsTo(Municipio::class);
    }

    public function qtdrestaurantesvinc($id)
    {
        $qtd = DB::table('restaurantes')->where('bairro_id', '=', $id)->count();

        return $qtd;
    }

}
