@extends('layout')

@section('content')
<div class="card">
  <div class="row" style="justify-content:space-between">
    <div>
      <h2 style="margin:0">Tickets</h2>
      <div class="muted">Open: {{ $stats['open'] }} · In progress: {{ $stats['in_progress'] }} · Closed: {{ $stats['closed'] }}</div>
    </div>
    <a class="btn" href="{{ route('tickets.create') }}">+ New ticket</a>
  </div>
</div>

<div class="card">
  <table>
    <thead>
      <tr>
        <th>Title</th>
        <th>Status</th>
        <th>Priority</th>
        <th>Assignee</th>
        <th>Updated</th>
      </tr>
    </thead>
    <tbody>
      @foreach($tickets as $t)
        <tr>
          <td><a href="{{ route('tickets.show',$t) }}">{{ $t->title }}</a></td>
          <td><span class="pill">{{ $t->status }}</span></td>
          <td>{{ $t->priority }}</td>
          <td class="muted">{{ $t->assignee?->name ?? '-' }}</td>
          <td class="muted">{{ $t->updated_at->diffForHumans() }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <div style="margin-top:12px">{{ $tickets->links() }}</div>
</div>
@endsection
