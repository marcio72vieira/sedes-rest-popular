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
use App\Models\Comprovante;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CompraController extends Controller
{

    public function index($idrestaurante)
    {
        $restaurante = Restaurante::find($idrestaurante);
        $produtos = Produto::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $compras = Compra::where('restaurante_id', '=', $idrestaurante)->orderBy('data_ini', 'DESC')->get();

        //Recupera em uma collection o número de registros relacionados, para impedir deleção acidental.
        //Todos os registros relacionados entre comprovante e compra, independente de seus IDs serão recuperados
        $comprovantes = Comprovante::withCount('compra')->get();
        //Transforma a collection ($comprovante) retornada pelo ->get() em um array.
        $turnarray = $comprovantes->toArray();
        //Do array retornado, extrai apenas os valores da chave compra_id
        //Na view, comparo o id da compra corrente dentro do foreach com os id's do array $regsvinculados
        $regsvinculado = Arr::pluck($turnarray, 'compra_id');
        
        return view('admin.compra.index', compact('restaurante', 'compras', 'produtos', 'regsvinculado'));
    }


    public function create($idrestaurante)
    {
        $restaurante = Restaurante::find($idrestaurante);

        $produtos = Produto::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $medidas = Medida::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();


        return view('admin.compra.create', compact('restaurante', 'produtos', 'medidas'));
    }


    public function store(CompraCreateRequest $request, $idrestaurante)
    {

        $arrProdIds = [];
        $arrCampos = [];
        $arrMesclado = [];


        for($x = 0; $x < count($request->produto_id); $x++){
            $arrProdIds[] = $request->produto_id[$x];
            $arrCampos[] = $request->quantidade[$x];

            //$user->roles()->sync([1 => ['expires' => true], 2, 3]);
            $arrMesclado[$arrProdIds[$x]] = ['quantidade' => $request->quantidade[$x], 'medida_id' => $request->medida_id[$x], 'detalhe' => $request->detalhe[$x], 'preco' => $request->preco[$x], 'af' => $request->af_hidden[$x], 'precototal' => $request->precototal[$x]];
        }


        DB::beginTransaction();
            //Com o $resquest->all(), só os campos definidos no model (propriedade $fillable) serão gravados
             $compra = Compra::create($request->all());
            
            $compra->produtos()->sync($arrMesclado); 

        DB::commit();

        $request->session()->flash('sucesso', 'Registro incluído com sucesso!');

        return redirect()->route('admin.restaurante.compra.index', $idrestaurante);
    }


    public function show($idrestaurante, $idcompra)
    {
        $restaurante = Restaurante::find($idrestaurante);
        $compra = Compra::with('produtos')->find($idcompra);
        $medidas = Medida::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();

        //dd([$restaurante, $compra, $medidas]);

        return view('admin.compra.show', compact('restaurante', 'compra', 'medidas'));
    }


    public function edit($idrestaurante, $idcompra)
    {
        $restaurante = Restaurante::find($idrestaurante);

        $compra = Compra::with('produtos')->find($idcompra);

        //$produtos = Produto::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $produtos = Produto::where('ativo', '=', '1')->get();
        $medidas = Medida::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();


        return view('admin.compra.edit', compact('restaurante', 'compra', 'produtos', 'medidas'));
    }


    public function update(CompraUpdateRequest $request, $idrestaurante, $idcompra)
    {

        $compra = Compra::find($idcompra);

        $arrProdIds = [];
        $arrCampos = [];
        $arrMesclado = [];


        for($x=0; $x < count($request->produto_id); $x++){
            $arrProdIds[] = $request->produto_id[$x];
            $arrCampos[] = $request->quantidade[$x];

            $arrMesclado[$arrProdIds[$x]] = ['quantidade' => $request->quantidade[$x], 'medida_id' => $request->medida_id[$x], 'detalhe' => $request->detalhe[$x], 'preco' => $request->preco[$x], 'af' => $request->af_hidden[$x], 'precototal' => $request->precototal[$x]];
        }

        DB::beginTransaction();

            $compra->update($request->all());

            $compra->produtos()->sync($arrMesclado); 

        DB::commit();

        $request->session()->flash('sucesso', 'Registro atualizado com sucesso!');

        return redirect()->route('admin.restaurante.compra.index', $idrestaurante);
    }




    public function destroy($idrestaurante, $idcompra, Request $request)
    {

        Compra::destroy($idcompra);

        $request->session()->flash('sucesso', 'Registro excluído com sucesso!');

        return redirect()->route('admin.restaurante.compra.index', $idrestaurante);
    }
}
