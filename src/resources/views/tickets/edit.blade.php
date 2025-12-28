@extends('layout')

@section('content')
<div class="card">
  <h2>Edit ticket</h2>

  <form data-disable-on-submit method="POST" action="{{ route('tickets.update',$ticket) }}">
    @csrf
    @method('PUT')

    <div class="grid">
      <div>
        <label>Title</label>
        <input name="title" value="{{ old('title',$ticket->title) }}" required>
        @error('title')<div class="err">{{ $message }}</div>@enderror
      </div>
      <div>
        <label>Status</label>
        <select name="status" required>
          @foreach(['open','in_progress','closed'] as $s)
            <option value="{{ $s }}" @selected(old('status',$ticket->status)===$s)>{{ str_replace('_',' ',ucfirst($s)) }}</option>
          @endforeach
        </select>
        @error('status')<div class="err">{{ $message }}</div>@enderror
      </div>
      <div>
        <label>Priority</label>
        <select name="priority" required>
          @foreach(['low','medium','high'] as $p)
            <option value="{{ $p }}" @selected(old('priority',$ticket->priority)===$p)>{{ ucfirst($p) }}</option>
          @endforeach
        </select>
        @error('priority')<div class="err">{{ $message }}</div>@enderror
      </div>

      <div>
        <label>Assignee @if(!auth()->user()->isAdmin())<span class="muted">(admin only)</span>@endif</label>
        <select name="assigned_to" @disabled(!auth()->user()->isAdmin())>
          <option value="">-- none --</option>
          @foreach($agents as $a)
            <option value="{{ $a->id }}" @selected(old('assigned_to',$ticket->assigned_to)==$a->id)>{{ $a->name }} ({{ $a->role }})</option>
          @endforeach
        </select>
      </div>
    </div>

    <div style="margin-top:12px">
      <label>Description</label>
      <textarea name="body" rows="6" required>{{ old('body',$ticket->body) }}</textarea>
      @error('body')<div class="err">{{ $message }}</div>@enderror
    </div>

    <div style="margin-top:12px" class="row">
      <button class="btn" type="submit">Save</button>
      <a class="btn secondary" href="{{ route('tickets.show',$ticket) }}">Cancel</a>
    </div>
  </form>
</div>
@endsection
