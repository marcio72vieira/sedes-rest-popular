<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Municipio;
use App\Models\User;

class AcessoController extends Controller
{
    public function login()
    {
        /*
        // Cria um município fictíco pra fins de teste
        $municipio = new Municipio; $municipio->nome = 'São Luis'; $municipio->ativo = 1; $municipio->save();

        // Cria um usuário fictício para fins de teste. Depois de criar o usuário, comente este trecho de código
        $user = new User; $user->nomecompleto = "Administrador Mater"; $user->cpf = '000.000.000-00'; $user->crn = '000000';
                $user->telefone = '(98) 00000-0000'; $user->name = 'Administrador'; $user->email = 'marcio@sedes.com.br';
                $user->perfil = 'adm'; $user->password = bcrypt('123456'); $user->municipio_id = 1;
        $user->save();
        */

        return view('acessologin');
    }

    public function check(Request $request)
    {

        if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)){
            return redirect()->back()->withInput()->withErrors(['O email não é válido!']);
        }

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if(Auth::attempt($credentials)){
            $userInfo = User::where('email', '=', $request->email)->first();

            if($userInfo->perfil == 'ina'){
                Auth::logout();
                return redirect()->back()->withInput()->withErrors(['Usuário inativo!']);
            }

            $request->session()->put('idUsuarioLogado', $userInfo->id);
            $request->session()->put('nameUsuarioLogado', $userInfo->name);
            $request->session()->put('emailUsuarioLogado', $userInfo->email);

            //return redirect()->route('admin.residuo.index');
            return redirect()->route('admin.produto.index');
        }

        return redirect()->back()->withInput()->withErrors(['Usuário e/ou Senha não conferem!']);

    }


    public function logout()
    {
        Auth::logout();
	    return redirect()->route('acesso.login');
    }

}
