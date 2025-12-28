@extends('layout')

@section('content')
<div class="card">
  <h2>Login</h2>
  <p class="muted">Use seeded accounts (password: <code>password</code>)</p>

  <form method="POST" action="{{ route('login.post') }}">
    @csrf
    <div class="grid">
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
    </div>
    <div style="margin-top:12px" class="row">
      <button class="btn" type="submit">Login</button>
      <a class="btn secondary" href="{{ route('register') }}">Create account</a>
    </div>
  </form>
</div>
@endsection
