<?php

namespace App\Listeners;

use App\Events\TicketCreated;
use App\Mail\TicketCreatedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendTicketCreatedEmail implements ShouldQueue
{
    public function handle(TicketCreated $event): void
    {
        $ticket = $event->ticket;

        if (!$ticket->assignee?->email) {
            return;
        }

        Mail::to($ticket->assignee->email)->send(new TicketCreatedMail($ticket));
    }
}
