<?php

namespace Modules\Exemple\Providers;

use Two\Auth\Contracts\Access\GateInterface as Gate;
use Two\TwoApplication\Providers\AuthServiceProvider as ServiceProvider;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * Les mappages de stratégie pour le module.
     *
     * @var array
     */
    protected $policies = array(
        'Modules\Exemple\Models\SomeModel' => 'Modules\Exemple\Policies\ModelPolicy',
    );


    /**
     * Enregistrez n'importe quel service d'authentification/autorisation module.
     *
     * @param  \Two\Auth\Contracts\Access\GateInterface  $gate
     * @return void
     */
    public function boot(Gate $gate)
    {
        $this->registerPolicies($gate);

        //
    }
}
