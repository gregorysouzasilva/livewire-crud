@props(['label', 'field', 'type','options', 'width', 'wirePrefix','value'])

<div class="fv-row mb-10 col-{{$width ?? 4}}" id='div-{{$wirePrefix}}-{{$field}}'>    
    <label class="form-label">@lang($label)</label>

        <x-form.number field="{{$field . "_eligibility"}}" :wirePrefix="$wirePrefix" inputClass="form-control-solid" />
        <x-form.number field="{{$field . "_score"}}" :wirePrefix="$wirePrefix" inputClass="form-control-solid" />
    @error($wirePrefix . $field)
        <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" data-validator="notEmpty">{{ $message }}</div></div>
    @enderror
</div>