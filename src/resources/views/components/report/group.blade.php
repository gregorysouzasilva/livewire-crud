@if($field !== 'N/A')
<td colspan="{{$colspan ?? null}}">
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
</td>
@endif