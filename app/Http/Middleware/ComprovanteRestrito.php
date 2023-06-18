<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Restaurante;
use App\Models\Compra;

class ComprovanteRestrito
{
    
    public function handle(Request $request, Closure $next)
    {
        // Recupera os parâmetros passados na URL
        $paramsUrl = $request->route()->parameters();   
        
        // Verifica a existência dos parâmetros e atribui seus valores às respectivas variáveis
        $idCompUrl = !is_null($request->route('compra')) ? $paramsUrl['compra'] : NULL;

        // Se o id de uma compra foi passado na URL, recupera os dados desta compra
        if(($idCompUrl != NULL)){
            $dadosCompra = Compra::where('id', '=', $idCompUrl)->first();
        }else{
            $dadosCompra = NULL;
        }

        // Recupera o id do restaurante que realizaou a compra. Se não houve uma compra válida, desloga o usuário
        if($dadosCompra != NULL){
            $restRealizouCompra = $dadosCompra['restaurante_id'];

            
        }else{
            Auth::logout();
            $request->session()->flash('aviso', "Operação inapropriada!");
            return redirect()->route('acesso.login');
        }
        
        // Considerando que um usuário da SEDES é responsável por um único restaurante. Por isso usou-se: first()
        $dadosRestaurante = Restaurante::where('id', '=', $restRealizouCompra)->first();
        $idResponsavelRest = $dadosRestaurante['user_id'];

        // O usuário Administrador pode cadastrar comprovante para qualquer compra, independente do Restaurante
        // Comprovante se relaciona com Compra não com Restaurante
        if(Auth::user()->perfil != 'adm'){
            // Se o usuário autenticado for diferente do Usuário do Restaurante que registrou a compra deslóga-o
            if(Auth::user()->id != $idResponsavelRest){
                Auth::logout();
                $request->session()->flash('aviso', "Operação inapropriada!");
                return redirect()->route('acesso.login');     
            } 
        }
        

        return $next($request);
    }
}
