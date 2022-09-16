<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Municipio;
use App\Models\Bairro;
use App\Models\Banco;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\EmpresaCreateRequest;
use App\Http\Requests\EmpresaUpdateRequest;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EmpresaController extends Controller
{

    public function index()
    {
        $empresas = Empresa::all();
        return view('admin.empresa.index', compact('empresas'));
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
        return view('admin.empresa.create', compact('municipios', 'bairros'));
    }


    public function store(EmpresaCreateRequest $request)
    {
        // Atribuindo um nome ao arquivo e Gravando ele fisicamene no diretório: storage/public/documentos/nome_do_arquivo.pdf
        if($request->file()){
            $filename = 'doc_'.Str::replace(['.', '/', '-'], '',$request['cnpj']).'_cnpj.pdf';   //doc_123456_cnpj.pdf
            $filepath = $request->file('documentocnpj')->storeAs('documentos', $filename, 'public');
        }


        Empresa::create([
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

        return redirect()->route('admin.empresa.index');

        /* Forma anterior como estava sendo gravado os dados, antes de fazer o upload de arquivo (forma mais sucinta)
        Empresa::create($request->all());
        $request->session()->flash('sucesso', 'Registro incluído com sucesso!');
        return redirect()->route('admin.empresa.index');
        */
    }


    public function show($id)
    {
        // Resgata registro através do eager-load
        $empresa = Empresa::with(['municipio', 'bairro', 'banco'])->find($id);

        return view('admin.empresa.show', compact('empresa'));
    }


    public function edit($id)
    {
        $empresa = Empresa::find($id);
        //$bairros = Bairro::where('municipio_id', '=', $empresa->municipio_id)->where('ativo', '=', 1)->orderBy('nome', 'ASC')->get();
        $bairros = Bairro::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $municipios = Municipio::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $bancos = Banco::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();

        return view('admin.empresa.edit', compact('empresa', 'bairros', 'municipios', 'bancos'));
    }


    public function update(EmpresaUpdateRequest $request, $id)
    {
        $empresa = Empresa::find($id);

        // Validação unique para cnpj na atualização
        Validator::make($request->all(), [
            'cnpj' => [
                'required',
                Rule::unique('empresas')->ignore($empresa->id),
            ],
        ]);

        $empresa->update($request->all());

        $request->session()->flash('sucesso', 'Registro atualizado com sucesso!');

        return redirect()->route('admin.empresa.index');
    }



    public function destroy($id, Request $request)
    {
        $empresa = Empresa::find($id);

        $documento = $empresa->documentocnpj;

        if(Storage::exists($documento)){
            Storage::delete($documento);
        }

        Empresa::destroy($id);

        $request->session()->flash('sucesso', 'Registro excluído com sucesso!');

        return redirect()->route('admin.empresa.index');
    }
}
