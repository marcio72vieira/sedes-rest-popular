<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Compra;
use App\Http\Requests\CategoriaCreateRequest;
use App\Http\Requests\CategoriaUpdateRequest;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class ComprovanteController extends Controller
{

    public function index($idcompra)
    {

        $compra = Compra::find($idcompra);
        $comprovantes = ["Nota nº {$idcompra}"];

        return view('admin.comprovante.index', compact('compra', 'comprovantes'));
        //return "Comprovantes relativos à compra: {$idcompra} ".$idcompra ;

    }


    public function create($idcompra)
    {
        $compra = Compra::find($idcompra);

        return view('admin.comprovante.create', compact('compra'));
    }


    public function store(Request $request, $idcompra)
    {
        //dd($request->file('comprovante')); ou //dd($request->'comprovante');

        $compra = Compra::find($idcompra);

        //$restaurante = $compra->restaurante['identificacao'];
        $restaurante = Str::lower($compra->restaurante->identificacao);






        // Checando se veio a imagem/arquivo na requisição e depoois verifica se não houve erro de upload na imagem.
        if($request->hasFile('comprovante')) {

            if($request->comprovante->isValid()) {
                // primeiro parâmetro, local onde se quer armazenar o arquivo (dentro da pasta : documentos/restaurante/compra). Se não existir é criado a pasta
                // segundo parâmetro, qual disco (local, public ou S3), deseja-se armazenar o upload. No caso será o 'public'.
                // Obs: O método store, retorna o caminho onde o arquivo foi armazenado no disco.

                // Armazenando o arquivo no disco public e retornando a url (caminho) do arquivo
                $comprovanteURL = $request->comprovante->store('documentos/$restaurante/$compra->id', 'public');

                /*
                //Armazenando os caminhos do arquivo no Banco de Dados
                $comprovante = new Comprovante();
                $comprovante->url = $comprovanteURL;
                $comprovante->compra_id = $idcompra;
                $comprovante->save();
                */

            }
        }

        $request->session()->flash('sucesso', 'Comprovante armazenado com sucesso!');

        return redirect()->route('admin.compra.comprovante.index', $idcompra);
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }

}
