<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Models\Municipio;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function index()
    {
        $users = User::all();

        return view('admin.user.index', compact('users'));
    }


    public function create()
    {
        $municipios = Municipio::orderBy('nome', 'ASC')->get();

        return view('admin.user.create', compact('municipios'));
    }


    public function store(UserCreateRequest $request)
    {
        $user = new User();

            $user->nomecompleto = $request->nomecompleto;
            $user->cpf = $request->cpf;
            $user->crn = $request->crn;
            $user->telefone = $request->telefone;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->municipio_id = $request->municipio_id;
            $user->perfil = $request->perfil;
            $user->password = bcrypt($request->password);

            $user->save();

            $request->session()->flash('sucesso', 'Registro incluído com sucesso!');

            return redirect()->route('admin.user.index');
    }


    public function show($id)
    {
        $user = User::find($id);

        return view('admin.user.show', compact('user'));
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
