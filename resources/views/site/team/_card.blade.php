<article class="team-card" data-reveal data-delay="{{ $delay ?? 0 }}">
    <a href="{{ $member->url() }}" class="team-card__photo" aria-label="{{ $member->name }} — read profile">
        @if(has_media($member->photo))
            <img src="{{ media_url($member->photo) }}" alt="{{ $member->name }}, {{ $member->position }}" width="380" height="460" loading="lazy">
        @else
            <span class="team-card__initials">{{ $member->initials() }}</span>
        @endif
        <span class="team-card__view"><x-icon name="arrow-up-right" :size="20" /></span>
    </a>
    <div class="team-card__body">
        <h3 class="team-card__name"><a href="{{ $member->url() }}">{{ $member->name }}</a></h3>
        <p class="team-card__role">{{ $member->position }}</p>
        <div class="team-card__links">
            @if($member->linkedin)<a href="{{ $member->linkedin }}" target="_blank" rel="noopener" aria-label="{{ $member->name }} on LinkedIn"><x-icon name="linkedin" :size="17" /></a>@endif
            @if($member->twitter)<a href="{{ $member->twitter }}" target="_blank" rel="noopener" aria-label="{{ $member->name }} on X"><x-icon name="x-brand" :size="17" /></a>@endif
            @if($member->email)<a href="mailto:{{ $member->email }}" aria-label="Email {{ $member->name }}"><x-icon name="mail" :size="17" /></a>@endif
        </div>
    </div>
</article>
