@php
    $id = str_replace('.', '-', $wirePrefix) . '-' . $field;
@endphp
<div x-data="{}" x-init="$('#{{$id}}').flatpickr({disableMobile: true});" class="form-floating">
    <input type="text" class="form-control {{$inputClass ?? ''}}@if(!empty($disabled))form-control-solid @endif" wire:model{{ ($defer ?? false) ? '' : '.blur' }}="{{$wirePrefix}}{{$field}}" id="{{$id}}" @if(!empty($disabled))disabled @endif @if(!empty($readOnly))readonly @endif autocomplete="off"/>
    {{$slot}}
</div> 