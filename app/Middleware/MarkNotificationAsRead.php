<?php
/**
 * Two - MarkNotificationAsRead
 *
 * @author  Nicolas Devoy
 * @email   nicolas@nicodev.fr 
 * @version 1.0.0
 * @date    15 Fevrier 2023
 */
namespace App\Middleware;

use Closure;

use Two\Http\Request;
use Two\Support\Facades\Auth;
use Two\Support\Facades\Config;
use Two\Notifications\Models\Notification;


class MarkNotificationAsRead
{

    /**
     * 
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->has('read')) {
            $notification = Notification::where('uuid', $request->input('read'))->first();

            if (! is_null($notification)) {
                $this->handleNotification($notification);
            }
        }

        return $next($request);
    }

    /**
     * 
     */
    protected function handleNotification(Notification $notification)
    {
        $guard = $this->getGuardByAuthModel($notification->notifiable_type);

        if (! is_null($user = Auth::guard($guard)->user()) && ($user->id == $notification->notifiable_id)) {
            $notification->markAsRead();
        }
    }

    /**
     * 
     */
    protected function getGuardByAuthModel($model)
    {
        if (is_null($provider = $this->getAuthProviderByModel($model))) {
            return;
        }

        $guards = Config::get('auth.guards', array());

        foreach ($guards as $guard => $options) {
            if ($options['provider'] == $provider) {
                return $guard;
            }
        }
    }

    /**
     * 
     */
    protected function getAuthProviderByModel($model)
    {
        $providers = Config::get('auth.providers', array());

        foreach ($providers as $provider => $options) {
            if ($options['model'] == $model) {
                return $provider;
            }
        }
    }
}
