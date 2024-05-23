<?php
/**
 * Two - EventServiceProvider
 *
 * @author  Nicolas Devoy
 * @email   nicolas@nicodev.fr 
 * @version 1.0.0
 * @date    15 Fevrier 2023
 */
namespace App\Providers;

use Two\Events\Dispatcher;
use Two\Application\Providers\EventServiceProvider as ServiceProvider;


class EventServiceProvider extends ServiceProvider
{
    /**
     * Les mappages d'écouteurs d'événements pour l'application.
     *
     * @var array
     */
    protected $listen = array(
        'App\Events\SomeEvent' => array(
            'App\Listeners\EventListener',
        ),
    );


    /**
     * Enregistrez tout autre événement pour votre application.
     *
     * @param  \Two\Events\Dispatcher  $events
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        parent::boot($events);

        //
        $path = app_path('Events.php');

        $this->loadEventsFrom($path);
    }
}
