<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Empresa;
use App\Models\Nutricionista;
use App\Models\Restaurante;
use App\Models\Compra;

class DashboardController extends Controller
{
    public function index()
    {

        $totEmpresas =  Empresa::all()->count();
        $totNutricionistas =  Nutricionista::all()->count();
        $totRestaurantes = Restaurante::All()->count();
        $totCompras = Compra::All()->count();
        $totComprasNormal =  DB::table('compras')->whereMonth('data_ini', '11')->sum('valor');
        $totComprasAf =  DB::table('compras')->whereMonth('data_ini', '11')->sum('valoraf');
        

        return view('admin.dashboard.index', compact('totEmpresas', 'totNutricionistas', 'totRestaurantes', 'totCompras', 'totComprasNormal', 'totComprasAf'));
    }
}
