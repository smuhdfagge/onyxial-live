@extends('layouts.site')

@php
    $seo = \App\Support\Seo::make()->title('Page not found');
    $seo->noindex = true;
@endphp

@section('content')
<section class="notfound">
    <div class="container notfound__inner">
        <p class="notfound__code" data-reveal>404</p>
        <h1 class="h2" data-reveal>We could not find that page</h1>
        <p class="lead" data-reveal>The page may have moved when we refreshed the website. Try one of these instead.</p>
        <div class="notfound__links" data-reveal>
            <a href="{{ route('home') }}" class="btn btn--primary">Go to the home page</a>
            <a href="{{ route('services.index') }}" class="btn btn--outline">Our services</a>
            <a href="{{ route('projects.index') }}" class="btn btn--outline">Our projects</a>
            <a href="{{ route('contacts') }}" class="btn btn--outline">Contact us</a>
        </div>
    </div>
</section>
@endsection
