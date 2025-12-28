@component('mail::message')
# New ticket assigned

Ticket **#{{ $ticket->id }}** has been created

@isset($changes['status'])
- **Status:** {{ $ticket->status }}
@endisset

@isset($changes['priority'])
- **Priority:** {{ $ticket->priority }}
@endisset

@component('mail::button', ['url' => url("/tickets/{$ticket->id}")])
View Ticket
@endcomponent

Ticket body.

{{ $ticket->body }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
