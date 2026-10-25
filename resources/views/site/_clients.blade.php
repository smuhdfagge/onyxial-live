@if(isset($clients) && $clients->count())
<section class="clients" aria-labelledby="clients-title">
    <div class="container">
        <p class="clients__title" id="clients-title" data-reveal>Trusted by governments and institutions</p>
    </div>
    <div class="marquee" data-reveal>
        <div class="marquee__track">
            @foreach([1, 2] as $pass)
                @foreach($clients as $client)
                    <div class="marquee__item" @if($pass === 2) aria-hidden="true" @endif>
                        @if(has_media($client->logo))
                            <img src="{{ media_url($client->logo) }}" alt="{{ $pass === 1 ? $client->name : '' }}" title="{{ $client->name }}" loading="lazy" height="70">
                        @else
                            <span class="marquee__name">{{ $client->name }}</span>
                        @endif
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>
</section>
@endif
