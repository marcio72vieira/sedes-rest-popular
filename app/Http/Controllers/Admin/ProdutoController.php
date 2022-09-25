<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Produto;
use App\Http\Requests\ProdutoCreateRequest;
use App\Http\Requests\ProdutoUpdateRequest;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use File;

class ProdutoController extends Controller
{
    
    public function index()
    {
        /*
        Exemplo rústico de registro de log.
        $data = json_encode([time(),'produto','lista', session('idUsuarioLogado'), session('nameUsuarioLogado')]);
        $file = time() .rand(). '_file.json';
        $destinationPath=public_path()."/upload/";
        if (!is_dir($destinationPath)) {  mkdir($destinationPath,0777,true);  }
        File::put($destinationPath.$file,$data);
        //return response()->download($destinationPath.$file);
        */
        
        $produtos = Produto::all();
        return view('admin.produto.index', compact('produtos'));
    }

    
    public function create()
    {
        $categorias = Categoria::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        return view('admin.produto.create', compact('categorias'));
    }

    
    public function store(ProdutoCreateRequest $request)
    {
        Produto::create($request->all());

        $request->session()->flash('sucesso', 'Registro incluído com sucesso!');

        return redirect()->route('admin.produto.index');
    }

    
    public function show($id)
    {
        $categorias = Categoria::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $produto = Produto::find($id);

        return view('admin.produto.show', compact('categorias', 'produto'));
    }

   
    public function edit($id)
    {
        $categorias = Categoria::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $produto = Produto::find($id);

        return view('admin.produto.edit', compact('categorias', 'produto'));
    }

    
    public function update($id, ProdutoUpdateRequest $request)
    {
        $produto = Produto::find($id);

        // Validação unique
        Validator::make($request->all(), [
            'nome' => [
                'required',
                Rule::unique('produtos')->ignore($produto->id),
            ],
        ]);


        $produto->update($request->all());

        $request->session()->flash('sucesso', 'Registro atualizado com sucesso!');

        return redirect()->route('admin.produto.index');
    }

    
    public function destroy($id, Request $request)
    {
        Produto::destroy($id);

        $request->session()->flash('sucesso', 'Registro excluído com sucesso!');

        return redirect()->route('admin.bairro.index');

    }
}
