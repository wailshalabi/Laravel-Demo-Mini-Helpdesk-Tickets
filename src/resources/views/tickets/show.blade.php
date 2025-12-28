@extends('layout')

@section('content')
<div class="card">
  <div class="row" style="justify-content:space-between">
    <div>
      <h2 style="margin:0">{{ $ticket->title }}</h2>
      <div class="muted">
        Created by {{ $ticket->creator->name }} ·
        Assigned to {{ $ticket->assignee?->name ?? '-' }} ·
        <span class="pill">{{ $ticket->status }}</span> ·
        Priority: {{ $ticket->priority }}
      </div>
    </div>
    <div class="row">
      @can('update',$ticket)
        <a class="btn secondary" href="{{ route('tickets.edit',$ticket) }}">Edit</a>
      @endcan
      @can('delete',$ticket)
        <form method="POST" action="{{ route('tickets.destroy',$ticket) }}" onsubmit="return confirm('Delete ticket?')">
          @csrf
          @method('DELETE')
          <button class="btn danger" type="submit">Delete</button>
        </form>
      @endcan
    </div>
  </div>

  <div style="margin-top:12px">{{ $ticket->body }}</div>
</div>

<div class="card">
  <h3 style="margin-top:0">Comments</h3>

  @foreach($ticket->comments as $c)
    <div style="padding:10px 0;border-bottom:1px solid #e5e7eb">
      <div class="muted" style="font-size:13px">{{ $c->user->name }} · {{ $c->created_at->diffForHumans() }}</div>
      <div>{{ $c->body }}</div>
    </div>
  @endforeach

  <form method="POST" action="{{ route('tickets.comments.store',$ticket) }}" style="margin-top:12px">
    @csrf
    <label>Add comment</label>
    <textarea name="body" rows="4" required>{{ old('body') }}</textarea>
    @error('body')<div class="err">{{ $message }}</div>@enderror
    <div style="margin-top:10px">
      <button class="btn" type="submit">Post</button>
    </div>
  </form>
</div>
@endsection
