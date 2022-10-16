<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Municipio;
use App\Models\Regional;
use App\Http\Requests\MunicipioCreateRequest;
use App\Http\Requests\MunicipioUpdateRequest;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\DB;


class MunicipioController extends Controller
{
    public function index()
    {
        $municipios = Municipio::with('regional')->get();

        return view('admin.municipio.index', compact('municipios'));
    }

    public function getamountbairros(Request $request)
    {
        /*
        $condicoes = [
            ['municipio_id', '=', $request->municipio_id],
            ['ativo', '=', 1]
        ];
        $data['bairros'] = Bairro::where($condicoes)->orderBy('nome', 'ASC')->get();
        */
        $id = $request->municipio_id;

        $data['qtd_bairros'] = DB::table('bairros')->where('municipio_id', '=', $id)->count();
        return response()->json($data);
    }


    public function create()
    {
        $regionais = Regional::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        return view('admin.municipio.create', compact('regionais'));
    }


    public function store(MunicipioCreateRequest $request)
    {
        Municipio::create($request->all());

        $request->session()->flash('sucesso', 'Registro incluído com sucesso!');

        return redirect()->route('admin.municipio.index');
    }


    public function show($id)
    {
        $regionais = Regional::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $municipio = Municipio::find($id);

        return view('admin.municipio.show', compact('municipio', 'regionais'));
    }


    public function edit($id)
    {
        $regionais = Regional::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $municipio = Municipio::find($id);

        return view('admin.municipio.edit', compact('regionais', 'municipio'));
    }


    public function update($id, MunicipioUpdateRequest $request)
    {
        $municipio = Municipio::find($id);

        // Validação unique
        Validator::make($request->all(), [
            'nome' => [
                'required',
                Rule::unique('municipios')->ignore($municipio->id),
            ],
        ]);


        $municipio->update($request->all());

        $request->session()->flash('sucesso', 'Registro atualizado com sucesso!');

        return redirect()->route('admin.municipio.index');
    }


    public function destroy($id, Request $request)
    {
        Municipio::destroy($id);

        $request->session()->flash('sucesso', 'Registro excluído com sucesso!');

        return redirect()->route('admin.municipio.index');
    }
}
