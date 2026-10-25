<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Sign in · Onyx Admin</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}?v={{ filemtime(public_path('assets/css/admin.css')) }}">
</head>
<body class="login">
    <div class="login__art" aria-hidden="true">
        <div class="login__lines"></div>
        <img src="{{ asset('assets/img/logo-white.png') }}" alt="" width="260">
        <p>Website administration</p>
    </div>
    <main class="login__panel">
        <form method="post" action="{{ route('admin.login.attempt') }}" class="login__form">
            @csrf
            <img src="{{ asset('assets/img/logo.png') }}" alt="Onyx Investment Advisory Limited" width="150" class="login__logo">
            <h1>Sign in</h1>
            <p class="muted">Manage the content of onyxial.com.</p>

            @if(session('success'))<div class="flash flash--ok">{{ session('success') }}</div>@endif
            @error('email')<div class="flash flash--err">{{ $message }}</div>@enderror

            <label class="f">
                <span>Email address</span>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            </label>
            <label class="f">
                <span>Password</span>
                <input type="password" name="password" required autocomplete="current-password">
            </label>
            <label class="check"><input type="checkbox" name="remember" value="1"> <span>Keep me signed in</span></label>
            <button type="submit" class="btn btn--primary btn--block">Sign in <x-icon name="arrow-right" :size="16" /></button>
            <a href="{{ route('home') }}" class="login__back"><x-icon name="arrow-left" :size="15" /> Back to the website</a>
        </form>
    </main>
</body>
</html>
