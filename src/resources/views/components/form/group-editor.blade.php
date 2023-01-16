@props(['label', 'field', 'type','options', 'width', 'wirePrefix','value','disabled'])
@php
$disabled = $disabled ?? 0;
@endphp
<!--begin::Input group-->
<div class="mb-4 col-{{$width ?? 4}}" id='div-{{$wirePrefix}}-{{$field}}' wire:ignore>
    <label for="{{$field}}">@lang($label)</label>
        <x-crud::dynamic-component component="{{'form.' . $type}}" :field="$field" :options="$options ?? []" :wirePrefix="$wirePrefix" :value="$value ?? []" :disabled="$disabled ?? false">
        </x-crud::dynamic-component>
        @error("$wirePrefix$field") <span class="invalid-feedback" style="display: block">@lang($message)</span>@enderror
</div>