<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    // Campos nullable não é necessário ser informado
    public function run()
    {
        $user = new User();
        $user->nomecompleto = "Marcio Nonato F Vieira";
        $user->cpf = "471.183.423-11";
        $user->telefone = "(98) 98702-3329";
	    $user->name = "Marcio Vieira";
	    $user->email = "marcio@sedes.com.br";
        $user->perfil = "adm";
	    $user->password = Hash::make('123456');
        $user->municipio_id = 1;
	    $user->save();
    }
}
