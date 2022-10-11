<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comprovante extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'compra_id'
    ];

    
    public function compra() {
        return $this->belongsTo(Compra::class);
    }






}
