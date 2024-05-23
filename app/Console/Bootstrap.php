<?php
/**
 * Two - Bootstrap
 *
 * @author  Nicolas Devoy
 * @email   nicolas@nicodev.fr 
 * @version 1.0.0
 * @date    15 Fevrier 2023
 */

use Two\Support\Facades\Forge; 

/**
 * Console - enregistrer les commandes Forge.
 */

/**
 * Résolvez les commandes Forge à partir de l'application.
 */
Forge::resolveCommands(array(
    //'App\Console\Commands\testCommande',
));

/**
 * Add the Closure based commands.
 */
Forge::command('app:install', function ()
{
    $this->call('db:migrate', array('--seed' => true));

    //
    $this->call('package:migrate');
    $this->call('package:seed');

})->describe('Run all database migrations and seed it with records');
