@extends('admin.layout')
@section('title', $heading)

@php
    $main = array_filter($fields, fn ($f) => empty($f['section']));
    $side = array_filter($fields, fn ($f) => ($f['section'] ?? '') === 'side');
    $seo = array_filter($fields, fn ($f) => ($f['section'] ?? '') === 'seo');
    $hasRich = collect($fields)->contains(fn ($f) => $f['type'] === 'richtext');
@endphp

@if($hasRich)
    @push('head')<link rel="stylesheet" href="{{ asset('assets/vendor/quill/quill.snow.css') }}">@endpush
    @push('scripts')<script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>@endpush
@endif

@section('content')
<div class="page-head">
    <div>
        <a href="{{ route($route.'.index') }}" class="back"><x-icon name="arrow-left" :size="15" /> {{ $title }}</a>
        <h1>{{ $item->exists ? \Illuminate\Support\Str::limit((string) ($item->title ?? $item->name ?? $item->question ?? $item->caption ?? $item->from_path ?? $heading), 70) : $heading }}</h1>
    </div>
    <div class="page-head__actions">
        @if($item->exists && ($url = $controller->publicUrl($item)))
            <a href="{{ $url }}" target="_blank" class="btn btn--ghost"><x-icon name="external" :size="16" /> View on site</a>
        @endif
    </div>
</div>

<form action="{{ $item->exists ? route($route.'.update', $item) : route($route.'.store') }}" method="post" enctype="multipart/form-data" class="edit" data-edit-form>
    @csrf
    @if($item->exists) @method('PUT') @endif

    <div class="edit__main">
        <section class="card">
            @foreach($main as $f)
                @include('admin.partials.field', ['f' => $f, 'item' => $item])
            @endforeach
        </section>

        @if(count($seo))
            <section class="card">
                <div class="card__head">
                    <h2><x-icon name="search" :size="18" /> Search engines & sharing</h2>
                </div>
                <p class="muted small">Leave these blank to use the title and summary automatically.</p>
                @foreach($seo as $f)
                    @include('admin.partials.field', ['f' => $f, 'item' => $item])
                @endforeach
                <div class="serp" data-serp>
                    <span class="serp__url">{{ $item->exists && ($u = $controller->publicUrl($item)) ? $u : url('/') }}</span>
                    <span class="serp__title" data-serp-title>{{ $item->meta_title ?: ($item->title ?? $item->name ?? 'Page title') }}</span>
                    <span class="serp__desc" data-serp-desc>{{ $item->meta_description ?: plain_excerpt($item->excerpt ?? $item->summary ?? $item->intro ?? '', 158) }}</span>
                </div>
            </section>
        @endif
    </div>

    <aside class="edit__side">
        <section class="card card--sticky">
            <button type="submit" class="btn btn--primary btn--block"><x-icon name="check" :size="16" /> {{ $item->exists ? 'Save changes' : 'Create '.$singular }}</button>
            @if($item->exists && $item->updated_at)
                <p class="muted small center">Last saved {{ $item->updated_at->diffForHumans() }}</p>
            @endif
            @if(count($side))<hr>@endif
            @foreach($side as $f)
                @include('admin.partials.field', ['f' => $f, 'item' => $item])
            @endforeach
        </section>
    </aside>
</form>

@if($item->exists && $canDelete)
    <form action="{{ route($route.'.destroy', $item) }}" method="post" class="danger-zone" data-confirm="Delete this {{ $singular }}? This cannot be undone.">
        @csrf @method('DELETE')
        <div><strong>Delete this {{ $singular }}</strong><p class="muted small">It will be removed from the website straight away.</p></div>
        <button type="submit" class="btn btn--danger"><x-icon name="trash" :size="16" /> Delete</button>
    </form>
@endif

@if($extra)
    @include($extra[0], $extra[1])
@endif
@endsection
