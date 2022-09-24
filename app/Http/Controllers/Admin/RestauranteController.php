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
        $nutricionistas = Nutricionista::where('ativo', '=', '1')->orderBy('nomecompleto', 'ASC')->get();
        $users = User::where('perfil', '=', 'nut')->orderBy('nomecompleto', 'ASC')->get();

        return view('admin.restaurante.create', compact('municipios', 'bairros', 'empresas', 'nutricionistas','users'));
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
        // Resgata registro através do eager-load
        // $empresa = Empresa::with(['municipio', 'bairro', 'banco'])->find($id);
        $restaurante = Restaurante::with(['municipio', 'bairro'])->find($id);

        return view('admin.restaurante.show', compact('restaurante'));
    }


    public function edit($id)
    {
        $restaurante = Restaurante::find($id);

        $municipios = Municipio::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $bairros = Bairro::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $empresas = Empresa::where('ativo', '=', '1')->orderBy('nomefantasia', 'ASC')->get();
        $nutricionistas = Nutricionista::where('ativo', '=', '1')->orderBy('nomecompleto', 'ASC')->get();
        $users = User::where('perfil', '=', 'nut')->orderBy('nomecompleto', 'ASC')->get();
    
        return view('admin.restaurante.edit', compact('restaurante', 'municipios', 'bairros', 'empresas', 'nutricionistas', 'users'));
    }


    public function update(RestauranteUpdateRequest $request, $id)
    {
        $restaurante = Restaurante::find($id);

        // Validação unique para cnpj na atualização
        Validator::make($request->all(), [
            'cnpj' => [
                'required',
                Rule::unique('restaurantes')->ignore($restaurante->id),
            ],
        ]);

        $restaurante->update($request->all());

        $request->session()->flash('sucesso', 'Registro atualizado com sucesso!');

        return redirect()->route('admin.restaurante.index');
    }


    public function destroy($id, Request $request)
    {
        $restaurante = Restaurante::find($id);

        Restaurante::destroy($id);

        $request->session()->flash('sucesso', 'Registro excluído com sucesso!');

        return redirect()->route('admin.restaurante.index');
    }
}
