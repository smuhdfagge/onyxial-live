@extends('admin.layout')
@section('title', $title)

@section('content')
<div class="page-head">
    <div>
        <h1><x-icon :name="$icon" :size="24" /> {{ $title }}</h1>
        @if($intro)<p class="muted">{{ $intro }}</p>@endif
    </div>
    @if($canCreate)
        <a href="{{ route($route.'.create') }}" class="btn btn--primary"><x-icon name="plus" :size="16" /> Add {{ $singular }}</a>
    @endif
</div>

<div class="card card--flush">
    <form class="toolbar" method="get">
        <label class="search">
            <x-icon name="search" :size="17" />
            <input type="search" name="q" value="{{ $search }}" placeholder="Search {{ strtolower($title) }}…" aria-label="Search">
        </label>
        @if($filterField)
            <select name="filter" onchange="this.form.submit()" aria-label="Filter">
                <option value="">All sections</option>
                @foreach($filterOptions as $k => $v)
                    <option value="{{ $k }}" @selected((string) $filter === (string) $k)>{{ $v }}</option>
                @endforeach
            </select>
        @endif
        @if($search || $filter)<a href="{{ route($route.'.index') }}" class="link">Clear</a>@endif
        <span class="toolbar__count">{{ $items->total() }} {{ \Illuminate\Support\Str::plural('item', $items->total()) }}</span>
    </form>

    @if($items->count())
    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    @foreach($columns as $col)<th @if(($col['type'] ?? '') === 'image') class="col-img" @endif>{{ $col['label'] }}</th>@endforeach
                    <th class="col-actions"><span class="sr-only">Actions</span></th>
                </tr>
            </thead>
            <tbody>
            @foreach($items as $item)
                <tr>
                    @foreach($columns as $col)
                        @php $val = data_get($item, $col['key']); $type = $col['type'] ?? 'text'; @endphp
                        <td data-label="{{ $col['label'] }}" @class(['col-img' => $type === 'image'])>
                            @switch($type)
                                @case('image')
                                    @if($src = media_url($val))
                                        <img src="{{ $src }}" alt="" @class(['thumb', 'thumb--round' => !empty($col['round']), 'thumb--contain' => !empty($col['contain'])]) loading="lazy">
                                    @else
                                        <span @class(['thumb thumb--empty', 'thumb--round' => !empty($col['round'])])><x-icon name="image" :size="16" /></span>
                                    @endif
                                    @break
                                @case('title')
                                    <a href="{{ route($route.'.edit', $item) }}" class="cell-title">{{ $val ?: ($col['empty'] ?? '—') }}</a>
                                    @if(!empty($col['sub']) && data_get($item, $col['sub']))
                                        <span class="cell-sub">{{ \Illuminate\Support\Str::limit(data_get($item, $col['sub']), 70) }}</span>
                                    @endif
                                    @break
                                @case('bool')
                                    @if($val)<span class="pill pill--on">{{ $col['yes'] ?? 'Visible' }}</span>@else<span class="pill">{{ $col['no'] ?? 'Hidden' }}</span>@endif
                                    @break
                                @case('badge')
                                    <span class="pill pill--soft">{{ ucfirst((string) $val) }}</span>
                                    @break
                                @case('map')
                                    <span class="pill pill--soft">{{ $col['map'][$val] ?? $val }}</span>
                                    @break
                                @case('date')
                                    <span class="muted">{{ $val?->format('j M Y, H:i') }}</span>
                                    @break
                                @default
                                    {{ \Illuminate\Support\Str::limit((string) $val, 60) ?: '—' }}
                            @endswitch
                        </td>
                    @endforeach
                    <td class="col-actions">
                        <div class="row-actions">
                            @if($url = $controller->publicUrl($item))
                                <a href="{{ $url }}" target="_blank" class="icon-btn" title="View on website" aria-label="View on website"><x-icon name="eye" :size="17" /></a>
                            @endif
                            <a href="{{ route($route.'.edit', $item) }}" class="icon-btn" title="Edit" aria-label="Edit"><x-icon name="edit" :size="17" /></a>
                            @if($canDelete)
                                <form action="{{ route($route.'.destroy', $item) }}" method="post" data-confirm="Delete this {{ $singular }}? This cannot be undone.">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="icon-btn icon-btn--danger" title="Delete" aria-label="Delete"><x-icon name="trash" :size="17" /></button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="pager">{{ $items->links('admin.partials.pagination') }}</div>
    @else
        <div class="empty empty--big">
            <x-icon :name="$icon" :size="36" />
            <p>{{ $search ? 'Nothing matches your search.' : 'Nothing here yet.' }}</p>
            @if($canCreate && !$search)<a href="{{ route($route.'.create') }}" class="btn btn--primary"><x-icon name="plus" :size="16" /> Add {{ $singular }}</a>@endif
        </div>
    @endif
</div>
@endsection
