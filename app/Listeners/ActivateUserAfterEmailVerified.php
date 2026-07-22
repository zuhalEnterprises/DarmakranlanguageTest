<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Verified;

class ActivateUserAfterEmailVerified
{
    public function handle(Verified $event)
    {
        $user = $event->user;
        $user->active = 1;
        $user->save();
    }
}
