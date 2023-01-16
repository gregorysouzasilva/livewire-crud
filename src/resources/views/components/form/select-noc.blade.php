@props(['field','options', 'wirePrefix', 'value'])
@php
    $id = str_replace('.', '-', $wirePrefix) . '-' . $field;
@endphp
<div class="form-floating" wire:ignore 
    x-data="{}" x-init="
        $('#{{$id}}').select2({
            allowClear: true,
            placeholder: 'Select',
            ajax: {
                url: '/api/nocs',
                dataType: 'json'
            }
        });
        $('#{{$id}}').on('change', function (e) {
            var data = $('#{{$id}}').select2('val');
            @this.set('{{$wirePrefix}}{{$field}}', data);
        });
    ">

        <select class="form-select {{$inputClass ?? ''}}"  id="{{$id}}">
            @if(!empty($value))
            <option selected>{{$value ?? ''}}</option>
            @endif
    </select>
    {{$slot}}
</div>