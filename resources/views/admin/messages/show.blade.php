@extends('admin.layout')
@section('title', 'Message from '.$message->name)

@section('content')
<div class="page-head">
    <div>
        <a href="{{ route('admin.messages.index') }}" class="back"><x-icon name="arrow-left" :size="15" /> Messages</a>
        <h1>{{ $message->subject ?: 'General enquiry' }}</h1>
    </div>
    <div class="page-head__actions">
        <a href="mailto:{{ $message->email }}?subject={{ rawurlencode('Re: '.($message->subject ?: 'Your enquiry to Onyx Investment Advisory')) }}" class="btn btn--primary"><x-icon name="mail" :size="16" /> Reply by email</a>
        <form action="{{ route('admin.messages.toggle', $message) }}" method="post">
            @csrf @method('PATCH')
            <button type="submit" class="btn btn--ghost"><x-icon name="mail-open" :size="16" /> Mark as unread</button>
        </form>
    </div>
</div>

<div class="edit">
    <div class="edit__main">
        <section class="card">
            <div class="message-body">{{ $message->message }}</div>
        </section>
    </div>
    <aside class="edit__side">
        <section class="card">
            <dl class="dl">
                <dt>From</dt><dd>{{ $message->name }}</dd>
                <dt>Email</dt><dd><a href="mailto:{{ $message->email }}">{{ $message->email }}</a></dd>
                @if($message->phone)<dt>Phone</dt><dd><a href="tel:{{ preg_replace('/[^0-9+]/', '', $message->phone) }}">{{ $message->phone }}</a></dd>@endif
                @if($message->organisation)<dt>Organisation</dt><dd>{{ $message->organisation }}</dd>@endif
                @if($message->source)<dt>Sent from</dt><dd>{{ $message->source }} page</dd>@endif
                <dt>Received</dt><dd>{{ $message->created_at->format('l j F Y, H:i') }}</dd>
            </dl>
            <hr>
            <form action="{{ route('admin.messages.destroy', $message) }}" method="post" data-confirm="Delete this message?">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn--danger btn--block"><x-icon name="trash" :size="16" /> Delete message</button>
            </form>
        </section>
    </aside>
</div>
@endsection
