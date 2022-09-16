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
        'codigocnae',
        'documentocnpj',
        'titularum',
        'cargotitum',
        'titulardois',
        'cargotitdois',
        'banco_id',
        'agencia',
        'conta',
        'logradouro',
        'numero',
        'complemento',
        'municipio_id',
        'bairro_id',
        'cep',
        'emailum',
        'emaildois',
        'celular',
        'foneum',
        'fonedois',
        'ativo'
    ];

    public function municipio(){
        return $this->belongsTo(Municipio::class);
    }

    public function bairro(){
        return $this->belongsTo(Bairro::class);
    }

    public function banco(){
        return $this->belongsTo(Banco::class);
    }
}
