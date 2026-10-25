@extends('layouts.site')

@section('body_class', 'page-home')

@section('content')
{{-- ============ HERO ============ --}}
<section class="hero">
    <div class="hero__pattern" aria-hidden="true">
        <svg class="hero__lines" viewBox="0 0 800 800" preserveAspectRatio="xMidYMid slice">
            <defs>
                <linearGradient id="hl" x1="0" y1="0" x2="1" y2="1">
                    <stop offset="0" stop-color="#fff" stop-opacity=".0"/>
                    <stop offset=".5" stop-color="#fff" stop-opacity=".35"/>
                    <stop offset="1" stop-color="#fff" stop-opacity=".0"/>
                </linearGradient>
            </defs>
            @for($i = 0; $i < 14; $i++)
                <path d="M{{ -200 + $i * 70 }} 820 L{{ 300 + $i * 70 }} -20" stroke="url(#hl)" stroke-width="1" fill="none"/>
            @endfor
        </svg>
        <span class="hero__orb hero__orb--1"></span>
        <span class="hero__orb hero__orb--2"></span>
    </div>

    <div class="container hero__inner">
        <div class="hero__copy">
            <p class="eyebrow eyebrow--light hero__eyebrow" data-reveal>
                <span class="pulse-dot" aria-hidden="true"></span>
                {{ setting('hero_eyebrow', 'Your key to investing in Nigeria') }}
            </p>
            <h1 class="hero__title" data-reveal data-delay="1">
                {!! nl2br(e(setting('hero_title', "Invest with purpose.\nChange the world."))) !!}
            </h1>
            <p class="hero__lead" data-reveal data-delay="2">
                {{ setting('hero_text', 'Onyx Investment Advisory Limited promotes and facilitates investment, develops projects and supports private sector growth across Nigeria, investing in people one community at a time.') }}
            </p>
            <div class="hero__actions" data-reveal data-delay="3">
                <a href="{{ route('services.index') }}" class="btn btn--light btn--lg">Explore our services <x-icon name="arrow-right" :size="18" /></a>
                <a href="{{ route('contacts') }}#contact-form" class="btn btn--ghost-light btn--lg">Contact us</a>
            </div>
        </div>

    </div>
</section>

{{-- ============ STATS ============ --}}
@if($stats->count())
<section class="stats" aria-label="Key figures">
    <div class="container stats__grid">
        @foreach($stats as $stat)
            @include('site._stat', ['stat' => $stat])
        @endforeach
    </div>
</section>
@endif

{{-- ============ ABOUT INTRO ============ --}}
<section class="section about-intro">
    <div class="container split">
        <div class="split__media" data-reveal>
            <div class="framed">
                <img src="{{ media_url(setting('home_about_image'), 'assets/img/placeholder-about.jpg') }}" alt="The Onyx Investment Advisory team" width="620" height="520" loading="lazy">
                <div class="framed__badge">
                    <span class="framed__num">{{ setting('founded_year', '2022') }}</span>
                    <span class="framed__txt">Founded in Nigeria</span>
                </div>
            </div>
        </div>
        <div class="split__copy">
            <p class="eyebrow" data-reveal>{{ setting('home_about_eyebrow', 'Who we are') }}</p>
            <h2 class="h2" data-reveal>{{ setting('home_about_title', 'Investing in people, one community at a time') }}</h2>
            <div class="prose" data-reveal>
                {!! clean_html(setting('home_about_text')) !!}
            </div>
            <ul class="ticks" data-reveal>
                @foreach(array_filter(array_map('trim', explode("\n", (string) setting('home_about_points')))) as $point)
                    <li><x-icon name="check" :size="18" /> {{ $point }}</li>
                @endforeach
            </ul>
            <a href="{{ route('about') }}" class="btn btn--primary" data-reveal>More about Onyx <x-icon name="arrow-right" :size="16" /></a>
        </div>
    </div>
</section>

