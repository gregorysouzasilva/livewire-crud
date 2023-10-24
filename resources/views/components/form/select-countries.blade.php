@props(['field','options', 'wirePrefix', 'value', 'disabled'])
<div class="form-floating" wire:ignore 
x-data="{}" x-init="
    $('#{{$field}}').select2({
        allowClear: true,
        placeholder: 'Select'
    });
    $('#{{$field}}').on('change', function (e) {
        var data = $('#{{$field}}').select2('val');
        $wire.set('{{$wirePrefix}}{{$field}}', data);
    });
">
@php
$options = config('types.countries');
@endphp

<select class="form-select {{$inputClass ?? ''}}"  id="{{$wirePrefix}}{{$field}}" @if(!empty($disabled))disabled @endif>
        <option></option>
    @foreach ($options as $option)
        @if(empty(trim($option)))
            @continue
        @endif
        @php($optionArray = explode(',',$option))
        <option value="{{$optionArray[0]}}" @if($optionArray[0] == $value) selected @endif>{{$optionArray[1] ?? $optionArray[0]}}</option>
    @endforeach
</select>
{{$slot}}
</div>