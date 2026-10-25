@extends('layouts.site')

@section('content')
@include('partials.page-hero', [
    'title' => $project->title,
    'intro' => $project->summary,
    'eyebrow' => $project->category?->name ?? 'Our projects',
    'image' => $project->image,
    'crumbs' => [['Our Projects', route('projects.index')], [$project->title, $project->url()]],
])

<section class="section">
    <div class="container detail">
        <article class="detail__main">
            @if(has_media($project->image))
                <figure class="detail__figure" data-reveal>
                    <img src="{{ media_url($project->image) }}" alt="{{ $project->title }}" width="900" height="560">
                </figure>
            @endif

            @if($project->background)
                <div class="detail__block" data-reveal>
                    <h2 class="h3">The background</h2>
                    <div class="prose prose--lg">{!! clean_html($project->background) !!}</div>
                </div>
            @endif

            @if($project->images->count())
                <div class="gallery gallery--project" data-gallery data-reveal>
                    @foreach($project->images as $img)
                        <a href="{{ media_url($img->path) }}" class="gallery__item" data-lightbox="project" data-caption="{{ $img->caption }}">
                            <img src="{{ media_url($img->path) }}" alt="{{ $img->caption ?: $project->title.' — photo '.$loop->iteration }}" loading="lazy">
                            <span class="gallery__zoom"><x-icon name="zoom" :size="22" /></span>
                        </a>
                    @endforeach
                </div>
            @endif

            @if($project->solution)
                <div class="detail__block" data-reveal>
                    <h2 class="h3">Our approach</h2>
                    <div class="prose prose--lg">{!! clean_html($project->solution) !!}</div>
                </div>
            @endif

            <nav class="pager" aria-label="More projects" data-reveal>
                @if($prev)
                    <a href="{{ route('projects.show', $prev->slug) }}" class="pager__link"><span class="pager__dir"><x-icon name="arrow-left" :size="16" /> Previous</span><span class="pager__title">{{ $prev->title }}</span></a>
                @else <span></span> @endif
                @if($next)
                    <a href="{{ route('projects.show', $next->slug) }}" class="pager__link pager__link--next"><span class="pager__dir">Next <x-icon name="arrow-right" :size="16" /></span><span class="pager__title">{{ $next->title }}</span></a>
                @endif
            </nav>
        </article>

        <aside class="detail__aside">
            <div class="aside-card facts" data-reveal>
                <h2 class="aside-card__title">Project details</h2>
                <dl class="facts__list">
                    @if($project->client)<div><dt>Client</dt><dd>{{ $project->client }}</dd></div>@endif
                    @if($project->category)<div><dt>Sector</dt><dd><a href="{{ route('projects.category', $project->category) }}">{{ $project->category->name }}</a></dd></div>@endif
                    @if($project->start_date)<div><dt>Start date</dt><dd>{{ $project->start_date->format('j F Y') }}</dd></div>@endif
                    @if($project->location)<div><dt>Location</dt><dd>{{ $project->location }}</dd></div>@endif
                    <div><dt>Status</dt><dd><span class="status status--{{ $project->status }}">{{ $project->statusLabel() }}</span></dd></div>
                    @foreach(($project->facts ?? []) as $fact)
                        @if(!empty($fact['label']) && !empty($fact['value']))
                            <div><dt>{{ $fact['label'] }}</dt><dd>{{ $fact['value'] }}</dd></div>
                        @endif
                    @endforeach
                </dl>
                <div class="share">
                    <span>Share</span>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($project->url()) }}" target="_blank" rel="noopener" aria-label="Share on LinkedIn"><x-icon name="linkedin" :size="17" /></a>
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($project->title) }}&url={{ urlencode($project->url()) }}" target="_blank" rel="noopener" aria-label="Share on X"><x-icon name="x-brand" :size="17" /></a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($project->url()) }}" target="_blank" rel="noopener" aria-label="Share on Facebook"><x-icon name="facebook" :size="17" /></a>
                    <button type="button" data-copy="{{ $project->url() }}" aria-label="Copy link"><x-icon name="link" :size="17" /></button>
                </div>
            </div>
            <div class="aside-card aside-card--navy" data-reveal>
                <h2 class="aside-card__title">Have a similar project?</h2>
                <p>We work with governments, development partners and investors on projects like this one.</p>
                <a href="{{ route('contacts') }}#contact-form" class="btn btn--light">Get in touch <x-icon name="arrow-right" :size="16" /></a>
            </div>
        </aside>
    </div>
</section>

@if($related->count())
<section class="section section--tint">
    <div class="container">
        <div class="section-head">
            <div>
                <p class="eyebrow" data-reveal>More work</p>
                <h2 class="h2" data-reveal>Other projects</h2>
            </div>
            <a href="{{ route('projects.index') }}" class="btn btn--outline" data-reveal>All projects <x-icon name="arrow-right" :size="16" /></a>
        </div>
        <div class="project-grid">
            @foreach($related as $p)
                @include('site.projects._card', ['project' => $p, 'delay' => $loop->index])
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
