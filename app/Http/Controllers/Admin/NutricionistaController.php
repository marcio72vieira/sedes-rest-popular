<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\NutricionistaCreateRequest;
use App\Http\Requests\NutricionistaUpdateRequest;
use App\Models\Nutricionista;
use App\Models\Empresa;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class NutricionistaController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth', ['except' => ['index', 'show']]);
        $this->middleware(['auth', 'can:adm']);
    }


    public function index($idempresa)
    {
        $empresa = Empresa::find($idempresa);
        $nutricionistas = Nutricionista::where('empresa_id', '=', $idempresa)->get();

        // Relação de empresas para a necessidade de Remanejamento
        $empresas = Empresa::where('ativo', '=', '1')->orderBy('nomefantasia', 'ASC')->get();

        //Forma errada. Não quero todos os nutricionistas do banco, apenas a da empresaa corrente ($idempresa)
        //$nutricionistas = Nutricionista::all();

        return view('admin.nutricionista.index', compact('empresa','nutricionistas', 'empresas'));
    }


    public function create($idempresa)
    {
        $empresa = Empresa::find($idempresa);
        return view('admin.nutricionista.create', compact('empresa'));
    }


    public function store(NutricionistaCreateRequest $request, $idempresa)
    {
        Nutricionista::create([
            'nomecompleto'  => $request['nomecompleto'],
            'cpf'           => $request['cpf'],
            'crn'           => $request['crn'],
            'email'         => $request['email'],
            'telefone'      => $request['telefone'],
            'ativo'         => $request['ativo'],
            'empresa_id'    => $idempresa
        ]);

        $request->session()->flash('sucesso', 'Registro incluído com sucesso!');

        return redirect()->route('admin.empresa.nutricionista.index', $idempresa);
    }


    public function show($idempresa, $idnutricionista)
    {
        $empresa = Empresa::find($idempresa);
        $nutricionista = Nutricionista::find($idnutricionista);

        return view('admin.nutricionista.show', compact('empresa', 'nutricionista'));
    }


    public function edit($idempresa, $idnutricionista)
    {
        $empresa = Empresa::find($idempresa);
        $nutricionista = Nutricionista::find($idnutricionista);

        return view('admin.nutricionista.edit', compact('empresa', 'nutricionista'));
    }


    public function update(NutricionistaUpdateRequest $request, $idempresa, $idnutricionista)
    {
        $nutricionista = nutricionista::find($idnutricionista);

            $nutricionista->nomecompleto     = $request->nomecompleto;
            $nutricionista->cpf              = $request->cpf;
            $nutricionista->crn              = $request->crn;
            $nutricionista->email            = $request->email;
            $nutricionista->telefone         = $request->telefone;
            $nutricionista->ativo            = $request->ativo;
            $nutricionista->empresa_id       = $idempresa;

            Validator::make($request->all(), [
                'cpf' => [
                    'required',
                    Rule::unique('nutricionistas')->ignore($nutricionista->id),
                ],
                'email' => [
                    'required',
                    'email',
                    Rule::unique('nutricionistas')->ignore($nutricionista->id),
                ],
            ]);

            $nutricionista->save();

            $request->session()->flash('sucesso', 'Registro editado com sucesso!');

            return redirect()->route('admin.empresa.nutricionista.index', $idempresa);
    }


    public function destroy($idempresa, $idnutricionista, Request $request)
    {
        Nutricionista::destroy($idnutricionista);

        $request->session()->flash('sucesso', 'Registro excluído com sucesso!');

        return redirect()->route('admin.empresa.nutricionista.index', $idempresa);
    }
}
