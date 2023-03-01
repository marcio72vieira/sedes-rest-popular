<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Nutricionista extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomecompleto',
        'cpf',
        'crn',
        'telefone',
        'email',
        'empresa_id',
        'ativo'
    ];

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

    public function restaurante(){
        return $this->hasOne(Restaurante::class);
    }

    public function qtdrestaurantevinc($id)
    {
        $qtd = DB::table('restaurantes')->where('nutricionista_id', '=', $id)->count();

        return $qtd;
    }

    public function qtdcomprasvinc($id)
    {
        $qtd = DB::table('bigtable_data')->where('nutricionista_id', '=', $id)->count();

        return $qtd;
    }
}
