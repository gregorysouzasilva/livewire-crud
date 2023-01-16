@php
$position = !empty($position) ? $position : '';
@endphp
@if(!empty(trim($slot)) || !empty($showZero))
    <span class=" @if($position=='top')position-absolute top-0 start-100 badge-circle translate-middle @endif badge badge-{{$color ?? 'primary'}}" title="{{$title ?? NULL}}">
    {{ $slot }}
    </span>
@endif