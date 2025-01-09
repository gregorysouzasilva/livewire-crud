@php
    $wirePrefix = $wirePrefix ?? '';
@endphp
<div class="fv-row mb-10 col-{{$width ?? 4}}" id='div-{{$wirePrefix}}-{{$field}}' style="display: inline-block">
    @if ($type == 'checkbox')
        <x-form.checkbox :field="$field" :wirePrefix="$wirePrefix" :value="$value ?? 1" inputClass="form-control-solid" />
    @endif
    
    <label class="form-label" style="display: inline">@lang($label)
        @if(!empty($explanation))
            <button type="button"
                class="btn btn-light-info btn-icon btn-sm d-sm-inline"
                wire:click="openExplanation({{ $explanation }})"
                title="Click to open the explanation of this item"> <i
                    class="bi bi-question-circle-fill" style="cursor:pointer "></i>
            </button>
        @endif 
    </label>
        <span style="float:right">{{ $slot }}</span>

    @if ($type != 'checkbox')
        <x-dynamic-component component="{{'form.' . $type}}" :field="$field" :options="$options ?? []" :wirePrefix="$wirePrefix" :value="$value ?? []" inputClass="form-control-solid" :useIndex="$useIndex ?? false"  />
    @endif
    @error($wirePrefix . $field)
        <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" data-validator="notEmpty">{{ $message }}</div></div>
    @enderror
</div>