{{-- ============ SERVICES ============ --}}
<section class="section section--tint services-home">
    <div class="container">
        <div class="section-head">
            <div>
                <p class="eyebrow" data-reveal>What we do</p>
                <h2 class="h2" data-reveal>Services built for investment in Nigeria</h2>
            </div>
            <p class="section-head__text" data-reveal>From first research to a signed deal, we help investors, businesses and governments move with confidence.</p>
        </div>
        <div class="service-grid">
            @foreach($services as $service)
                <a href="{{ $service->url() }}" class="service-card" data-reveal data-delay="{{ $loop->index }}">
                    <span class="service-card__num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                    <span class="service-card__icon"><x-icon :name="$service->icon ?: 'sparkle'" :size="26" /></span>
                    <h3 class="service-card__title">{{ $service->title }}</h3>
                    <p class="service-card__text">{{ $service->excerpt }}</p>
                    <span class="link-arrow">Learn more <x-icon name="arrow-right" :size="16" /></span>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ QUOTE ============ --}}
@if($quote = setting('ceo_quote'))
<section class="quote-band">
    <div class="container quote-band__inner" data-reveal>
        <x-icon name="quote" :size="44" class="quote-band__mark" />
        <blockquote>
            <p>{{ $quote }}</p>
            <footer>
                <strong>{{ setting('ceo_name', 'Aisha Yakubu Bako') }}</strong>
                <span>{{ setting('ceo_title', 'MD/CEO') }}</span>
            </footer>
        </blockquote>
    </div>
</section>
@endif

{{-- ============ PROJECTS ============ --}}
@if($projects->count())
<section class="section">
    <div class="container">
        <div class="section-head">
            <div>
                <p class="eyebrow" data-reveal>Our projects</p>
                <h2 class="h2" data-reveal>Recent work with state and regional partners</h2>
            </div>
            <a href="{{ route('projects.index') }}" class="btn btn--outline" data-reveal>All projects <x-icon name="arrow-right" :size="16" /></a>
        </div>
        <div class="project-grid">
            @foreach($projects as $project)
                @include('site.projects._card', ['project' => $project, 'delay' => $loop->index])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ============ WHY US ============ --}}
@if($whyUs->count())
<section class="section section--navy why">
    <div class="why__pattern" aria-hidden="true"></div>
    <div class="container why__grid">
        <div class="why__intro">
            <p class="eyebrow eyebrow--light" data-reveal>Why choose us</p>
            <h2 class="h2 h2--light" data-reveal>{{ setting('why_title', 'Global experience, applied to local markets') }}</h2>
            <p class="why__text" data-reveal>{{ setting('why_text') }}</p>
            <a href="{{ route('team.index') }}" class="btn btn--light" data-reveal>Meet the team <x-icon name="arrow-right" :size="16" /></a>
        </div>
        <div class="why__list">
            @foreach($whyUs as $item)
                <article class="why-item" data-reveal data-delay="{{ $loop->index }}">
                    <span class="why-item__icon"><x-icon :name="$item->icon ?: 'check'" :size="22" /></span>
                    <div>
                        <h3>{{ $item->title }}</h3>
                        <p>{{ $item->body }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ============ PROCESS ============ --}}
@if($process->count())
<section class="section process">
    <div class="container">
        <div class="section-head section-head--center">
            <p class="eyebrow" data-reveal>How we work</p>
            <h2 class="h2" data-reveal>Our four-step process</h2>
            <p class="section-head__text" data-reveal>A clear path from the first conversation to results you can measure.</p>
        </div>
        <ol class="steps" data-steps>
            @foreach($process as $step)
                <li class="step" data-reveal data-delay="{{ $loop->index }}">
                    <span class="step__num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                    <span class="step__icon"><x-icon :name="$step->icon ?: 'check'" :size="24" /></span>
                    <h3 class="step__title">{{ $step->title }}</h3>
                    <p class="step__text">{{ $step->body }}</p>
                </li>
            @endforeach
        </ol>
    </div>
</section>
@endif

{{-- ============ TEAM ============ --}}
@if($team->count())
<section class="section section--tint">
    <div class="container">
        <div class="section-head">
            <div>
                <p class="eyebrow" data-reveal>Our people</p>
                <h2 class="h2" data-reveal>The team behind the work</h2>
            </div>
            <a href="{{ route('team.index') }}" class="btn btn--outline" data-reveal>Full team <x-icon name="arrow-right" :size="16" /></a>
        </div>
        <div class="team-grid">
            @foreach($team as $member)
                @include('site.team._card', ['member' => $member, 'delay' => $loop->index])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ============ CLIENTS ============ --}}
@include('site._clients')

@include('partials.cta')
@endsection
