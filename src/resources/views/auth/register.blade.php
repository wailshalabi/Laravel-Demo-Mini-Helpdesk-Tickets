@extends('layout')

@section('content')
<div class="card">
  <h2>Register</h2>
  <form method="POST" action="{{ route('register.post') }}">
    @csrf
    <div class="grid">
      <div>
        <label>Name</label>
        <input name="name" value="{{ old('name') }}" required>
        @error('name')<div class="err">{{ $message }}</div>@enderror
      </div>
      <div>
        <label>Email</label>
        <input name="email" type="email" value="{{ old('email') }}" required>
        @error('email')<div class="err">{{ $message }}</div>@enderror
      </div>
      <div>
        <label>Password</label>
        <input name="password" type="password" required>
        @error('password')<div class="err">{{ $message }}</div>@enderror
      </div>
      <div>
        <label>Confirm Password</label>
        <input name="password_confirmation" type="password" required>
      </div>
    </div>
    <div style="margin-top:12px" class="row">
      <button class="btn" type="submit">Create account</button>
      <a class="btn secondary" href="{{ route('login') }}">Back to login</a>
    </div>
  </form>
</div>
@endsection
