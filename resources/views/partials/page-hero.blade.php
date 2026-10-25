{{--
    Inner page banner.
    Vars: $title, $intro (optional), $eyebrow (optional), $crumbs (array of [name, url]) optional, $image optional
--}}
<section class="page-hero {{ !empty($image) ? 'page-hero--image' : '' }}">
    @if(!empty($image))
        <div class="page-hero__bg" style="background-image:url('{{ media_url($image) }}')" aria-hidden="true"></div>
    @endif
    <div class="page-hero__pattern" aria-hidden="true"></div>
    <div class="container page-hero__inner">
        <nav class="crumbs" aria-label="Breadcrumb" data-reveal>
            <a href="{{ route('home') }}">Home</a>
            @foreach(($crumbs ?? []) as $crumb)
                <x-icon name="chevron-right" :size="14" />
                @if($loop->last)
                    <span aria-current="page">{{ $crumb[0] }}</span>
                @else
                    <a href="{{ $crumb[1] }}">{{ $crumb[0] }}</a>
                @endif
            @endforeach
        </nav>
        @if(!empty($eyebrow))<p class="eyebrow eyebrow--light" data-reveal>{{ $eyebrow }}</p>@endif
        <h1 class="page-hero__title" data-reveal>{{ $title }}</h1>
        @if(!empty($intro))<p class="page-hero__intro" data-reveal>{{ $intro }}</p>@endif
    </div>
</section>
