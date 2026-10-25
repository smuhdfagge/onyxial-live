@extends('layouts.site')

@section('content')
@include('partials.page-hero', [
    'title' => $active ? $active->name : ($page?->heading ?: 'Our Projects'),
    'intro' => $active ? 'Projects in '.$active->name.'.' : $page?->intro,
    'eyebrow' => 'Our projects',
    'image' => $page?->banner,
    'crumbs' => array_filter([[$page?->title ?? 'Our Projects', route('projects.index')], $active ? [$active->name, route('projects.category', $active)] : null]),
])

<section class="section">
    <div class="container">
        @if($categories->count() > 1)
            <nav class="chips" aria-label="Filter projects by sector" data-reveal>
                <a href="{{ route('projects.index') }}" class="chip {{ !$active ? 'is-active' : '' }}">All projects</a>
                @foreach($categories as $cat)
                    <a href="{{ route('projects.category', $cat) }}" class="chip {{ $active?->id === $cat->id ? 'is-active' : '' }}">{{ $cat->name }}</a>
                @endforeach
            </nav>
        @endif

        <div class="project-grid">
            @forelse($projects as $project)
                @include('site.projects._card', ['project' => $project, 'delay' => $loop->index % 3])
            @empty
                <p class="muted">No projects to show here yet.</p>
            @endforelse
        </div>
    </div>
</section>

@include('partials.cta')
@endsection
