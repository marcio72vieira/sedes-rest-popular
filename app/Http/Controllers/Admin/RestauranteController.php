<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurante;
use App\Models\Municipio;
use App\Models\Bairro;
use App\Models\Empresa;
use App\Models\User;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\RestauranteCreateRequest;
use App\Http\Requests\RestauranteUpdateRequest;
use App\Models\Nutricionista;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RestauranteController extends Controller
{

    public function index()
    {
        $restaurantes = Restaurante::all();
        return view('admin.restaurante.index', compact('restaurantes'));
    }


    public function getbairrosrestaurante(Request $request)
    {
        $condicoes = [
            ['municipio_id', '=', $request->municipio_id],
            ['ativo', '=', 1]
        ];

        $data['bairros'] = Bairro::where($condicoes)->orderBy('nome', 'ASC')->get();
        return response()->json($data);
    }


    public function getnutricionistasempresas(Request $request)
    {
        $condicoes = [
            ['empresa_id', '=', $request->empresa_id],
            ['ativo', '=', 1]
        ];

        $data['nutricionistas'] = Nutricionista::where($condicoes)->orderBy('nomecompleto', 'ASC')->get();
        return response()->json($data);
    }


    public function create()
    {
        $municipios = Municipio::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $bairros = Bairro::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $empresas = Empresa::where('ativo', '=', '1')->orderBy('nomefantasia', 'ASC')->get();
        $users = User::where('perfil', '=', 'nut')->orderBy('nomecompleto', 'ASC')->get();

        return view('admin.restaurante.create', compact('municipios', 'bairros', 'empresas', 'users'));
    }


    public function store(RestauranteCreateRequest $request)
    {
        Restaurante::create([
            'identificacao'     => $request['identificacao'],
            'logradouro'        => $request['logradouro'],
            'numero'            => $request['numero'],
            'complemento'       => $request['complemento'],
            'municipio_id'      => $request['municipio_id'],
            'bairro_id'         => $request['bairro_id'],
            'cep'               => $request['cep'],
            'empresa_id'        => $request['empresa_id'],
            'nutricionista_id'  => $request['nutricionista_id'],
            'user_id'           => $request['user_id'],
            'ativo'             => $request['ativo'],
        ]);

        $request->session()->flash('sucesso', 'Registro incluído com sucesso!');

        return redirect()->route('admin.restaurante.index');

    }


    public function show($id)
    {
        //
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
