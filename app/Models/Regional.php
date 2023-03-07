<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Regional extends Model
{
    use HasFactory;

    protected $table = "regionais";

    protected $fillable = [
        'nome',
        'ativo'
    ];

    public function municipios ()
    {
        return $this->hasMany(Municipio::class);
    }

    public function countmunicipios ()
    {
        return $this->hasMany(Municipio::class)->count();
    }

    //Obtendo os restaurantes pertencentes à regional, através de um relacionamento indireto hasManyThrough, já que
    //restaurante não se relaciona com regional, mas sim com município. Ou seja, é recuperado todos os restaurantes
    //que pertençam aos municípios que pertençam a uma determinada regional.
    public function restaurantes ()
    {
        return $this->hasManyThrough(Restaurante::class, Municipio::class);
    }
    

    //Idem bairro
    public function bairros ()
    {
        return $this->hasManyThrough(Bairro::class, Municipio::class);
    }

    //Obtendo a quantidade de municípios de uma regional, de um outro jeito
    public function qtdmunicipiosvinc($id)
    {
        $qtd = DB::table('municipios')->where('regional_id', '=', $id)->count();

        return $qtd;
    }


}
