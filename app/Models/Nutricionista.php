<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
