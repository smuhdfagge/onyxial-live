@extends('layouts.site')

@section('content')
@include('partials.page-hero', [
    'title' => $page?->heading ?: 'About Onyx',
    'intro' => $page?->intro,
    'eyebrow' => 'About us',
    'image' => $page?->banner,
    'crumbs' => [[$page?->title ?? 'About Us', route('about')]],
])

<section class="section">
    <div class="container split split--top">
        <div class="split__copy">
            <p class="eyebrow" data-reveal>Our story</p>
            <h2 class="h2" data-reveal>{{ setting('about_title', 'Investing with purpose, for lasting change') }}</h2>
            <div class="prose" data-reveal>{!! clean_html($page?->body) !!}</div>
        </div>
        <div class="split__media" data-reveal>
            <div class="framed framed--tall">
                <img src="{{ media_url(setting('about_image'), 'assets/img/placeholder-about.jpg') }}" alt="Onyx Investment Advisory at work" width="560" height="640" loading="lazy">
            </div>
        </div>
    </div>
</section>

@if($stats->count())
<section class="stats stats--flat" aria-label="Key figures">
    <div class="container stats__grid">
        @foreach($stats as $stat)
            @include('site._stat', ['stat' => $stat])
        @endforeach
    </div>
</section>
@endif

<section class="section section--tint">
    <div class="container">
        <div class="section-head section-head--center">
            <p class="eyebrow" data-reveal>Who we are</p>
            <h2 class="h2" data-reveal>Vision, mission and values</h2>
        </div>
        <div class="vm-grid">
            <article class="vm-card" data-reveal>
                <span class="vm-card__icon"><x-icon name="target" :size="26" /></span>
                <h3>Our vision</h3>
                <p>{{ setting('vision') }}</p>
            </article>
            <article class="vm-card vm-card--navy" data-reveal data-delay="1">
                <span class="vm-card__icon"><x-icon name="flag" :size="26" /></span>
                <h3>Our mission</h3>
                <p>{{ setting('mission') }}</p>
            </article>
        </div>

        @if($values->count())
            <h3 class="values-title" data-reveal>Our core values</h3>
            <div class="values-grid">
                @foreach($values as $value)
                    <article class="value-card" data-reveal data-delay="{{ $loop->index }}">
                        <span class="value-card__num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        <h4>{{ $value->title }}</h4>
                        @if($value->subtitle)<p class="value-card__lead">{{ $value->subtitle }}</p>@endif
                        <p>{{ $value->body }}</p>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</section>

@if($quote = setting('ceo_quote'))
<section class="quote-band">
    <div class="container quote-band__inner" data-reveal>
        <x-icon name="quote" :size="44" class="quote-band__mark" />
        <blockquote>
            <p>{{ $quote }}</p>
            <footer><strong>{{ setting('ceo_name', 'Aisha Yakubu Bako') }}</strong><span>{{ setting('ceo_title', 'MD/CEO') }}</span></footer>
        </blockquote>
    </div>
</section>
@endif

@if($gallery->count())
<section class="section">
    <div class="container">
        <div class="section-head">
            <div>
                <p class="eyebrow" data-reveal>In the field</p>
                <h2 class="h2" data-reveal>Moments from our work</h2>
            </div>
        </div>
        <div class="gallery" data-gallery>
            @foreach($gallery as $img)
                <a href="{{ media_url($img->path) }}" class="gallery__item" data-lightbox="about" data-caption="{{ $img->caption }}" data-reveal data-delay="{{ $loop->index % 4 }}">
                    <img src="{{ media_url($img->path) }}" alt="{{ $img->caption ?: 'Onyx Investment Advisory event photo' }}" loading="lazy">
                    <span class="gallery__zoom"><x-icon name="zoom" :size="22" /></span>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($team->count())
<section class="section section--tint">
    <div class="container">
        <div class="section-head">
            <div>
                <p class="eyebrow" data-reveal>Our team</p>
                <h2 class="h2" data-reveal>Experienced people, deep local knowledge</h2>
            </div>
            <a href="{{ route('team.index') }}" class="btn btn--outline" data-reveal>View all <x-icon name="arrow-right" :size="16" /></a>
        </div>
        <div class="team-grid">
            @foreach($team as $member)
                @include('site.team._card', ['member' => $member, 'delay' => $loop->index])
            @endforeach
        </div>
    </div>
</section>
@endif

@include('site._clients')
@include('partials.cta')
@endsection
