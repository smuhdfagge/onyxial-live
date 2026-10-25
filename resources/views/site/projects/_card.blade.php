<a href="{{ $project->url() }}" class="project-card" data-reveal data-delay="{{ $delay ?? 0 }}">
    <div class="project-card__img">
        @if(has_media($project->image))
            <img src="{{ media_url($project->image) }}" alt="{{ $project->title }}" width="480" height="340" loading="lazy">
        @else
            <div class="project-card__placeholder"><x-icon name="briefcase" :size="40" /></div>
        @endif
        @if($project->category)<span class="badge">{{ $project->category->name }}</span>@endif
    </div>
    <div class="project-card__body">
        <p class="project-card__meta">
            @if($project->client)<span>{{ $project->client }}</span>@endif
        </p>
        <h3 class="project-card__title">{{ $project->title }}</h3>
        <p class="project-card__text">{{ \Illuminate\Support\Str::limit($project->summary, 140) }}</p>
        <span class="link-arrow">Read more <x-icon name="arrow-right" :size="16" /></span>
    </div>
</a>
