@extends('layouts.site')

@section('content')
@include('partials.page-hero', [
    'title' => $page?->heading ?: 'Frequently asked questions',
    'intro' => $page?->intro,
    'eyebrow' => 'FAQ',
    'image' => $page?->banner,
    'crumbs' => [[$page?->title ?? 'FAQ', route('faq')]],
])

<section class="section">
    <div class="container faq-layout">
        <aside class="faq-layout__side">
            <div class="aside-card aside-card--navy" data-reveal>
                <x-icon name="help" :size="34" />
                <h2 class="aside-card__title">Still have a question?</h2>
                <p>If you cannot find the answer here, send us a message and a member of the team will reply.</p>
                <a href="{{ route('contacts') }}#contact-form" class="btn btn--light">Ask us directly <x-icon name="arrow-right" :size="16" /></a>
            </div>
        </aside>

        <div class="accordion" data-accordion>
            @foreach($faqs as $faq)
                <div class="acc" data-reveal data-delay="{{ min($loop->index, 4) }}">
                    <h2 class="acc__head">
                        <button type="button" class="acc__btn" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="faq-{{ $faq->id }}" id="faq-btn-{{ $faq->id }}">
                            <span class="acc__num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            <span class="acc__q">{{ $faq->question }}</span>
                            <span class="acc__icon" aria-hidden="true"><x-icon name="plus" :size="18" /></span>
                        </button>
                    </h2>
                    <div class="acc__panel" id="faq-{{ $faq->id }}" role="region" aria-labelledby="faq-btn-{{ $faq->id }}" @unless($loop->first) hidden @endunless>
                        <div class="prose">{!! clean_html($faq->answer) !!}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@include('partials.cta')
@endsection
