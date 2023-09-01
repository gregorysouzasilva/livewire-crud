@php
    $id = str_replace('.', '-', $wirePrefix) . '-' . $field;
@endphp
<div class="form-floating">
    @php
    
    if(is_object($options)) {
        $options = collect($options)->toArray();
    }

    asort($options);
    @endphp

        <select class="form-select {{$inputClass ?? ''}}"  id="{{$id}}" @if(!empty($disabled))disabled @endif @if(!empty($multiple)) multiple @endif wire:model.blur="{{$wirePrefix}}{{$field ?? ''}}">
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
            <option value="{{$optionArray[0]}}" @if(in_array($optionArray[0], (array)$value)) selected @endif>{{$optionArray[1] ?? $optionArray[0]}}</option>
        @endforeach
    </select>
    {{$slot}}
</div>