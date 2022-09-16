<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bairro extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'ativo',
        'municipio_id',
    ];

    public function municipio(){
        return $this->belongsTo(Municipio::class);
    }

}
