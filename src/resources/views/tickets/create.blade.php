@extends('layout')

@section('content')
<div class="card">
  <h2>Create ticket</h2>

  <form data-disable-on-submit method="POST" action="{{ route('tickets.store') }}">
    @csrf

    <div class="grid">
      <div>
        <label>Title</label>
        <input name="title" value="{{ old('title') }}" required>
        @error('title')<div class="err">{{ $message }}</div>@enderror
      </div>
      <div>
        <label>Priority</label>
        <select name="priority" required>
          @foreach(['low','medium','high'] as $p)
            <option value="{{ $p }}" @selected(old('priority')===$p)>{{ ucfirst($p) }}</option>
          @endforeach
        </select>
        @error('priority')<div class="err">{{ $message }}</div>@enderror
      </div>
    </div>

    <div style="margin-top:12px">
      <label>Description</label>
      <textarea name="body" rows="6" required>{{ old('body') }}</textarea>
      @error('body')<div class="err">{{ $message }}</div>@enderror
    </div>

    <div style="margin-top:12px">
      <label>Assign to (optional)</label>
      <select name="assigned_to">
        <option value="">-- none --</option>
        @foreach($agents as $a)
          <option value="{{ $a->id }}" @selected(old('assigned_to')==$a->id)>{{ $a->name }} ({{ $a->role }})</option>
        @endforeach
      </select>
      @error('assigned_to')<div class="err">{{ $message }}</div>@enderror
    </div>

    <div style="margin-top:12px" class="row">
      <button class="btn" type="submit">Create</button>
      <a class="btn secondary" href="{{ route('tickets.index') }}">Cancel</a>
    </div>
  </form>
</div>
@endsection
