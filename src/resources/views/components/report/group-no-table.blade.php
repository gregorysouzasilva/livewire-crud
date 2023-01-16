@if($field !== 'N/A')
<div class="group">
    <span class="bold">
        @lang($label)
    </span>
    <br>
    @if(is_bool($field))
        @if($field)
            @lang('Yes')
        @else
            @lang('No')
        @endif
    @elseif(!empty($type) && $type=='html')
        {!! $field !!}
    @else
        @lang($field)
    @endif
</div>
@endif