<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') | Beniwal Parivahan</title>
    @vite('resources/css/portal.css')
</head>
<body>
@php $isAdmin = auth()->user()->isSuperAdmin(); @endphp

<div class="app {{ $isAdmin ? '' : 'no-sidebar' }}">

    {{-- Sidebar sirf Super Admin ke liye --}}
    @if ($isAdmin)
        <aside class="sidebar">
            <div class="brand">
                <div class="brand-mark">B</div>
                <div>
                    <strong>Beniwal Parivahan</strong>
                    <small>Transport Management</small>
                </div>
            </div>

            <nav class="menu">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('admin.vendors.index') }}" class="{{ request()->routeIs('admin.vendors.*') ? 'active' : '' }}">Vendors</a>
            </nav>

            <form method="POST" action="{{ route('logout') }}" class="logout">
                @csrf
                <button type="submit">Log out</button>
            </form>
        </aside>
    @endif

    <div class="main">
        <header class="topbar">
            @if ($isAdmin)
                <h1>@yield('title')</h1>
            @else
                <div class="topbar-left">
                    <div class="brand-mark brand-mark-sm">B</div>
                    <div>
                        <strong class="topbar-brand">Beniwal Parivahan</strong>
                        <small class="topbar-sub">@yield('title')</small>
                    </div>
                </div>
            @endif

            <div class="topbar-right">
                @unless ($isAdmin)
                    {{-- Abhi link khali hai, entries page banne ke baad route jodenge --}}
                    <a href="#" class="btn btn-sm">My Entries</a>
                @endunless

                <div class="user">
                    <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <div>
                        {{ auth()->user()->name }}
                        <small>{{ $isAdmin ? 'Super Admin' : 'Vendor' }}</small>
                    </div>
                </div>

                @unless ($isAdmin)
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-light">Log out</button>
                    </form>
                @endunless
            </div>
        </header>

        <main class="content">
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>