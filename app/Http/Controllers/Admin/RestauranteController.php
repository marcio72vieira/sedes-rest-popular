<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurante;
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

class RestauranteController extends Controller
{
    
    public function index()
    {
        $restaurantes = Restaurante::all();
        return view('admin.restaurante.index', compact('restaurantes'));
    }

   
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //
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
