<?php

namespace App\Providers;

use App\Events\TicketCreated;
use App\Events\TicketUpdated;
use App\Listeners\SendTicketCreatedEmail;
use App\Listeners\SendTicketUpdatedEmail;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        TicketCreated::class => [
            SendTicketCreatedEmail::class,
        ],
        TicketUpdated::class => [
            SendTicketUpdatedEmail::class,
        ],
    ];
}
