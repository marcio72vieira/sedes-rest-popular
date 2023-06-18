<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Restaurante;
use App\Models\Compra;

class CompraRestrita
{
    
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
        $idRestUrl = !is_null($request->route('restaurante')) ? $paramsUrl['restaurante'] : NULL;
        $idCompUrl = !is_null($request->route('compra')) ? $paramsUrl['compra'] : NULL;

       
        // Recupera os dados do restaurante e da compra ou só do restaurante de acordo com o parâmetros vindo na URL. Pelo menos
        // o parâmetro do restaurante virá.
        if(($idRestUrl != NULL) && ($idCompUrl != NULL)){
            $dadosRestaurante = Restaurante::where('id', '=', $idRestUrl)->first();
            //$dadosCompra = Compra::where('id', '=', $idCompUrl)->where('restaurante_id', '=', $idRestUrl)->first();
            $dadosCompra = Compra::where('id', '=', $idCompUrl)->first();
        }else{
            $dadosRestaurante = Restaurante::where('id', '=', $idRestUrl)->first();
            $dadosCompra = NULL;
        }


        // Se o usuário tentar acessar um restaurante diretamente pela URL e este não exista, o usuário será deslogado e o 
        // programa será abortado, desencoranjando-o a tentar outra vez. Se o restaurante existir e foi o Adm quem tentou, tudo
        // certo, ele poderá seguir, se o restaurante existir e for o nutricionista que tentou, ele será redirecionado para a
        // sua propria página (back), pois será feita uma verificação se o restaurante que o nutricionista tentou acessar é o mesmo 
        // restaurante que ele é o responsável, através da recuperação do user_id na tabela restaurante. Essa recuperação do user_id
        // será confrontada com o id do usuário atualmente autenticado.
        if($dadosRestaurante == NULL){
            //Auth::logout(); //abort(404);
            Auth::logout();
            $request->session()->flash('aviso', "Operação inapropriada!");
            return redirect()->route('acesso.login');
        } else {
            $idResponsavelRest = $dadosRestaurante['user_id'];
        }

        if(Auth::user()->perfil != 'adm' ){
            if($idResponsavelRest != Auth::user()->id){
                //return redirect()->back();
                Auth::logout();
                $request->session()->flash('aviso', "Operação inapropriada!");
                return redirect()->route('acesso.login');
            }
        }


        //Se foi informado via URL os id's do Restaurante e da Compra de forma artificial, verifica-se se o restaurante
        //que realizou a compra é igual ao restaurante que foi informado na URL. Isso serve tanto para Administrador como para
        //usuário Nutricionista, ou seja, impede que o administrador atribua a um restaurante uma compra feita por outro
        if($dadosCompra != NULL){
            $restRealizouCompra = $dadosCompra['restaurante_id'];

            if($idRestUrl != $restRealizouCompra){
                Auth::logout();
                $request->session()->flash('aviso', "Operação inapropriada!");
                return redirect()->route('acesso.login');
            }
        }


        return $next($request);
    }
}
