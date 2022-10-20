<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Restaurante extends Model
{
    use HasFactory;

    protected $fillable = [
        'identificacao',
        'logradouro',
        'numero',
        'complemento',
        'municipio_id',
        'bairro_id',
        'cep',
        'empresa_id',
        'nutricionista_id',
        'user_id',
        'ativo'
    ];

    public function municipio(){
        return $this->belongsTo(Municipio::class);
    }

    public function bairro(){
        return $this->belongsTo(Bairro::class);
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

    public function nutricionista(){
        return $this->belongsTo(Nutricionista::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function compras(){
        return $this->hasMany(Compra::class);
    }

    public function qtdcomprasvinc($id)
    {
        $qtd = DB::table('compras')->where('restaurante_id', '=', $id)->count();

        return $qtd;
    }
}
