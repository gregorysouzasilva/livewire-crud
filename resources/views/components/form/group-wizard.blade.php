@php
    $wirePrefix = $wirePrefix ?? '';
@endphp
<div class="fv-row mb-10 col-{{$width ?? 4}}" id='div-{{$wirePrefix}}-{{$field}}' style="display: inline-block">
    @if ($type == 'checkbox')
        <x-form.checkbox :field="$field" :wirePrefix="$wirePrefix" :value="$value ?? 1" />
    @endif
    
    <label class="form-label" style="display: inline">@lang($label)
        @if(!empty($explanation))<i class="bi bi-question-circle-fill" wire:click="openExplanation({{$explanation}})" style="cursor:pointer " title="Click to open the explanation of this item"></i> @endif </label>
        <span style="float:right">{{ $slot }}</span>

    @if ($type != 'checkbox')
        <x-dynamic-component component="{{'form.' . $type}}" :field="$field" :options="$options ?? []" :wirePrefix="$wirePrefix" :value="$value ?? []" :useIndex="$useIndex ?? false"  />
    @endif
    @error($wirePrefix . $field)
        <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" data-validator="notEmpty">{{ $message }}</div></div>
    @enderror
</div>