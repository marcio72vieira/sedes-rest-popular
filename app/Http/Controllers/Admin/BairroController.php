<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Municipio;
use App\Models\Bairro;
use App\Http\Requests\BairroCreateRequest;
use App\Http\Requests\BairroUpdateRequest;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BairroController extends Controller
{

    public function index()
    {
        $bairros = Bairro::all();
        return view('admin.bairro.index', compact('bairros'));
    }


    public function create()
    {
        $municipios = Municipio::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        return view('admin.bairro.create', compact('municipios'));
    }


    public function store(BairroCreateRequest $request)
    {
        Bairro::create($request->all());

        $request->session()->flash('sucesso', 'Registro incluído com sucesso!');

        return redirect()->route('admin.bairro.index');
    }


    public function show($id)
    {
        $municipios = Municipio::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $bairro = Bairro::find($id);

        return view('admin.bairro.show', compact('municipios', 'bairro'));
    }


    public function edit($id)
    {
        $municipios = Municipio::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $bairro = Bairro::find($id);

        return view('admin.bairro.edit', compact('municipios', 'bairro'));
    }


    public function update($id, BairroUpdateRequest $request)
    {
        $bairro = Bairro::find($id);

        // Validação unique
        Validator::make($request->all(), [
            'nome' => [
                'required',
                Rule::unique('bairros')->ignore($bairro->id),
            ],
        ]);


        $bairro->update($request->all());

        $request->session()->flash('sucesso', 'Registro atualizado com sucesso!');

        return redirect()->route('admin.bairro.index');
    }


    public function destroy($id, Request $request)
    {
        Bairro::destroy($id);

        $request->session()->flash('sucesso', 'Registro excluído com sucesso!');

        return redirect()->route('admin.bairro.index');
    }
}
