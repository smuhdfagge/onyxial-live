@php
    $footServices = \App\Models\Service::published()->ordered()->get(['title', 'slug']);
    $office = \App\Models\Office::published()->ordered()->first();
@endphp
<footer class="footer">
    <div class="footer__lines" aria-hidden="true"></div>
    <div class="container footer__grid">
        <div class="footer__about">
            <a href="{{ route('home') }}" class="footer__brand">
                <img src="{{ asset('assets/img/logo-white.png') }}" alt="Onyx Investment Advisory Limited" width="170" height="77">
            </a>
            <p>{{ setting('footer_about', 'Investment promotion, facilitation and advisory for businesses, investors and governments working in Nigeria.') }}</p>
            <div class="footer__social">
                @foreach(social_links() as $key => $s)
                    <a href="{{ $s['url'] }}" target="_blank" rel="noopener" aria-label="{{ $s['label'] }}"><x-icon :name="$key === 'x' ? 'x-brand' : $key" :size="18" /></a>
                @endforeach
            </div>
        </div>

        <div>
            <h2 class="footer__title">Company</h2>
            <ul class="footer__links">
                <li><a href="{{ route('about') }}">About us</a></li>
                <li><a href="{{ route('team.index') }}">Our team</a></li>
                <li><a href="{{ route('projects.index') }}">Our projects</a></li>
                <li><a href="{{ route('faq') }}">FAQ</a></li>
                <li><a href="{{ route('contacts') }}">Contacts</a></li>
            </ul>
        </div>

        <div>
            <h2 class="footer__title">Services</h2>
            <ul class="footer__links">
                @foreach($footServices as $s)
                    <li><a href="{{ route('services.show', $s->slug) }}">{{ $s->title }}</a></li>
                @endforeach
            </ul>
        </div>

        <div>
            <h2 class="footer__title">Get in touch</h2>
            <ul class="footer__contact">
                @if($office)
                    <li><x-icon name="map-pin" :size="18" /><span>{{ $office->address }}</span></li>
                @endif
                @if($p = setting('contact_phone'))
                    <li><x-icon name="phone" :size="18" /><a href="tel:{{ preg_replace('/[^0-9+]/', '', $p) }}">{{ $p }}</a></li>
                @endif
                @if($e = setting('contact_email'))
                    <li><x-icon name="mail" :size="18" /><a href="mailto:{{ $e }}">{{ $e }}</a></li>
                @endif
            </ul>
        </div>
    </div>

    <div class="container footer__bottom">
        <p>&copy; {{ date('Y') }} {{ setting('site_name', 'Onyx Investment Advisory Limited') }}. All rights reserved.</p>
        @if($credit = setting('footer_credit'))<p>{{ $credit }}</p>@endif
    </div>
</footer>
