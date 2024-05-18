<?php
/**
 * Two - BroadcastServiceProvider
 *
 * @author  Nicolas Devoy
 * @email   nicolas@nicodev.fr 
 * @version 1.0.0
 * @date    15 Fevrier 2023
 */
namespace App\Providers;

use Two\Http\Request;
use Two\Routing\Router;
use Two\Support\Facades\Broadcast;
use Two\TwoApplication\Providers\ServiceProvider;


class BroadcastServiceProvider extends ServiceProvider
{

    /**
     * Amorcez tous les services d'application.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $router->post('broadcasting/auth', array('middleware' => 'web', function (Request $request)
        {
            return Broadcast::authenticate($request);
        }));

        require app_path('Routes/Channels.php');
    }

    /**
     * Enregistrez le fournisseur de services de l'application.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
