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
}
