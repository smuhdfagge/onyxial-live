@extends('layouts.site')

@section('content')
@include('partials.page-hero', [
    'title' => $page?->heading ?: 'Our Team',
    'intro' => $page?->intro,
    'eyebrow' => 'Our people',
    'image' => $page?->banner,
    'crumbs' => [[$page?->title ?? 'Our Team', route('team.index')]],
])

<section class="section">
    <div class="container">
        @if($page?->body)
            <div class="prose prose--center" data-reveal>{!! clean_html($page->body) !!}</div>
        @endif
        <div class="team-grid team-grid--page">
            @forelse($team as $member)
                @include('site.team._card', ['member' => $member, 'delay' => $loop->index])
            @empty
                <p class="muted">Team profiles will appear here soon.</p>
            @endforelse
        </div>
    </div>
</section>

@include('partials.cta')
@endsection
