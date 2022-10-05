<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
