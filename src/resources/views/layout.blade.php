<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name') }}</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<header>
  <div class="row">
    <strong>{{ config('app.name') }}</strong>
    <a href="{{ route('tickets.index') }}" class="muted" style="text-decoration:none">Tickets</a>
  </div>
  <div class="row">
    @auth
      <span class="muted">{{ auth()->user()->name }} ({{ auth()->user()->role }})</span>
      <form method="POST" action="{{ route('logout') }}" style="display:inline">
        @csrf
        <button class="btn secondary" type="submit">Logout</button>
      </form>
    @else
      <a class="btn secondary" href="{{ route('login') }}">Login</a>
      <a class="btn" href="{{ route('register') }}">Register</a>
    @endauth
  </div>
</header>
<div class="wrap">
  @if(session('ok'))
    <div class="card" style="border-left:4px solid #10b981">{{ session('ok') }}</div>
  @endif
  @yield('content')
</div>
</body>
</html>
