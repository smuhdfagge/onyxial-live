@extends('layouts.site')

@section('content')
@include('partials.page-hero', [
    'title' => $page?->heading ?: 'Get in touch',
    'intro' => $page?->intro,
    'eyebrow' => 'Contacts',
    'image' => $page?->banner,
    'crumbs' => [[$page?->title ?? 'Contacts', route('contacts')]],
])

<section class="section">
    <div class="container contact">
        <div class="contact__info">
            @foreach($offices as $office)
                <article class="office" data-reveal data-delay="{{ $loop->index }}">
                    <span class="office__num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                    <h2 class="office__name">{{ $office->name }}</h2>
                    <ul class="office__list">
                        <li><x-icon name="map-pin" :size="18" /><span>{{ $office->address }}</span></li>
                        @if($office->phone)<li><x-icon name="phone" :size="18" /><a href="{{ $office->telHref() }}">{{ $office->phone }}</a></li>@endif
                        @if($office->email)<li><x-icon name="mail" :size="18" /><a href="mailto:{{ $office->email }}">{{ $office->email }}</a></li>@endif
                    </ul>
                </article>
            @endforeach

            @if(count(social_links()))
                <div class="office office--social" data-reveal>
                    <h2 class="office__name">Follow us</h2>
                    <div class="social-row">
                        @foreach(social_links() as $key => $s)
                            <a href="{{ $s['url'] }}" target="_blank" rel="noopener" aria-label="{{ $s['label'] }}"><x-icon :name="$key === 'x' ? 'x-brand' : $key" :size="18" /></a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div class="contact__form form-panel" data-reveal>
            <p class="eyebrow">Send a message</p>
            <h2 class="h3">{{ setting('contact_form_title', 'Tell us about your project') }}</h2>
            <p class="muted">{{ setting('contact_form_text', 'Whether you are an investor, a business or a government agency, we would like to hear from you. We usually reply within two working days.') }}</p>
            @include('partials.contact-form', ['source' => 'Contacts', 'services' => $services])
        </div>
    </div>
</section>

@php $mapOffice = $offices->firstWhere('map_query'); @endphp
@if($mapOffice)
<section class="map" aria-label="Map showing our {{ $mapOffice->name }}">
    <iframe title="Map: {{ $mapOffice->name }}" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
        src="https://maps.google.com/maps?q={{ urlencode($mapOffice->map_query) }}&t=m&z=15&output=embed&iwloc=near"></iframe>
</section>
@endif
@endsection
