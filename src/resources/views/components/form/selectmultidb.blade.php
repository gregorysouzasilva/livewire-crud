@php
    $id = str_replace('.', '-', $wirePrefix) . '-' . $field;
@endphp
<div class="form-floating" wire:ignore x-data="{}" x-init="
    $('#{{$id}}').select2({
        allowClear: true,
        placeholder: 'Select'
    });
    $('#{{$id}}').on('change', function (e) {
        var data = $('#{{$id}}').select2('val');
        @this.set('{{$wirePrefix}}{{$field}}', data);
    });
">
@php($select = (object)$options)

    <select class="form-select {{$inputClass ?? ''}}"  id="{{$id}}" multiple style="height: 120px">
        <option></option>

        @foreach ($options as $ind => $option)
            @if(empty(trim($option)))
                @continue
            @endif
            @if(!empty($useIndex))
                @php($optionArray = [$ind, $option])
            @else
                @php($optionArray = explode(',',$option))
            @endif
    <option value="{{$optionArray[0]}}" @if(in_array($optionArray[0], $value)) selected @endif>{{$optionArray[1] ?? $optionArray[0]}}</option>

        @endforeach

    </select>
    {{$slot}}
</div>