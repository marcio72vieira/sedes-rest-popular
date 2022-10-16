<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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


}
