<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Restaurante;
use App\Models\Compra;
use Psr\Log\NullLogger;

class AdmOuProprietario
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        // Recuperas os parâmetros passados na URL com auxílio do objeto $request. O retorno é um array cujo índice é o nome do parâmetro.
        // A quantidade de parâmetro pode ser 1 ou dois conforme abaixo:
        // a) admin/restaurante/1/compra            (index)     1 parâmetro     {restaurante}
        // b) admin/restaurante/1/compra/create     (create)    1 parâmetro     {restaurante}
        // c) admin/restaurante/1/compra/95         (show)      2 parâmetros    {restaurante} e {compra}
        // d) admin/restaurante/1/compra/95/edit    (edit)      2 parâmetros    {restaurante} e {compra}
        $paramsUrl = $request->route()->parameters();   
        

        // Verifica a existência dos parâmetros e atribui seus valores às respectivas variáveis
        $idRestUrl = (!is_null($request->route('restaurante')) ? $paramsUrl['restaurante'] : NULL);
        $idCompUrl = (!is_null($request->route('compra')) ? $paramsUrl['compra'] : NULL);

       
        // Recupera os dados do restaurante e da compra caso os dois tenham sido passados na URL
        if(($idRestUrl != NULL) && ($idCompUrl != NULL)){
            $dadosRestaurante = Restaurante::where('id', '=', $idRestUrl)->first();
            $dadosCompra = Compra::where('id', '=', $idCompUrl)->where('restaurante_id', '=', $idRestUrl)->first();
        }else{
            $dadosRestaurante = Restaurante::where('id', '=', $idRestUrl)->first();
        }



        // Se o Admin ou Nutri tentou acessar um restaurante diretamente pela URL e o mesmo não exista, por exemplo,
        // admin/restaurante/40000/compra. A tentativa do usuário irá resultar em seu logout e aborto do sistema.
        // Isso irá desencorajá-lo a tentar novamente. Caso exista,  Se caso contrário, recupera o id do responsável
        //Caso exista, recupera o id do nutricionista responsável pelo mesmo
        if($dadosRestaurante == NULL){
            Auth::logout();
            abort(404);
        } else {
            $idResponsavelRest = $dadosRestaurante['user_id'];
        }

        
        if(Auth::user()->perfil != 'adm' ){
            if($idResponsavelRest != Auth::user()->id){
                return redirect()->back();
            }
        }

        return $next($request);
    }
}
