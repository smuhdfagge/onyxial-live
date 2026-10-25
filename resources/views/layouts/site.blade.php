@php
    /** @var \App\Support\Seo $seo */
    $seo = $seo ?? \App\Support\Seo::make();
    $siteName = setting('site_name', 'Onyx Investment Advisory Limited');
@endphp
<!DOCTYPE html>
<html lang="en-NG" class="no-js">
<head>
    <meta charset="utf-8">
    <script>document.documentElement.classList.remove('no-js')</script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $seo->fullTitle() }}</title>
    <meta name="description" content="{{ $seo->finalDescription() }}">
    @if($seo->keywords)<meta name="keywords" content="{{ $seo->keywords }}">@endif
    <meta name="robots" content="{{ ($seo->noindex || setting('seo_block_indexing') === '1') ? 'noindex, nofollow' : 'index, follow, max-image-preview:large' }}">
    <link rel="canonical" href="{{ $seo->canonical }}">
    <meta name="theme-color" content="#042755">

    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:locale" content="en_NG">
    <meta property="og:type" content="{{ $seo->type }}">
    <meta property="og:title" content="{{ $seo->fullTitle() }}">
    <meta property="og:description" content="{{ $seo->finalDescription() }}">
    <meta property="og:url" content="{{ $seo->canonical }}">
    <meta property="og:image" content="{{ $seo->finalImage() }}">
    <meta name="twitter:card" content="summary_large_image">
    @if($handle = setting('twitter_handle'))<meta name="twitter:site" content="{{ $handle }}">@endif
    <meta name="twitter:title" content="{{ $seo->fullTitle() }}">
    <meta name="twitter:description" content="{{ $seo->finalDescription() }}">
    <meta name="twitter:image" content="{{ $seo->finalImage() }}">
    @if($v = setting('google_site_verification'))<meta name="google-site-verification" content="{{ $v }}">@endif
    @if($v = setting('bing_site_verification'))<meta name="msvalidate.01" content="{{ $v }}">@endif

    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicon-32.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/img/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <link rel="preload" href="{{ asset('assets/fonts/archivo-latin-800-normal.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('assets/fonts/manrope-latin-400-normal.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="{{ asset('assets/css/site.css') }}?v={{ filemtime(public_path('assets/css/site.css')) }}">

    @foreach($seo->jsonLd() as $block)
        <script type="application/ld+json">{!! json_encode($block, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
    @endforeach

    @if($ga = setting('google_analytics_id'))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $ga }}"></script>
        <script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','{{ $ga }}');</script>
    @endif
    {!! setting('head_scripts') !!}
</head>
<body class="@yield('body_class')">
    <a class="skip-link" href="#main">Skip to content</a>

    @include('partials.header')

    <main id="main">
        @yield('content')
    </main>

    @include('partials.footer')

    <button class="to-top" type="button" aria-label="Back to top" data-to-top>
        <x-icon name="arrow-up" :size="18" />
    </button>

    <script src="{{ asset('assets/js/site.js') }}?v={{ filemtime(public_path('assets/js/site.js')) }}" defer></script>
</body>
</html>
