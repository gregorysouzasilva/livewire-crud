@props(['id', 'icon' => 'bi-chevron-expand', 'caption' => null, 'color' => 'btn-light'])
<button @click="expanded = ! expanded"
    class="btn btn-sm {{ $color }}" type="button" title="Expand">
    <i class="bi {{ $icon }}"></i>
    @if($caption)
        <span class="ms-1">{{ $caption }}</span>
    @endif
</button>

