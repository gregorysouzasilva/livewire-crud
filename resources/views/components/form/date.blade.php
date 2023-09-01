@php
    $id = str_replace('.', '-', $wirePrefix) . '-' . $field;
@endphp
<div x-data="{}" x-init="$('#{{$id}}').flatpickr({disableMobile: true});" class="form-floating">
    <input type="text" class="form-control {{$inputClass ?? ''}}@if(!empty($disabled))form-control-solid @endif" wire:model.blur="{{$wirePrefix}}{{$field}}" id="{{$id}}" @if(!empty($disabled))disabled @endif/>
    {{$slot}}
</div> 