@extends('layouts.site')

@section('content')
@include('partials.page-hero', [
    'title' => $page?->heading ?: 'Our Services',
    'intro' => $page?->intro,
    'eyebrow' => 'What we do',
    'image' => $page?->banner,
    'crumbs' => [[$page?->title ?? 'Our Services', route('services.index')]],
])

<section class="section">
    <div class="container">
        <div class="service-rows">
            @foreach($services as $service)
                <article class="service-row {{ $loop->even ? 'service-row--flip' : '' }}">
                    <div class="service-row__media" data-reveal>
                        @if(has_media($service->image))
                            <img src="{{ media_url($service->image) }}" alt="{{ $service->title }}" width="620" height="440" loading="lazy">
                        @else
                            <div class="service-row__placeholder"><x-icon :name="$service->icon ?: 'sparkle'" :size="64" :stroke="1.25" /></div>
                        @endif
                        <span class="service-row__num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="service-row__copy" data-reveal data-delay="1">
                        <span class="service-card__icon"><x-icon :name="$service->icon ?: 'sparkle'" :size="26" /></span>
                        <h2 class="h3">{{ $service->title }}</h2>
                        <p class="lead">{{ $service->excerpt }}</p>
                        @if($service->points)
                            <ul class="ticks ticks--cols">
                                @foreach(array_slice($service->points, 0, 4) as $point)
                                    <li><x-icon name="check" :size="18" /> {{ $point }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <a href="{{ $service->url() }}" class="btn btn--primary">Read more <x-icon name="arrow-right" :size="16" /></a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

@if($whyUs->count())
<section class="section section--navy why">
    <div class="why__pattern" aria-hidden="true"></div>
    <div class="container why__grid">
        <div class="why__intro">
            <p class="eyebrow eyebrow--light" data-reveal>Why choose us</p>
            <h2 class="h2 h2--light" data-reveal>{{ setting('why_title', 'Global experience, applied to local markets') }}</h2>
            <p class="why__text" data-reveal>{{ setting('why_text') }}</p>
        </div>
        <div class="why__list">
            @foreach($whyUs as $item)
                <article class="why-item" data-reveal data-delay="{{ $loop->index }}">
                    <span class="why-item__icon"><x-icon :name="$item->icon ?: 'check'" :size="22" /></span>
                    <div><h3>{{ $item->title }}</h3><p>{{ $item->body }}</p></div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($process->count())
<section class="section process">
    <div class="container">
        <div class="section-head section-head--center">
            <p class="eyebrow" data-reveal>How we work</p>
            <h2 class="h2" data-reveal>Our four-step process</h2>
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

@include('partials.cta')
@endsection
