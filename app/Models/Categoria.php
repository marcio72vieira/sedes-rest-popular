<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Categoria extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'ativo'
    ];


    public function produtos(){
        return $this->hasMany(User::class);
    }


    public function qtdprodutosvinc($id)
    {
        $qtd = DB::table('produtos')->where('categoria_id', '=', $id)->count();

        return $qtd;
    }
}
