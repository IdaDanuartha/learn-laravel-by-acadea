<?php

namespace App\Subscribers\Model;

use App\Events\Model\User\UserCreated;
use App\Listeners\SendWelcomeEmail;
use Illuminate\Events\Dispatcher;

class UserSubscriber
{
    public function subscribe(Dispatcher $events)
    {
        $events->listen(UserCreated::class, SendWelcomeEmail::class);
    }
}