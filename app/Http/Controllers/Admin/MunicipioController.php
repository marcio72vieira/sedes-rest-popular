<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Municipio;
use App\Http\Requests\MunicipioCreateRequest;
use App\Http\Requests\MunicipioUpdateRequest;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class MunicipioController extends Controller
{
    public function index()
    {
        $municipios = Municipio::all();

        return view('admin.municipio.index', compact('municipios'));
    }


    public function create()
    {
        return view('admin.municipio.create');
    }


    public function store(MunicipioCreateRequest $request)
    {
        Municipio::create($request->all());

        $request->session()->flash('sucesso', 'Registro incluído com sucesso!');

        return redirect()->route('admin.municipio.index');
    }


    public function show($id)
    {
        $municipio = Municipio::find($id);

        return view('admin.municipio.show', compact('municipio'));
    }


    public function edit($id)
    {
        $municipio = Municipio::find($id);

        return view('admin.municipio.edit', compact('municipio'));
    }


    public function update($id, MunicipioUpdateRequest $request)
    {
        $municipio = Municipio::find($id);

        // Validação unique
        Validator::make($request->all(), [
            'nome' => [
                'required',
                Rule::unique('municipios')->ignore($municipio->id),
            ],
        ]);


        $municipio->update($request->all());

        $request->session()->flash('sucesso', 'Registro atualizado com sucesso!');

        return redirect()->route('admin.municipio.index');
    }


    public function destroy($id, Request $request)
    {
        Municipio::destroy($id);

        $request->session()->flash('sucesso', 'Registro excluído com sucesso!');

        return redirect()->route('admin.municipio.index');
    }
}
