@php
    $name = $f['name'];
    $type = $f['type'] ?? 'text';
    $id = 'f-'.$name;
    $value = old($name, $item->{$name} ?? null);
    if (! $item->exists && $value === null && array_key_exists('default', $f)) {
        $value = $f['default'];
    }
    $icons = ['compass', 'handshake', 'insight', 'graduation', 'briefcase', 'chart', 'trending', 'target', 'award', 'shield',
        'layers', 'puzzle', 'users', 'user', 'lightbulb', 'rocket', 'star', 'globe', 'building', 'flag', 'check', 'clock',
        'calendar', 'search', 'tag', 'sparkle', 'map-pin', 'mail', 'phone'];
@endphp
<div class="f {{ $type === 'checkbox' ? 'f--check' : '' }}" data-field="{{ $name }}">
    @if($type !== 'checkbox')
        <label for="{{ $id }}">
            {{ $f['label'] }} @if(!empty($f['required']))<span class="req" aria-hidden="true">*</span>@endif
            @if(!empty($f['max']))<span class="counter" data-counter-for="{{ $id }}" data-max="{{ $f['max'] }}"></span>@endif
        </label>
    @endif

    @switch($type)
        @case('textarea')
            <textarea id="{{ $id }}" name="{{ $name }}" rows="{{ $f['rows'] ?? 4 }}" @if(!empty($f['max'])) data-max="{{ $f['max'] }}" @endif @if($name === 'meta_description') data-serp-desc-input @endif>{{ $value }}</textarea>
            @break

        @case('richtext')
            <div class="rich" data-rich>
                <div class="rich__editor" data-rich-editor>{!! clean_html($value) !!}</div>
                <textarea id="{{ $id }}" name="{{ $name }}" class="rich__source" data-rich-input hidden>{{ $value }}</textarea>
            </div>
            @break

        @case('image')
            @php $src = media_url($value); @endphp
            <div class="upload" data-upload>
                <div class="upload__preview {{ $src ? '' : 'is-empty' }}" data-upload-preview>
                    @if($src)<img src="{{ $src }}" alt="">@else<x-icon name="image" :size="28" /><span>No image</span>@endif
                </div>
                <label class="upload__btn">
                    <x-icon name="image" :size="16" /> {{ $src ? 'Replace image' : 'Choose image' }}
                    <input type="file" id="{{ $id }}" name="{{ $name }}" accept="image/*" data-upload-input>
                </label>
                @if($value)
                    <label class="check small"><input type="checkbox" name="{{ $name }}_remove" value="1"> <span>Remove current image</span></label>
                    @if(!$src)<p class="hint">The file <code>{{ $value }}</code> is not on the server yet. Upload a new image or run <code>php artisan onyx:import-images</code>.</p>@endif
                @endif
            </div>
            @break

        @case('select')
            <select id="{{ $id }}" name="{{ $name }}">
                @foreach($f['options'] as $k => $label)
                    <option value="{{ $k }}" @selected((string) $value === (string) $k)>{{ $label }}</option>
                @endforeach
            </select>
            @break

        @case('icon')
            <div class="icon-pick" role="radiogroup" aria-label="{{ $f['label'] }}">
                @foreach($icons as $ic)
                    <label class="icon-pick__opt" title="{{ $ic }}">
                        <input type="radio" name="{{ $name }}" value="{{ $ic }}" @checked($value === $ic)>
                        <span><x-icon :name="$ic" :size="18" /></span>
                    </label>
                @endforeach
            </div>
            @break

        @case('checkbox')
            <label class="switch">
                <input type="checkbox" id="{{ $id }}" name="{{ $name }}" value="1" @checked((bool) $value)>
                <span class="switch__track"><span class="switch__dot"></span></span>
                <span>{{ $f['label'] }}</span>
            </label>
            @break

        @case('list')
            <textarea id="{{ $id }}" name="{{ $name }}" rows="{{ $f['rows'] ?? 5 }}">{{ is_array($value) ? implode("\n", $value) : $value }}</textarea>
            @break

        @case('facts')
            @php
                $rows = old($name.'_label') ? collect(old($name.'_label'))->map(fn ($l, $i) => ['label' => $l, 'value' => old($name.'_value')[$i] ?? ''])->all() : ($item->{$name} ?? []);
                $rows = array_merge($rows ?: [], [['label' => '', 'value' => '']]);
            @endphp
            <div class="facts" data-facts>
                @foreach($rows as $row)
                    <div class="facts__row" data-facts-row>
                        <input type="text" name="{{ $name }}_label[]" value="{{ $row['label'] ?? '' }}" placeholder="Label, e.g. Concession" aria-label="Label">
                        <input type="text" name="{{ $name }}_value[]" value="{{ $row['value'] ?? '' }}" placeholder="Value, e.g. 30 years" aria-label="Value">
                        <button type="button" class="icon-btn" data-facts-remove aria-label="Remove row"><x-icon name="close" :size="16" /></button>
                    </div>
                @endforeach
                <button type="button" class="btn btn--ghost btn--sm" data-facts-add><x-icon name="plus" :size="15" /> Add row</button>
            </div>
            @break

        @case('slug')
            <div class="prefixed">
                <span>{{ $f['prefix'] ?? '/' }}</span>
                <input type="text" id="{{ $id }}" name="{{ $name }}" value="{{ $value }}" data-slug-from="f-{{ $f['from'] ?? 'title' }}" @if($item->exists) data-slug-locked @endif>
            </div>
            @break

        @default
            <input type="{{ in_array($type, ['email', 'url', 'number', 'date']) ? $type : 'text' }}" id="{{ $id }}" name="{{ $name }}"
                   value="{{ $type === 'date' && $value instanceof \DateTimeInterface ? $value->format('Y-m-d') : $value }}"
                   @if(!empty($f['required'])) required @endif
                   @if(!empty($f['max'])) data-max="{{ $f['max'] }}" @endif
                   @if($name === 'meta_title') data-serp-title-input @endif>
    @endswitch

    @if(!empty($f['help']))<p class="hint">{{ $f['help'] }}</p>@endif
    @error($name)<p class="err">{{ $message }}</p>@enderror
</div>
