<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function comprovantes(){
        return $this->hasMany(Comprovante::class);
    }


    public function qtdcomprovantesvinc($id)
    {
        $qtd = DB::table('comprovantes')->where('compra_id', '=', $id)->count();

        return $qtd;
    }
}
