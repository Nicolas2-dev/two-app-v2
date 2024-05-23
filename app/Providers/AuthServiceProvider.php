<?php
/**
 * Two - AuthServiceProvider
 *
 * @author  Nicolas Devoy
 * @email   nicolas@nicodev.fr 
 * @version 1.0.0
 * @date    15 Fevrier 2023
 */
namespace App\Providers;

use Two\Auth\Contracts\GateInterface;
use Two\Application\Providers\AuthServiceProvider as ServiceProvider;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * Les mappages de stratégie pour l'application.
     *
     * @var array
     */
    protected $policies = array(
        'App\Models\SomeModel' => 'App\Policies\ModelPolicy',
    );


    /**
     * Enregistrez tous les services d'authentification / autorisation d'application.
     *
     * @param  GateInterface  $gate
     * @return void
     */
    public function boot(GateInterface $gate)
    {
        $this->registerPolicies($gate);

        //
    }
}
