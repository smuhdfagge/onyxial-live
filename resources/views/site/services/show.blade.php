@extends('layouts.site')

@section('content')
@include('partials.page-hero', [
    'title' => $service->title,
    'intro' => $service->excerpt,
    'eyebrow' => 'Our services',
    'crumbs' => [['Our Services', route('services.index')], [$service->title, $service->url()]],
])

<section class="section">
    <div class="container detail">
        <article class="detail__main">
            @if(has_media($service->image))
                <figure class="detail__figure" data-reveal>
                    <img src="{{ media_url($service->image) }}" alt="{{ $service->title }}" width="900" height="560">
                </figure>
            @endif
            <div class="prose prose--lg" data-reveal>{!! clean_html($service->body) !!}</div>

            @if($service->points)
                <div class="points" data-reveal>
                    <h2 class="h4">What this covers</h2>
                    <ul class="points__list">
                        @foreach($service->points as $point)
                            <li><span class="points__icon"><x-icon name="check" :size="16" /></span>{{ $point }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-panel" data-reveal>
                <h2 class="h4">Ask us about {{ $service->title }}</h2>
                <p class="muted">Send a short note and we will get back to you.</p>
                @include('partials.contact-form', ['source' => $service->title, 'subject' => $service->title, 'compact' => true])
            </div>
        </article>

        <aside class="detail__aside">
            <div class="aside-card" data-reveal>
                <h2 class="aside-card__title">Other services</h2>
                <ul class="aside-links">
                    @foreach($others as $o)
                        <li><a href="{{ $o->url() }}"><span><x-icon :name="$o->icon ?: 'sparkle'" :size="18" /> {{ $o->title }}</span><x-icon name="arrow-right" :size="16" /></a></li>
                    @endforeach
                </ul>
            </div>
            <div class="aside-card aside-card--navy" data-reveal>
                <h2 class="aside-card__title">Talk to an adviser</h2>
                <p>Not sure which service fits? Call or email us and we will point you in the right direction.</p>
                @if($p = setting('contact_phone'))<a class="aside-contact" href="tel:{{ preg_replace('/[^0-9+]/', '', $p) }}"><x-icon name="phone" :size="18" /> {{ $p }}</a>@endif
                @if($e = setting('contact_email'))<a class="aside-contact" href="mailto:{{ $e }}"><x-icon name="mail" :size="18" /> {{ $e }}</a>@endif
            </div>
        </aside>
    </div>
</section>

@include('partials.cta')
@endsection
