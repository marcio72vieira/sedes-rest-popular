<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'ativo',
        'categoria_id'
    ];

    public function categoria(){
        return $this->belongsTo(Categoria::class);
    }

    public function compras(){
        return $this->belongsToMany(Compra::class)->withPivot(['quantidade', 'medida_id', 'detalhe','preco','af', 'precototal'])->withTimestamps();
    }

    public function allCompras()
    {
        return $this->belongsToMany(Compra::class, 'bigtable_data')->withPivot([
            'id',
            'compra_id', 'produto_id', 'quantidade', 'medida_id', 'detalhe', 'preco', 'af', 'precototal',
            'produto_nome', 'medida_simbolo', 'semana', 'semana_nome', 
            /*'mes_id', 'mes_nome', 'data_ini', 'data_fin', 'valor', 'valor_af', 'valortotal',
            'categoria_id', 'categoria_nome', 'restaurante_id', 'identificacao',
            'regional_id', 'regional_nome', 'municipio_id', 'municipio_nome', 'bairro_id', 'bairro_nome',
            'empresa_id', 'razaosocial', 'nomefantasia', 'cnpj', 
            'nutricionista_id', 'nutricionista_nomecompleto', 'nutricionista_cpf', 'nutricionista_crn', 'nutricionista_emp_id',
            'user_id', 'user_nomecompleto', 'user_cpf', 'user_crn',
            'restaurante_id', 'identificacao'*/
        ])->withTimestamps();
    }

    /* public function allCompras()
    {
        return $this->belongsToMany(Compra::class, 'bigtable_data')->withPivot([
            'id',
            'compra_id', 'produto_id', 'quantidade', 'medida_id', 'detalhe', 'preco', 'af', 'precototal',
            'produto_nome', 'medida_simbolo', 'semana', 'semana_nome',
            'mes_id', 'mes_nome', 'data_ini', 'data_fin', 'valor', 'valor_af', 'valortotal',
            'categoria_id', 'categoria_nome', 'restaurante_id', 'identificacao',
            'regional_id', 'regional_nome', 'municipio_id', 'municipio_nome', 'bairro_id', 'bairro_nome',
            'empresa_id', 'razaosocial', 'nomefantasia', 'cnpj', 
            'nutricionista_id', 'nutricionista_nomecompleto', 'nutricionista_cpf', 'nutricionista_crn', 'nutricionista_emp_id',
            'user_id', 'user_nomecompleto', 'user_cpf', 'user_crn',
            'restaurante_id', 'identificacao'
        ])->withTimestamps();
    } */
}
