<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'ativo'
    ];


    public function users(){
        return $this->hasMany(User::class);
    }

    public function empresas(){
        return $this->hasMany(Empresa::class);
    }

    public function companhias(){
        return $this->hasMany(Companhia::class);
    }

    public function bairros(){
        return $this->hasMany(Bairro::class);
    }
}
