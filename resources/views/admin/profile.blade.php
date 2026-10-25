@extends('admin.layout')
@section('title', 'My profile')

@section('content')
<div class="page-head">
    <div><h1><x-icon name="user" :size="24" /> My profile</h1></div>
</div>

<form action="{{ route('admin.profile.update') }}" method="post" class="narrow">
    @csrf @method('PUT')
    <section class="card">
        <div class="card__head"><h2>Your details</h2></div>
        <div class="f"><label for="p-name">Full name</label><input id="p-name" name="name" value="{{ old('name', $user->name) }}" required></div>
        <div class="f"><label for="p-email">Email</label><input id="p-email" type="email" name="email" value="{{ old('email', $user->email) }}" required></div>
    </section>
    <section class="card">
        <div class="card__head"><h2>Change password</h2></div>
        <div class="f"><label for="p-cur">Current password</label><input id="p-cur" type="password" name="current_password" autocomplete="current-password"></div>
        <div class="f"><label for="p-new">New password</label><input id="p-new" type="password" name="password" autocomplete="new-password"><p class="hint">At least 10 characters. Leave blank to keep your current password.</p></div>
        <div class="f"><label for="p-new2">Confirm new password</label><input id="p-new2" type="password" name="password_confirmation" autocomplete="new-password"></div>
        <button type="submit" class="btn btn--primary"><x-icon name="check" :size="16" /> Save</button>
    </section>
</form>
@endsection
