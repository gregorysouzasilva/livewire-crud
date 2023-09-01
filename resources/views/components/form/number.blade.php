<div class="form-floating">
    <input type="number" class="form-control {{$inputClass ?? ''}}" wire:model.blur="{{$wirePrefix}}{{$field ?? ''}}" id="{{$wirePrefix}}{{$field}}" @if(!empty($disabled))disabled @endif/>
    {{$slot}}
</div>
