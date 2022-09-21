<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'municipio_id',
        'bairro',
        'cep',
        'email',
        'celular',
        'fone',
        'ativo'
    ];

    public function municipio(){
        return $this->belongsTo(Municipio::class);
    }

    public function nutricionistas(){
        return $this->hasMany(Nutricionista::class);
    }

}
