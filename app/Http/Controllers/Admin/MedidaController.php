<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medida;
use App\Http\Requests\MedidaCreateRequest;
use App\Http\Requests\MedidaUpdateRequest;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class MedidaController extends Controller
{
    public function index()
    {
        $medidas = Medida::all();

        return view('admin.medida.index', compact('medidas'));
    }


    public function create()
    {
        return view('admin.medida.create');
    }


    public function store(MedidaCreateRequest $request)
    {
        Medida::create($request->all());

        $request->session()->flash('sucesso', 'Registro incluído com sucesso!');

        return redirect()->route('admin.medida.index');
    }


    public function show($id)
    {
        $medida = Medida::find($id);

        return view('admin.medida.show', compact('medida'));
    }


    public function edit($id)
    {
        $medida = Medida::find($id);

        return view('admin.medida.edit', compact('medida'));
    }


    public function update($id, MedidaUpdateRequest $request)
    {
        $medida = Medida::find($id);

        // Validação unique
        Validator::make($request->all(), [
            'nome' => [
                'required',
                Rule::unique('Medidas')->ignore($medida->id),
            ],
        ]);


        $medida->update($request->all());

        $request->session()->flash('sucesso', 'Registro atualizado com sucesso!');

        return redirect()->route('admin.medida.index');
    }


    public function destroy($id, Request $request)
    {
        Medida::destroy($id);

        $request->session()->flash('sucesso', 'Registro excluído com sucesso!');

        return redirect()->route('admin.medida.index');
    }
}

