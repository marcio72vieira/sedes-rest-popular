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
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;


class ComprovanteController extends Controller
{

    public function index($idcompra)
    {
        $idcompra = mrc_encrypt_decrypt('decrypt', $idcompra);

        $compra = Compra::findOrFail($idcompra);
        $comprovantes = Comprovante::where('compra_id', '=', $idcompra)->get();

        return view('admin.comprovante.index', compact('compra', 'comprovantes'));

    }


    public function create($idcompra)
    {
        $idcompra = mrc_encrypt_decrypt('decrypt', $idcompra);

        $compra = Compra::findOrFail($idcompra);

        return view('admin.comprovante.create', compact('compra'));
    }


    public function store(ComprovanteCreateRequest $request, $idcompra)
    {



        $compra = Compra::findOrFail($idcompra);

        // Recuperando a identificação do restaurante da compra atual
        // $restaurante = Str::lower($compra->restaurante->identificacao);


        // Checando se veio a imagem/arquivo na requisição e depoois verifica se não houve erro de upload na imagem.
        if($request->hasFile('url')) {

            if($request->url->isValid()) {

                // Armazenando o arquivo no disco public e retornando a url (caminho) do arquivo
                //$comprovanteURL = $request->url->store("notasrecibos/$restaurante/$compra->id", "public");
                $comprovanteURL = $request->url->store("notasrecibos/rest_$compra->restaurante_id/$compra->id", "public");

                //Armazenando os caminhos do arquivo no Banco de Dados
                $comprovante = new Comprovante();
                    $comprovante->url = $comprovanteURL;
                    $comprovante->restaurante_id = $compra->restaurante_id;
                    $comprovante->compra_id = $idcompra;
                $comprovante->save();

            } else {
                $request->session()->flash('error', 'Houve umm erro em processaar o arquivo!');
                return redirect()->route('admin.compra.comprovante.index', $idcompra);
            }
        } else {
            $request->session()->flash('error', 'Houve umm erro em processaar o arquivo!');
            return redirect()->route('admin.compra.comprovante.index', $idcompra);
        }

        $request->session()->flash('sucesso', 'Comprovante armazenado com sucesso!');

        $idcompra = mrc_encrypt_decrypt('encrypt', $idcompra);

        return redirect()->route('admin.compra.comprovante.index', $idcompra);
    }





    public function destroy(Request $request, $idcompra, $idcomprovante)
    {
        //Recuperando informações
        $comprovante = Comprovante::find($idcomprovante);
        $restaurante =  $comprovante->restaurante_id;

        // Apagando fisicamente o arquivo do disco //Storage::delete($comprovante->url); OU
        if(Storage::exists($comprovante->url)){
            Storage::disk('public')->delete($comprovante->url);
        }

        // Apagando o registro no banco de dados
        $comprovante->delete();

        // APAGANDO O DIRETÓRIO, CASO NÃO EXISTA ARQUIVOS NO MESMO
        // Retorna um array de trodos os arquivos dentro do diretório
        $files = Storage::files('notasrecibos/rest_'.$restaurante.'/'.$idcompra);

        // Se não há arquivos dentro do diretório, deleta o diretório
        if(count($files) == 0){
            Storage::deleteDirectory('notasrecibos/rest_'.$restaurante.'/'.$idcompra);
        }

        $idcompra = mrc_encrypt_decrypt('encrypt', $idcompra);

        $request->session()->flash('sucesso', 'Comprovante deletado com sucesso!');
        return redirect()->route('admin.compra.comprovante.index', $idcompra);

    }

}
