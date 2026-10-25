@extends('layouts.site')

@section('content')
@include('partials.page-hero', [
    'title' => $member->name,
    'intro' => $member->position,
    'eyebrow' => 'Our team',
    'crumbs' => [['Our Team', route('team.index')], [$member->name, $member->url()]],
])

<section class="section">
    <div class="container profile">
        <aside class="profile__side">
            <div class="profile__photo" data-reveal>
                @if(has_media($member->photo))
                    <img src="{{ media_url($member->photo) }}" alt="{{ $member->name }}, {{ $member->position }}" width="420" height="500">
                @else
                    <span class="team-card__initials">{{ $member->initials() }}</span>
                @endif
            </div>
            <div class="aside-card" data-reveal>
                <h2 class="aside-card__title">{{ $member->name }}</h2>
                <p class="muted">{{ $member->position }}</p>
                <ul class="profile__contact">
                    @if($member->email)<li><a href="mailto:{{ $member->email }}"><x-icon name="mail" :size="18" /> {{ $member->email }}</a></li>@endif
                    @if($member->linkedin)<li><a href="{{ $member->linkedin }}" target="_blank" rel="noopener"><x-icon name="linkedin" :size="18" /> LinkedIn profile</a></li>@endif
                    @if($member->twitter)<li><a href="{{ $member->twitter }}" target="_blank" rel="noopener"><x-icon name="x-brand" :size="18" /> Profile on X</a></li>@endif
                </ul>
            </div>
        </aside>

        <article class="profile__main">
            @if($member->summary)<p class="lead lead--xl" data-reveal>{{ $member->summary }}</p>@endif
            <div class="prose prose--lg" data-reveal>{!! clean_html($member->bio) !!}</div>

            @if($member->credentials)
                <div class="points" data-reveal>
                    <h2 class="h4">Education and credentials</h2>
                    <ul class="points__list">
                        @foreach($member->credentials as $c)
                            <li><span class="points__icon"><x-icon name="award" :size="16" /></span>{{ $c }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <a href="{{ route('team.index') }}" class="btn btn--outline" data-reveal><x-icon name="arrow-left" :size="16" /> Back to the team</a>
        </article>
    </div>
</section>

@if($others->count())
<section class="section section--tint">
    <div class="container">
        <div class="section-head">
            <div>
                <p class="eyebrow" data-reveal>Our team</p>
                <h2 class="h2" data-reveal>Meet the rest of the team</h2>
            </div>
        </div>
        <div class="team-grid">
            @foreach($others as $o)
                @include('site.team._card', ['member' => $o, 'delay' => $loop->index])
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
