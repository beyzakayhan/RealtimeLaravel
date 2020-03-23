<?php

namespace App\Listeners;

use App\Events\UserSessionChanged;
use Illuminate\Auth\Events\Login;

class BroadcastUserLoginNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param object $event
     */
    public function handle(Login $event)
    {
        broadcast(new UserSessionChanged("{$event->user->name} is online", 'success'));
    }
}
