<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Restaurante;
use App\Models\Municipio;
use App\Models\Bairro;
use App\Models\Empresa;
use App\Models\User;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\RestauranteCreateRequest;
use App\Http\Requests\RestauranteUpdateRequest;
use App\Models\Nutricionista;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class RegistroconsultacompraController extends Controller
{
    public function index()
    {
        //return view('admin.registroconsultacompra.index');
        //return view('admin.restaurante.index');

        // Se ADMINISTRADOR, visualiza todos os RESTAURANTES, caso contrário só o restaurante do NUTRICIONISTA responsável
        
        /* if(Auth::user()->perfil == 'adm'){
            $restaurantes = Restaurante::with(['municipio', 'bairro', 'empresa', 'nutricionista', 'user', 'compras'])
                                        ->orderBy('identificacao', 'ASC')->get();
            
            return view('admin.restaurante.index', compact('restaurantes'));

        } else {
            $restaurante = Restaurante::with(['municipio', 'bairro', 'empresa', 'nutricionista', 'user', 'compras'])
                                        ->where('user_id', '=', Auth::user()->id)->get();
            
            //dd($restaurante);

            return view('admin.compra.index', compact('restaurante'));
        } */

        //return view('admin.restaurante.index', compact('restaurantes'));
    }
}
