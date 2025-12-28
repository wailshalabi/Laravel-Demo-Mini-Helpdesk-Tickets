<?php

namespace App\Mail;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Ticket $ticket,
        public array $changes = [],
    ) {}

    public function build(): self
    {
        return $this->subject("Ticket #{$this->ticket->id} updated")
            ->markdown('emails.tickets.updated');
    }
}
