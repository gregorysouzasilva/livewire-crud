@props(['label', 'field', 'type','options', 'width', 'wirePrefix','value','disabled', 'multiple'])
@php
$disabled = $disabled ?? 0;
@endphp
<!--begin::Input group-->
<div class="mb-4 col-{{$width ?? 4}}" id='div-{{$wirePrefix}}-{{$field}}' style="align-self: center;">
        <x-crud::form.checkbox :field="$field" :options="$options ?? []" :wirePrefix="$wirePrefix" :value="$value ?? []" inputClass="form-control-solid" />
        <label for="{{$field}}" class="form-label" style="display: inline"><span>@lang($label)</span></label>
        @error("$wirePrefix$field") <span class="invalid-feedback" style="display: block">@lang($message)</span>@enderror
</div>
<!--end::Input group-->