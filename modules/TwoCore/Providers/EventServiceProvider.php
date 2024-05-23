<?php

namespace Modules\TwoCore\Providers;

use Two\Events\Dispatcher;
use Two\Application\Providers\EventServiceProvider as ServiceProvider;


class EventServiceProvider extends ServiceProvider
{
    /**
     * Les mappages d'écouteurs d'événements pour le module.
     *
     * @var array
     */
    protected $listen = array(
        'Modules\TwoCore\Events\SomeEvent' => array(
            'Modules\TwoCore\Listeners\EventListener',
        ),
    );


    /**
     * Enregistrez tout autre événement pour votre module.
     *
     * @param  \Two\Events\Dispatcher  $events
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        parent::boot($events);

        //
        $path = realpath(__DIR__ .'/../');

        // Chargez les événements.
        $path = $path .DS .'Events.php';

        $this->loadEventsFrom($path);
    }
}
