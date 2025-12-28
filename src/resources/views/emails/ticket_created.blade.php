<!doctype html>
<html>
  <body>
    <h2>New ticket assigned</h2>
    <p><strong>{{ $ticket->title }}</strong></p>
    <p>Status: {{ $ticket->status }} | Priority: {{ $ticket->priority }}</p>
    <p>{{ $ticket->body }}</p>
  </body>
</html>
