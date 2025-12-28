<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name') }}</title>
  <style>
    body{font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;margin:0;background:#f6f7fb}
    header{background:#111827;color:#fff;padding:14px 18px;display:flex;gap:12px;align-items:center;justify-content:space-between}
    a{color:inherit}
    .wrap{max-width:980px;margin:18px auto;padding:0 14px}
    .card{background:#fff;border-radius:12px;padding:16px;box-shadow:0 1px 8px rgba(0,0,0,.06);margin-bottom:14px}
    .btn{display:inline-block;padding:10px 12px;border-radius:10px;background:#111827;color:#fff;text-decoration:none;border:0;cursor:pointer}
    .btn.secondary{background:#374151}
    .btn.danger{background:#b91c1c}
    input,select,textarea{width:100%;padding:10px;border-radius:10px;border:1px solid #d1d5db;box-sizing:border-box}
    label{font-size:14px;color:#374151}
    .grid{display:grid;grid-template-columns:1fr 1fr;gap:12px}
    .row{display:flex;gap:10px;align-items:center;flex-wrap:wrap}
    .muted{color:#6b7280}
    .err{color:#b91c1c;font-size:14px}
    table{width:100%;border-collapse:collapse}
    th,td{padding:10px;border-bottom:1px solid #e5e7eb;text-align:left}
    th{color:#6b7280;font-weight:600;font-size:13px}
    .pill{display:inline-block;padding:4px 10px;border-radius:999px;background:#eef2ff;font-size:12px}
  </style>
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
