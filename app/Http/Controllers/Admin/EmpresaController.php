<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Municipio;
use App\Models\Bairro;
use App\Models\Banco;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\EmpresaCreateRequest;
use App\Http\Requests\EmpresaUpdateRequest;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EmpresaController extends Controller
{

    public function index()
    {
        $empresas = Empresa::all();
        return view('admin.empresa.index', compact('empresas'));
    }

    public function create()
    {
        $municipios = Municipio::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();

        return view('admin.empresa.create', compact('municipios'));
    }


    public function store(EmpresaCreateRequest $request)
    {
        Empresa::create([
            'razaosocial'   => $request['razaosocial'],
            'nomefantasia'  => $request['nomefantasia'],
            'cnpj'          => $request['cnpj'],
            'titular'       => $request['titular'],
            'cargotitular'  => $request['cargotitular'],
            'logradouro'    => $request['logradouro'],
            'numero'        => $request['numero'],
            'complemento'   => $request['complemento'],
            'municipio_id'  => $request['municipio_id'],
            'bairro'        => $request['bairro'],
            'cep'           => $request['cep'],
            'email'         => $request['email'],
            'celular'       => $request['celular'],
            'fone'          => $request['fone'],
            'ativo'         => $request['ativo'],
        ]);


        $request->session()->flash('sucesso', 'Registro incluído com sucesso!');

        return redirect()->route('admin.empresa.index');

    }


    public function show($id)
    {
        // Resgata registro através do eager-load
        $empresa = Empresa::with(['municipio'])->find($id);

        return view('admin.empresa.show', compact('empresa'));
    }


    public function edit($id)
    {
        $empresa = Empresa::find($id);
        $municipios = Municipio::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        
        return view('admin.empresa.edit', compact('empresa', 'municipios'));
    }


    public function update(EmpresaUpdateRequest $request, $id)
    {
        $empresa = Empresa::find($id);

        // Validação unique para cnpj na atualização
        Validator::make($request->all(), [
            'cnpj' => [
                'required',
                Rule::unique('empresas')->ignore($empresa->id),
            ],
        ]);

        $empresa->update($request->all());

        $request->session()->flash('sucesso', 'Registro atualizado com sucesso!');

        return redirect()->route('admin.empresa.index');
    }



    public function destroy($id, Request $request)
    {
        $empresa = Empresa::find($id);

        Empresa::destroy($id);

        $request->session()->flash('sucesso', 'Registro excluído com sucesso!');

        return redirect()->route('admin.empresa.index');
    }
}
