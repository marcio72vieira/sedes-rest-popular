<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Municipio extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'ativo',
        'regional_id'
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

    public function regional(){
        return $this->belongsTo(Regional::class);
    }

    public function qtdbairrosvinc($id)
    {
        $qtd = DB::table('bairros')->where('municipio_id', '=', $id)->count();

        return $qtd;
    }
}
