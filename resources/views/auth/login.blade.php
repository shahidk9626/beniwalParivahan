<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} | Beniwal Parivahan</title>
    @vite('resources/css/login.css')
</head>
<body>
    <div class="wrap">
        <div class="brand">
            <div class="mark">B</div>
            <h1>Beniwal Parivahan</h1>
            <p>Transport Vendor Management System</p>
        </div>

        <div class="card">
            <span class="tag">{{ $isAdmin ? 'Admin Portal' : 'Vendor Portal' }}</span>
            <h2>{{ $title }}</h2>
            <p class="sub">{{ $isAdmin ? 'Sign in with your Super Admin account.' : 'Sign in with the credentials provided by the admin.' }}</p>

            @if ($errors->any())
                <div class="error">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ $action }}">
                @csrf
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required autofocus autocomplete="username">

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required autocomplete="current-password">

                <div class="row">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember me</label>
                </div>

                <button type="submit">Sign in</button>
            </form>
        </div>

        <div class="footer">&copy; {{ date('Y') }} Beniwal Parivahan. All rights reserved.</div>
    </div>
</body>
</html>