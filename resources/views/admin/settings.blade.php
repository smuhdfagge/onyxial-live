@extends('admin.layout')
@section('title', 'Site settings')

@push('head')<link rel="stylesheet" href="{{ asset('assets/vendor/quill/quill.snow.css') }}">@endpush
@push('scripts')<script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>@endpush

@section('content')
<div class="page-head">
    <div>
        <h1><x-icon name="settings" :size="24" /> Site settings</h1>
        <p class="muted">Company details, contact information, home page text and search engine settings.</p>
    </div>
</div>

<form action="{{ route('admin.settings.update') }}" method="post" enctype="multipart/form-data" data-edit-form data-tabs>
    @csrf @method('PUT')
    <input type="hidden" name="_tab" value="general" data-tab-input>

    <div class="tabs" role="tablist">
        @foreach($groups as $key => $g)
            <button type="button" role="tab" class="tab" data-tab="{{ $key }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                <x-icon :name="$g['icon']" :size="16" /> {{ $g['label'] }}
            </button>
        @endforeach
    </div>

    <div class="edit">
        <div class="edit__main">
            @foreach($groups as $key => $g)
                <section class="card" role="tabpanel" data-panel="{{ $key }}" @unless($loop->first) hidden @endunless>
                    @foreach($g['fields'] as $field)
                        @php
                            [$k, $label, $type] = $field;
                            $help = $field[3] ?? null;
                            $f = ['name' => $k, 'label' => $label, 'type' => $type === 'code' ? 'textarea' : $type, 'help' => $help, 'rows' => $type === 'code' ? 5 : 3];
                            $fake = new \Illuminate\Support\Fluent([$k => setting($k)]);
                            $fake->exists = true;
                        @endphp
                        @include('admin.partials.field', ['f' => $f, 'item' => $fake])
                    @endforeach
                </section>
            @endforeach
        </div>
        <aside class="edit__side">
            <section class="card card--sticky">
                <button type="submit" class="btn btn--primary btn--block"><x-icon name="check" :size="16" /> Save settings</button>
                <p class="muted small center">Saves every tab at once.</p>
            </section>
        </aside>
    </div>
</form>
@endsection
