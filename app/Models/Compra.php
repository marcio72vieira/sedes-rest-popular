<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_ini',
        'data_fim',
        'semana',
        'valorsemaf',
        'valorcomaf',
        'valortotal',
        'restaurante_id'
    ];

    public function restaurante() {
        return $this->belongsTo(Restaurante::class);
    }
}
