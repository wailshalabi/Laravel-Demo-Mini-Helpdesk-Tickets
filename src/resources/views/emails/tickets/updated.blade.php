@component('mail::message')
# Ticket Updated

Ticket **#{{ $ticket->id }}** has been updated.

@isset($changes['status'])
- **Status:** {{ $changes['status']['old'] }} → {{ $changes['status']['new'] }}
@endisset

@component('mail::button', ['url' => url("/tickets/{$ticket->id}")])
View Ticket
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
