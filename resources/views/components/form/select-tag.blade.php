@php
    $id = str_replace('.', '-', $wirePrefix) . '-' . $field;
@endphp
<div class="form-floating" wire:ignore 
    x-data="{}" x-init="
        $('#{{$id}}').select2({
            tags: true,
            dropdownParent: $('#{{$id}}').parent()
        });
        $('#{{$id}}').on('change', function (e) {
            var data = $('#{{$id}}').select2('val');
            $wire.set('{{$wirePrefix}}{{$field}}', data);
        });
    ">
    @php

    @endphp

        <select class="form-select {{$inputClass ?? ''}}"  id="{{$id}}" @if(!empty($disabled))disabled @endif @if(!empty($multiple)) multiple @endif>
            <option></option>
        @foreach ($options as $ind => $option)
            @if(empty(trim($option)))
                @continue
            @endif
            <option @if($option == $value)) selected @endif>{{$option}}</option>
        @endforeach
    </select>
    {{$slot}}
</div>