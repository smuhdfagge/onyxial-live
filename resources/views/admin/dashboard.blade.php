@extends('admin.layout')
@section('title', 'Dashboard')

@section('content')
<div class="welcome">
    <div>
        <h1>Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 17 ? 'afternoon' : 'evening') }}, {{ \Illuminate\Support\Str::before(auth()->user()->name, ' ') }}</h1>
        <p class="muted">Here is what is happening on onyxial.com.</p>
    </div>
    <div class="welcome__actions">
        <a href="{{ route('admin.projects.create') }}" class="btn btn--primary"><x-icon name="plus" :size="16" /> Add project</a>
        <a href="{{ route('home') }}" target="_blank" class="btn btn--ghost"><x-icon name="external" :size="16" /> View site</a>
    </div>
</div>

<div class="kpis">
    @foreach($counts as $c)
        <a href="{{ route($c['route']) }}" class="kpi">
            <span class="kpi__icon"><x-icon :name="$c['icon']" :size="20" /></span>
            <span class="kpi__value">{{ $c['value'] }}</span>
            <span class="kpi__label">{{ $c['label'] }}</span>
        </a>
    @endforeach
</div>

<div class="grid-2">
    <section class="card">
        <div class="card__head">
            <h2>Latest messages</h2>
            <a href="{{ route('admin.messages.index') }}" class="link">All messages <x-icon name="arrow-right" :size="14" /></a>
        </div>
        @forelse($messages as $m)
            <a href="{{ route('admin.messages.show', $m) }}" class="msg-row {{ $m->read_at ? '' : 'is-unread' }}">
                <span class="avatar avatar--soft">{{ mb_strtoupper(mb_substr($m->name, 0, 1)) }}</span>
                <span class="msg-row__body">
                    <strong>{{ $m->name }}</strong>
                    <span>{{ $m->subject ?: \Illuminate\Support\Str::limit($m->message, 60) }}</span>
                </span>
                <span class="msg-row__time">{{ $m->created_at->diffForHumans(short: true) }}</span>
            </a>
        @empty
            <div class="empty"><x-icon name="inbox" :size="30" /><p>No messages yet. Enquiries from the website's contact forms will appear here.</p></div>
        @endforelse
    </section>

    <section class="card">
        <div class="card__head"><h2>Enquiries, last 6 months</h2></div>
        @php $max = max(1, $byMonth->max('value')); @endphp
        <div class="bars" role="img" aria-label="Enquiries per month: {{ $byMonth->map(fn($m) => $m['label'].' '.$m['value'])->implode(', ') }}">
            @foreach($byMonth as $m)
                <div class="bars__col">
                    <span class="bars__val">{{ $m['value'] }}</span>
                    <span class="bars__bar" style="height: {{ max(4, round($m['value'] / $max * 100)) }}%"></span>
                    <span class="bars__label">{{ $m['label'] }}</span>
                </div>
            @endforeach
        </div>
    </section>
</div>

<div class="grid-2">
    <section class="card">
        <div class="card__head">
            <h2>Recently updated projects</h2>
            <a href="{{ route('admin.projects.index') }}" class="link">All projects <x-icon name="arrow-right" :size="14" /></a>
        </div>
        <ul class="simple-list">
            @foreach($projects as $p)
                <li>
                    <a href="{{ route('admin.projects.edit', $p) }}">{{ $p->title }}</a>
                    <span class="muted">{{ $p->category?->name }} · {{ $p->updated_at->format('j M Y') }}</span>
                </li>
            @endforeach
        </ul>
    </section>

    <section class="card">
        <div class="card__head"><h2>Things to check</h2></div>
        @if(count($checks))
            <ul class="checks">
                @foreach($checks as $c)
                    <li><span class="dot"></span><a href="{{ $c['route'] }}">{{ $c['text'] }}</a></li>
                @endforeach
            </ul>
        @else
            <div class="empty"><x-icon name="check-circle" :size="30" /><p>Everything looks good.</p></div>
        @endif
        <div class="quick">
            <a href="{{ route('admin.settings.edit') }}"><x-icon name="settings" :size="16" /> Site settings</a>
            <a href="{{ route('admin.pages.index') }}"><x-icon name="search" :size="16" /> Page SEO</a>
            <a href="{{ url('/sitemap.xml') }}" target="_blank"><x-icon name="external" :size="16" /> Sitemap</a>
        </div>
    </section>
</div>
@endsection
