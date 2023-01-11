<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();


        /*
        // Utilizadas com allows (ou seja, não define mensagem de lancamento de exceção)
        Gate::define('adm', function($user){
            return $user->perfil == 'adm';
        });

        Gate::define('ope', function($user){
            return $user->perfil == 'ope';
        });
        */


        // Utilizadas com authorize. (ou seja, define mensagem de lançamento de exceção)
        // É necesspario importar a classe: use Illuminate\Auth\Access\Response;
        Gate::define('adm', function($user){
            return $user->perfil == 'adm'
                    ? Response::allow()
                    : Response::deny('Ação não autorizada!');
        });

        Gate::define('nut', function($user){
            return $user->perfil == 'nut';

        });
    }
}
