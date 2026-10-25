@extends('admin.layout')
@section('title', $user->exists ? 'Edit admin' : 'Add admin')

@section('content')
<div class="page-head">
    <div>
        <a href="{{ route('admin.users.index') }}" class="back"><x-icon name="arrow-left" :size="15" /> Admin users</a>
        <h1>{{ $user->exists ? $user->name : 'Add admin' }}</h1>
    </div>
</div>

<form action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}" method="post" class="narrow">
    @csrf
    @if($user->exists) @method('PUT') @endif
    <section class="card">
        <div class="f"><label for="u-name">Full name <span class="req">*</span></label><input id="u-name" name="name" value="{{ old('name', $user->name) }}" required></div>
        <div class="f"><label for="u-email">Email <span class="req">*</span></label><input id="u-email" type="email" name="email" value="{{ old('email', $user->email) }}" required></div>
        <div class="f">
            <label for="u-pass">{{ $user->exists ? 'New password' : 'Password' }} @unless($user->exists)<span class="req">*</span>@endunless</label>
            <input id="u-pass" type="password" name="password" autocomplete="new-password" @unless($user->exists) required @endunless>
            <p class="hint">At least 10 characters.{{ $user->exists ? ' Leave blank to keep the current password.' : '' }}</p>
        </div>
        <div class="f"><label for="u-pass2">Confirm password</label><input id="u-pass2" type="password" name="password_confirmation" autocomplete="new-password"></div>
        <button type="submit" class="btn btn--primary"><x-icon name="check" :size="16" /> {{ $user->exists ? 'Save changes' : 'Create account' }}</button>
    </section>
</form>
@endsection
