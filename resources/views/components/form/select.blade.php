@php
    $id = str_replace('.', '-', $wirePrefix) . '-' . $field;
@endphp
<div class="form-floating" wire:ignore 
    x-data="{}" x-init="
        $('#{{$id}}').select2({
            allowClear: true,
            placeholder: 'Select',
            dropdownParent: $('#{{$id}}').parent()
        });

        $('#{{$id}}').on('change', function (e) {
            var data = $('#{{$id}}').select2('val');
            $wire.set('{{$wirePrefix}}{{$field}}', data);

            // Directly call unsaved changes check
            if (typeof window.UnsavedChanges !== 'undefined') {
                window.UnsavedChanges.check();
            }
        });

        // Register with unsaved changes detection
        if (typeof window.UnsavedChanges !== 'undefined') {
            window.UnsavedChanges.registerSelect2('{{$id}}');
        }
    ">
    @php
    
    if(is_object($options)) {
        $options = collect($options)->toArray();
    }

    @endphp

        <select class="form-select {{$inputClass ?? ''}}@if(!empty($disabled) || !empty($readOnly))form-select-solid @endif"  id="{{$id}}" @if(!empty($disabled) || !empty($readOnly))disabled @endif @if(!empty($multiple)) multiple @endif>
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
            <option value="{{$optionArray[0]}}" @if(in_array($optionArray[0], (array)$value)) selected @endif>{{__($optionArray[1] ?? $optionArray[0])}}</option>
        @endforeach
    </select>
    {{$slot}}
</div>