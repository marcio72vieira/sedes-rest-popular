<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Http\Requests\CategoriaCreateRequest;
use App\Http\Requests\CategoriaUpdateRequest;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoriaController extends Controller
{

    public function index()
    {
        $categorias = Categoria::all();

        return view('admin.categoria.index', compact('categorias'));
    }


    public function create()
    {
        return view('admin.categoria.create');
    }


    public function store(CategoriaCreateRequest $request)
    {
        Categoria::create($request->all());

        $request->session()->flash('sucesso', 'Registro incluído com sucesso!');

        return redirect()->route('admin.categoria.index');
    }


    public function show($id)
    {
        $categoria = Categoria::find($id);

        return view('admin.categoria.show', compact('categoria'));
    }


    public function edit($id)
    {
        $categoria = Categoria::find($id);

        return view('admin.categoria.edit', compact('categoria'));
    }


    public function update($id, CategoriaUpdateRequest $request)
    {
        $categoria = Categoria::find($id);

        // Validação unique
        Validator::make($request->all(), [
            'nome' => [
                'required',
                Rule::unique('categorias')->ignore($categoria->id),
            ],
        ]);


        $categoria->update($request->all());

        $request->session()->flash('sucesso', 'Registro atualizado com sucesso!');

        return redirect()->route('admin.categoria.index');
    }


    public function destroy($id, Request $request)
    {
        Categoria::destroy($id);

        $request->session()->flash('sucesso', 'Registro excluído com sucesso!');

        return redirect()->route('admin.categoria.index');
    }
}
