<?php

namespace Modules\TwoThemes\Providers;

use Two\Auth\Contracts\GateInterface as Gate;
use Two\Application\Providers\AuthServiceProvider as ServiceProvider;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * Les mappages de stratégie pour le module.
     *
     * @var array
     */
    protected $policies = array(
        'Modules\TwoThemes\Models\SomeModel' => 'Modules\TwoThemes\Policies\ModelPolicy',
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
