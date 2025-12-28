<?php

namespace App\Listeners;

use App\Events\TicketUpdated;
use App\Mail\TicketUpdatedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendTicketUpdatedEmail implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(TicketUpdated $event): void
    {
        $ticket = $event->ticket;

        if (! $ticket->assignee?->email) {
            return;
        }

        Mail::to($ticket->assignee->email)->send(
            new TicketUpdatedMail($ticket, $event->changes)
        );
    }
}
