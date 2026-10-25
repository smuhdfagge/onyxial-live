@php
    $unreadCount = \App\Models\Message::unread()->count();
    $nav = [
        ['Overview', [
            ['admin.dashboard', 'Dashboard', 'dashboard', 'admin.dashboard'],
            ['admin.messages.index', 'Messages', 'inbox', 'admin.messages.*', $unreadCount],
        ]],
        ['Content', [
            ['admin.pages.index', 'Pages & SEO', 'file', 'admin.pages.*'],
            ['admin.services.index', 'Services', 'briefcase', 'admin.services.*'],
            ['admin.projects.index', 'Projects', 'folder', 'admin.projects.*'],
            ['admin.project-categories.index', 'Project sectors', 'tag', 'admin.project-categories.*'],
            ['admin.team.index', 'Team', 'users', 'admin.team.*'],
            ['admin.faqs.index', 'FAQs', 'help', 'admin.faqs.*'],
            ['admin.highlights.index', 'Highlights', 'star', 'admin.highlights.*'],
            ['admin.clients.index', 'Clients & partners', 'building', 'admin.clients.*'],
            ['admin.gallery.index', 'Gallery', 'image', 'admin.gallery.*'],
            ['admin.offices.index', 'Offices', 'map-pin', 'admin.offices.*'],
        ]],
        ['Setup', [
            ['admin.settings.edit', 'Site settings', 'settings', 'admin.settings.*'],
            ['admin.redirects.index', 'Redirects', 'link', 'admin.redirects.*'],
            ['admin.users.index', 'Admin users', 'lock', 'admin.users.*'],
        ]],
    ];
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Dashboard') · Onyx Admin</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}?v={{ filemtime(public_path('assets/css/admin.css')) }}">
    @stack('head')
</head>
<body class="admin">
<div class="shell" data-shell>
    <aside class="side" data-side>
        <div class="side__brand">
            <a href="{{ route('admin.dashboard') }}"><img src="{{ asset('assets/img/logo-white.png') }}" alt="Onyx Investment Advisory Limited" width="130"></a>
            <span class="side__tag">Admin</span>
        </div>
        <nav class="side__nav" aria-label="Admin">
            @foreach($nav as [$group, $links])
                <p class="side__group">{{ $group }}</p>
                @foreach($links as $link)
                    <a href="{{ route($link[0]) }}" class="side__link {{ request()->routeIs($link[3]) ? 'is-active' : '' }}">
                        <x-icon :name="$link[2]" :size="18" />
                        <span>{{ $link[1] }}</span>
                        @if(!empty($link[4]))<span class="side__count">{{ $link[4] }}</span>@endif
                    </a>
                @endforeach
            @endforeach
        </nav>
        <div class="side__foot">
            <a href="{{ route('home') }}" target="_blank" class="side__link"><x-icon name="external" :size="18" /><span>View website</span></a>
        </div>
    </aside>

    <div class="main">
        <header class="bar">
            <button class="bar__menu" type="button" aria-label="Toggle menu" data-side-toggle><x-icon name="menu" :size="22" /></button>
            <div class="bar__title">@yield('title', 'Dashboard')</div>
            <div class="bar__right">
                <form action="{{ route('admin.cache.clear') }}" method="post" class="bar__inline">
                    @csrf
                    <button type="submit" class="bar__btn" title="Clear the site cache after big changes"><x-icon name="refresh" :size="17" /><span>Clear cache</span></button>
                </form>
                <div class="user-menu" data-dropdown>
                    <button type="button" class="user-menu__btn" data-dropdown-toggle aria-expanded="false">
                        <span class="avatar">{{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
                        <span class="user-menu__name">{{ auth()->user()->name }}</span>
                        <x-icon name="chevron-down" :size="16" />
                    </button>
                    <div class="user-menu__drop">
                        <a href="{{ route('admin.profile.edit') }}"><x-icon name="user" :size="16" /> My profile</a>
                        <form action="{{ route('admin.logout') }}" method="post">
                            @csrf
                            <button type="submit"><x-icon name="logout" :size="16" /> Sign out</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main class="content">
            @if(session('success'))
                <div class="flash flash--ok" role="status" data-flash><x-icon name="check-circle" :size="20" /> {{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="flash flash--err" role="alert">
                    <strong>Please fix the following:</strong>
                    <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>
<div class="scrim" data-scrim></div>
<script src="{{ asset('assets/js/admin.js') }}?v={{ filemtime(public_path('assets/js/admin.js')) }}" defer></script>
@stack('scripts')
</body>
</html>
