@props(['color'])

<span class="text-{{ $color }} fw-bold mx-auto" style="font-size: 14px">{{ $slot }}</span>