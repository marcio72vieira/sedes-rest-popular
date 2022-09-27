<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurante;
use App\Models\Produto;
use App\Models\Medida;
use App\Models\Compra;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CompraCreateRequest;
use App\Http\Requests\CompraUpdateRequest;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CompraController extends Controller
{

    public function index($idrestaurante)
    {
        $restaurante = Restaurante::find($idrestaurante);
        $produtos = Produto::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $compras = Compra::where('restaurante_id', '=', $idrestaurante)->orderBy('data_ini', 'DESC')->get();

        return view('admin.compra.index', compact('restaurante', 'compras', 'produtos'));
    }


    public function create($idrestaurante)
    {
        $restaurante = Restaurante::find($idrestaurante);

        $produtos = Produto::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $medidas = Medida::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();


        //return view('admin.compra.create', compact('restaurante', 'produtos', 'medidas'));
        return view('admin.compra.createnew', compact('restaurante', 'produtos', 'medidas'));
    }


    public function store(CompraCreateRequest $request, $idrestaurante)
    {
        Compra::create([
            'data_ini'          => $request['data_ini'],
            'data_fin'          => $request['data_fin'],
            'semana'            => $request['semana'],
            'valor'             => $request['valor'],
            'valoraf'           => $request['valoraf'],
            //'valortotal'        => $request['valortotal'],
            'valortotal'        => $request['valor'] + $request['valoraf'],
            'restaurante_id'    => $idrestaurante
        ]);

        $request->session()->flash('sucesso', 'Registro incluído com sucesso!');

        return redirect()->route('admin.restaurante.compra.index', $idrestaurante);
    }


    public function show($idrestaurante, $idcompra)
    {
        $restaurante = Restaurante::find($idrestaurante);
        $compra = Compra::find($idcompra);

        return view('admin.compra.show', compact('restaurante', 'compra'));
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($idrestaurante, $idcompra, Request $request)
    {
        Compra::destroy($idcompra);

        $request->session()->flash('sucesso', 'Registro excluído com sucesso!');

        return redirect()->route('admin.restaurante.compra.index', $idrestaurante);
    }
}
