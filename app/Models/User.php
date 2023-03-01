<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nomecompleto',
        'cpf',
        'crn',
        'telefone',
        'name',
        'email',
        'perfil',
        'password',
        'municipio_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function municipio(){
        return $this->belongsTo(Municipio::class);
    }

    public function restaurante(){
        return $this->hasOne(Restaurante::class);
    }

    public function qtdrestaurantevinc($id)
    {
        $qtd = DB::table('restaurantes')->where('user_id', '=', $id)->count();

        return $qtd;
    }

    public function qtdcomprasvinc($id)
    {
        $qtd = DB::table('bigtable_data')->where('user_id', '=', $id)->count();

        return $qtd;
    }
}
