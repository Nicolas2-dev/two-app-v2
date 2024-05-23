<?php

namespace Modules\TwoCore\Providers;


use Two\Application\Providers\AuthServiceProvider as ServiceProvider;
use Two\Auth\Contracts\GateInterface as Gate;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * Les mappages de stratégie pour le module.
     *
     * @var array
     */
    protected $policies = array(
        'Modules\TwoCore\Models\SomeModel' => 'Modules\TwoCore\Policies\ModelPolicy',
    );


    /**
     * Enregistrez n'importe quel service d'authentification/autorisation module.
     *
     * @param  \Two\Auth\Contracts\GateInterface  $gate
     * @return void
     */
    public function boot(Gate $gate)
    {
        $this->registerPolicies($gate);

        //
    }
}
