<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\Comprovante;
use App\Http\Requests\ComprovanteCreateRequest;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class ComprovanteController extends Controller
{

    public function index($idcompra)
    {

        $compra = Compra::find($idcompra);
        $comprovantes = Comprovante::where('compra_id', '=', $idcompra)->get();

        return view('admin.comprovante.index', compact('compra', 'comprovantes'));

    }


    public function create($idcompra)
    {
        $compra = Compra::find($idcompra);

        return view('admin.comprovante.create', compact('compra'));
    }


    public function store(ComprovanteCreateRequest $request, $idcompra)
    {

       

        $compra = Compra::find($idcompra);

        // Recuperando a identificação do restaurante da compra atual
        $restaurante = Str::lower($compra->restaurante->identificacao);


        // Checando se veio a imagem/arquivo na requisição e depoois verifica se não houve erro de upload na imagem.
        if($request->hasFile('url')) {

            if($request->url->isValid()) {
                
                // Armazenando o arquivo no disco public e retornando a url (caminho) do arquivo
                $comprovanteURL = $request->url->store("documentos/$restaurante/$compra->id", "public");

                //Armazenando os caminhos do arquivo no Banco de Dados
                $comprovante = new Comprovante();
                    $comprovante->url = $comprovanteURL;
                    $comprovante->compra_id = $idcompra;
                $comprovante->save();

            }
        }

        $request->session()->flash('sucesso', 'Comprovante armazenado com sucesso!');

        return redirect()->route('admin.compra.comprovante.index', $idcompra);
    }





    public function destroy($id)
    {
        //
    }

}
