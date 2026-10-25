@php
    // "subtitle" holds the display format, with # where the number goes: "#+", "$#M+", "#k+"
    $format = $stat->subtitle ?: '#';
    [$prefix, $suffix] = array_pad(explode('#', $format, 2), 2, '');
    $num = (float) $stat->value;
@endphp
<div class="stat" data-reveal data-delay="{{ $loop->index ?? 0 }}">
    <p class="stat__value">
        <span>{{ $prefix }}</span><span data-count="{{ $num }}">{{ rtrim(rtrim(number_format($num, 1, '.', ''), '0'), '.') }}</span><span>{{ $suffix }}</span>
    </p>
    <p class="stat__label">{{ $stat->title }}</p>
    @if($stat->body)<p class="stat__note">{{ $stat->body }}</p>@endif
</div>
