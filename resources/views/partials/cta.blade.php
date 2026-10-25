<section class="cta">
    <div class="container">
        <div class="cta__box" data-reveal>
            <div class="cta__pattern" aria-hidden="true"></div>
            <div class="cta__text">
                <p class="eyebrow eyebrow--light">{{ setting('cta_eyebrow', 'Work with us') }}</p>
                <h2>{{ setting('cta_heading', 'Looking to invest in Nigeria, or bring investors to your state?') }}</h2>
                <p>{{ setting('cta_text', 'Tell us what you are working on. We will help you find the right opportunities, partners and route to market.') }}</p>
            </div>
            <div class="cta__actions">
                <a href="{{ route('contacts') }}#contact-form" class="btn btn--light btn--lg">Start a conversation <x-icon name="arrow-right" :size="18" /></a>
                @if($p = setting('contact_phone'))
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $p) }}" class="btn btn--ghost-light btn--lg"><x-icon name="phone" :size="17" /> {{ $p }}</a>
                @endif
            </div>
        </div>
    </div>
</section>
