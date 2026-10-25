@php
    $navServices = \App\Models\Service::published()->ordered()->get(['title', 'slug', 'icon']);
    $is = fn (...$names) => request()->routeIs(...$names) ? 'is-active' : '';
    $phone = setting('contact_phone');
    $email = setting('contact_email');
@endphp
<div class="topbar">
    <div class="container topbar__inner">
        <p class="topbar__tag">{{ setting('topbar_text', 'Investment promotion and advisory across Nigeria') }}</p>
        <div class="topbar__links">
            @if($email)<a href="mailto:{{ $email }}"><x-icon name="mail" :size="15" /> {{ $email }}</a>@endif
            @if($phone)<a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}"><x-icon name="phone" :size="15" /> {{ $phone }}</a>@endif
            <span class="topbar__social">
                @foreach(social_links() as $key => $s)
                    <a href="{{ $s['url'] }}" target="_blank" rel="noopener" aria-label="{{ $s['label'] }}"><x-icon :name="$key === 'x' ? 'x-brand' : $key" :size="15" /></a>
                @endforeach
            </span>
        </div>
    </div>
</div>

<header class="site-header" data-header>
    <div class="container site-header__inner">
        <a href="{{ route('home') }}" class="brand" aria-label="{{ setting('site_name', 'Onyx Investment Advisory Limited') }} — home">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Onyx Investment Advisory Limited" width="165" height="75">
        </a>

        <nav class="nav" id="site-nav" aria-label="Main" data-nav>
            <ul class="nav__list">
                <li><a href="{{ route('home') }}" class="nav__link {{ $is('home') }}">Home</a></li>
                <li><a href="{{ route('about') }}" class="nav__link {{ $is('about') }}">About</a></li>
                <li class="nav__item has-drop" data-drop>
                    <a href="{{ route('services.index') }}" class="nav__link {{ $is('services.*') }}">Our Services</a>
                    <button class="nav__drop-toggle" type="button" aria-expanded="false" aria-label="Show services" data-drop-toggle>
                        <x-icon name="chevron-down" :size="16" />
                    </button>
                    <div class="drop">
                        @foreach($navServices as $s)
                            <a href="{{ route('services.show', $s->slug) }}" class="drop__link">
                                <span class="drop__icon"><x-icon :name="$s->icon ?: 'sparkle'" :size="18" /></span>
                                <span>{{ $s->title }}</span>
                            </a>
                        @endforeach
                    </div>
                </li>
                <li><a href="{{ route('team.index') }}" class="nav__link {{ $is('team.*') }}">Our Team</a></li>
                <li><a href="{{ route('projects.index') }}" class="nav__link {{ $is('projects.*') }}">Our Projects</a></li>
                <li><a href="{{ route('faq') }}" class="nav__link {{ $is('faq') }}">FAQ</a></li>
                <li><a href="{{ route('contacts') }}" class="nav__link {{ $is('contacts') }}">Contacts</a></li>
            </ul>
            <a href="{{ route('contacts') }}#contact-form" class="btn btn--primary nav__cta">Talk to us <x-icon name="arrow-right" :size="16" /></a>
        </nav>

        <button class="nav-toggle" type="button" aria-controls="site-nav" aria-expanded="false" aria-label="Open menu" data-nav-toggle>
            <span></span><span></span><span></span>
        </button>
    </div>
</header>
