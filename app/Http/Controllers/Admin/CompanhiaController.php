<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Companhia;
use App\Models\Municipio;
use App\Models\Bairro;
use App\Models\Banco;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CompanhiaCreateRequest;
use App\Http\Requests\CompanhiaUpdateRequest;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CompanhiaController extends Controller
{

    public function index()
    {
        $companhias = Companhia::all();
        return view('admin.companhia.index', compact('companhias'));
    }


    public function getbairros(Request $request)
    {
        $condicoes = [
            ['municipio_id', '=', $request->municipio_id],
            ['ativo', '=', 1]
        ];

        $data['bairros'] = Bairro::where($condicoes)->orderBy('nome', 'ASC')->get();
        return response()->json($data);
    }


    public function create()
    {
        $municipios = Municipio::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $bairros = Bairro::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        //$bancos = Banco::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();

        //return view('admin.empresa.create', compact('municipios', 'bairros', 'bancos'));
        return view('admin.companhia.create', compact('municipios', 'bairros'));
    }


    public function store(CompanhiaCreateRequest $request)
    {
        // Atribuindo um nome ao arquivo e Gravando ele fisicamene no diretório: storage/public/documentos/nome_do_arquivo.pdf
        if($request->file()){
            //Retirando . / e - do cnpj para ficar apenas os números
            //$filename = 'doc_'.Str::replace(['.', '/', '-'], '',$request['cnpj']).'_cnpj.pdf';   //doc_123456_cnpj.pdf
            $filename = 'doc_'.time().'.pdf';
            $filepath = $request->file('documentocnpj')->storeAs('documentos', $filename, 'public');
        }


        Companhia::create([
            'razaosocial'   => $request['razaosocial'],
            'nomefantasia'  => $request['nomefantasia'],
            'cnpj'          => $request['cnpj'],
            'codigocnae'    => $request['codigocnae'],
            //'documentocnpj' => '/storage/'.$filepath,
            'documentocnpj' => $filepath,
            'titularum'     => $request['titularum'],
            'cargotitum'    => $request['cargotitum'],
            'titulardois'   => $request['titulardois'],
            'cargotitdois'  => $request['cargotitdois'],
            'banco_id'      => $request['banco_id'],
            'agencia'       => $request['agencia'],
            'conta'         => $request['conta'],
            'logradouro'    => $request['logradouro'],
            'numero'        => $request['numero'],
            'complemento'   => $request['complemento'],
            'municipio_id'  => $request['municipio_id'],
            'bairro_id'     => $request['bairro_id'],
            'cep'           => $request['cep'],
            'emailum'       => $request['emailum'],
            'emaildois'     => $request['emailum'],
            'celular'       => $request['celular'],
            'foneum'        => $request['foneum'],
            'fonedois'      => $request['fonedois'],
            'ativo'         => $request['ativo'],
        ]);


        $request->session()->flash('sucesso', 'Registro incluído com sucesso!');

        return redirect()->route('admin.companhia.index');

        /* Forma anterior como estava sendo gravado os dados, antes de fazer o upload de arquivo (forma mais sucinta)
        Empresa::create($request->all());
        $request->session()->flash('sucesso', 'Registro incluído com sucesso!');
        return redirect()->route('admin.empresa.index');
        */
    }


    public function show($id)
    {
        // Resgata registro através do eager-load
        // $empresa = Empresa::with(['municipio', 'bairro', 'banco'])->find($id);
        $companhia = Companhia::with(['municipio', 'bairro'])->find($id);

        return view('admin.companhia.show', compact('companhia'));
    }


    public function edit($id)
    {
        $companhia = Companhia::find($id);
        //$bairros = Bairro::where('municipio_id', '=', $empresa->municipio_id)->where('ativo', '=', 1)->orderBy('nome', 'ASC')->get();
        $bairros = Bairro::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $municipios = Municipio::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        //$bancos = Banco::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();

        //return view('admin.empresa.edit', compact('empresa', 'bairros', 'municipios', 'bancos'));
        return view('admin.companhia.edit', compact('companhia', 'bairros', 'municipios'));
    }


    public function update(CompanhiaUpdateRequest $request, $id)
    {
        $companhia = Companhia::find($id);

        // Validação unique para cnpj na atualização
        Validator::make($request->all(), [
            'cnpj' => [
                'required',
                Rule::unique('companhias')->ignore($companhia->id),
            ],
        ]);

        // Verifica se no processo de alteração, o campo do tipo file foi alterado, indicando que o
        // usuário deseja alterar o arquivo .pdf
        if($request->file()){
            // Delete fisicamente o arquivo da pasta storage/app/public/documentos/nome_arquivo.pdf, recuperando o
            // seu nome do banco de dados vindo no campo $empresaa->documentocnpj.
            $documentfile = $companhia->documentocnpj;
            Storage::disk('public')->delete([$documentfile]);

            //$filename = 'doc_'.Str::replace(['.', '/', '-'], '',$request['cnpj']).'_cnpj.pdf';
            $filename = 'doc_'.time().'.pdf';
            $filepath = $request->file('file')->storeAs('documentos', $filename, 'public');

            // Alterando o valor do campo 'documentocnpj' para atualizar no banco com os demais campos que foram possivelmente
            // alterados
            //$request['documentocnpj'] = $filepath;
            $request['documentocnpj'] = 'documentos/'.$filename;

            $companhia->update($request->all());

        }else{
            $companhia->update($request->all());
        }

        $request->session()->flash('sucesso', 'Registro atualizado com sucesso!');

        return redirect()->route('admin.companhia.index');
    }



    public function destroy($id, Request $request)
    {
        $companhia = Companhia::find($id);

        $documento = $companhia->documentocnpj;

        if(Storage::exists($documento)){
            Storage::delete($documento);
        }

        Companhia::destroy($id);

        $request->session()->flash('sucesso', 'Registro excluído com sucesso!');

        return redirect()->route('admin.companhia.index');
    }
}
