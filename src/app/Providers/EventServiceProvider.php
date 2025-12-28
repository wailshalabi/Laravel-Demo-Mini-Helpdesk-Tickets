<?php

namespace App\Providers;

use App\Events\TicketCreated;
use App\Listeners\SendTicketCreatedEmail;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        TicketCreated::class => [
            SendTicketCreatedEmail::class,
        ],
    ];
}
