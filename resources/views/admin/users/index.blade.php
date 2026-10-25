@extends('admin.layout')
@section('title', 'Admin users')

@section('content')
<div class="page-head">
    <div>
        <h1><x-icon name="lock" :size="24" /> Admin users</h1>
        <p class="muted">People who can sign in and edit the website.</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn btn--primary"><x-icon name="plus" :size="16" /> Add admin</a>
</div>

<div class="card card--flush">
    <div class="table-wrap">
        <table class="table">
            <thead><tr><th>Name</th><th>Email</th><th>Last sign-in</th><th class="col-actions"><span class="sr-only">Actions</span></th></tr></thead>
            <tbody>
            @foreach($users as $u)
                <tr>
                    <td data-label="Name"><a href="{{ route('admin.users.edit', $u) }}" class="cell-title">{{ $u->name }}</a> @if($u->id === auth()->id())<span class="pill pill--soft">You</span>@endif</td>
                    <td data-label="Email">{{ $u->email }}</td>
                    <td data-label="Last sign-in"><span class="muted">{{ $u->last_login_at?->diffForHumans() ?? 'Never' }}</span></td>
                    <td class="col-actions">
                        <div class="row-actions">
                            <a href="{{ route('admin.users.edit', $u) }}" class="icon-btn" aria-label="Edit"><x-icon name="edit" :size="17" /></a>
                            @if($u->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $u) }}" method="post" data-confirm="Delete {{ $u->name }}'s admin account?">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="icon-btn icon-btn--danger" aria-label="Delete"><x-icon name="trash" :size="17" /></button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
