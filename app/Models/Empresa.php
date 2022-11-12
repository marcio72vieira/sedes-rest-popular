<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'razaosocial',
        'nomefantasia',
        'cnpj',
        'titular',
        'cargotitular',
        'logradouro',
        'numero',
        'complemento',
        'municipio',
        'bairro',
        'cep',
        'email',
        'celular',
        'fone',
        'ativo'
    ];


    public function nutricionistas(){
        return $this->hasMany(Nutricionista::class);
    }

    public function qtdnutricionistasvinc($id)
    {
        $qtd = DB::table('nutricionistas')->where('empresa_id', '=', $id)->count();

        return $qtd;
    }

    public function restaurantes(){
        return $this->hasMany(Restaurante::class);
    }

}
