<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Compra extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_ini',
        'data_fin',
        'semana',
        'valor',
        'valoraf',
        'valortotal',
        'restaurante_id'
    ];

    public function restaurante() {
        return $this->belongsTo(Restaurante::class);
    }

    public function produtos() {
        return $this->belongsToMany(Produto::class)->withPivot(['quantidade', 'medida_id', 'detalhe','preco','af', 'precototal'])->withTimestamps();
    }

    public function comprovantes(){
        return $this->hasMany(Comprovante::class);
    }


    public function qtdcomprovantesvinc($id)
    {
        $qtd = DB::table('comprovantes')->where('compra_id', '=', $id)->count();

        return $qtd;
    }

    public function allProdutos()
    {
        return $this->belongsToMany(Produto::class, 'bigtable_data')->withPivot([
            'id',
            'compra_id', 'produto_id', 'quantidade', 'medida_id', 'detalhe', 'preco', 'af', 'precototal',
            'produto_nome', 'medida_simbolo', 'semana', 'semana_nome', 
             'data_ini', 'data_fin', 'valor', 'valor_af', 'valortotal',
            'categoria_id', 'categoria_nome', 'restaurante_id', 'identificacao',
            'regional_id', 'regional_nome', 'municipio_id', 'municipio_nome', 'bairro_id', 'bairro_nome',
            'empresa_id', 'razaosocial', 'nomefantasia', 'cnpj', 
            'nutricionista_id', 'nutricionista_nomecompleto', 'nutricionista_cpf', 'nutricionista_crn', 'nutricionista_emp_id',
            'user_id', 'user_nomecompleto', 'user_cpf', 'user_crn',
            'restaurante_id', 'identificacao'
        ])->withTimestamps();
    }

}
