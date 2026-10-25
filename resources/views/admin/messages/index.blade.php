@extends('admin.layout')
@section('title', 'Messages')

@section('content')
<div class="page-head">
    <div>
        <h1><x-icon name="inbox" :size="24" /> Messages</h1>
        <p class="muted">Enquiries sent through the website's contact forms.</p>
    </div>
</div>

<div class="card card--flush">
    <form class="toolbar" method="get">
        <div class="tabs-inline">
            <a href="{{ route('admin.messages.index') }}" @class(['is-active' => !$status])>All</a>
            <a href="{{ route('admin.messages.index', ['status' => 'unread']) }}" @class(['is-active' => $status === 'unread'])>Unread @if($unread)<span class="side__count">{{ $unread }}</span>@endif</a>
            <a href="{{ route('admin.messages.index', ['status' => 'read']) }}" @class(['is-active' => $status === 'read'])>Read</a>
        </div>
        @if($status)<input type="hidden" name="status" value="{{ $status }}">@endif
        <label class="search">
            <x-icon name="search" :size="17" />
            <input type="search" name="q" value="{{ $search }}" placeholder="Search messages…" aria-label="Search messages">
        </label>
    </form>

    @forelse($messages as $m)
        <a href="{{ route('admin.messages.show', $m) }}" class="msg-row msg-row--wide {{ $m->read_at ? '' : 'is-unread' }}">
            <span class="avatar avatar--soft">{{ mb_strtoupper(mb_substr($m->name, 0, 1)) }}</span>
            <span class="msg-row__body">
                <strong>{{ $m->name }} <span class="muted">&lt;{{ $m->email }}&gt;</span></strong>
                <span><b>{{ $m->subject ?: 'General enquiry' }}</b> — {{ \Illuminate\Support\Str::limit($m->message, 110) }}</span>
            </span>
            <span class="msg-row__meta">
                @if($m->source)<span class="pill pill--soft">{{ $m->source }}</span>@endif
                <span class="msg-row__time">{{ $m->created_at->format('j M, H:i') }}</span>
            </span>
        </a>
    @empty
        <div class="empty empty--big"><x-icon name="inbox" :size="36" /><p>No messages{{ $status ? ' here' : ' yet' }}.</p></div>
    @endforelse

    <div class="pager">{{ $messages->links('admin.partials.pagination') }}</div>
</div>
@endsection
