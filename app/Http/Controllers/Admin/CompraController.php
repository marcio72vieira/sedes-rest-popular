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


        return view('admin.compra.create', compact('restaurante', 'produtos', 'medidas'));
    }


    public function store(CompraCreateRequest $request, $idrestaurante)
    {
        /*
        //dd($request->all());

        Compra::create([
            'semana'            => $request['semana'],
            'data_ini'          => $request['data_ini'],
            'data_fin'          => $request['data_fin'],
            'valor'             => $request['valor'],
            'valoraf'           => $request['valoraf'],
            'valortotal'        => $request['valortotal'],
            //'valortotal'      => $request['valor'] + $request['valoraf'],
            'restaurante_id'    => $idrestaurante
        ]);
        */


        DB::beginTransaction();

            //Com o $resquest->all(), só os campos definidos no model (propriedade $fillable) serão gravados
            $compra = Compra::create($request->all());

            $produto = $request->input('produto_id', []);
            $quantidade = $request->input('quantidade', []);
            $medida_id = $request->input('medida_id', []);
            $detalhe = $request->input('detalhe', []);
            $preco = $request->input('preco', []);
            $af_hidden = $request->input('af_hidden', []); // Substituido: $af = $request->input('af', []);
            $precototal = $request->input('precototal', []);

            for ($item = 0; $item < count($produto); $item++) {

                if ($produto[$item] != '') {

                    $compra->produtos()->attach($produto[$item],
                        [
                            'quantidade' => $quantidade[$item],
                            'medida_id' => $medida_id[$item],
                            'detalhe' => $detalhe[$item],
                            'preco' => $preco[$item],
                            //'af' => (isset($_POST['af'][$item]) ? 'sim' : 'nao' ),  // Vefifica se o checkbox existe. Substituido
                            'af' =>  $af_hidden[$item],
                            'precototal' => $precototal[$item],
                        ]);
                }
            }
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

        $produtos = Produto::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $medidas = Medida::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();


        return view('admin.compra.edit', compact('restaurante', 'compra', 'produtos', 'medidas'));
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
