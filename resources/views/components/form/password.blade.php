<div class="form-floating">
    <input type="password" class="form-control {{$inputClass ?? ''}}" wire:model.blur="{{$wirePrefix}}{{$field ?? ''}}" id="{{$wirePrefix}}{{$field}}" @if(!empty($disabled))disabled @endif @if(!empty($readOnly))readonly @endif/>
    {{$slot}}
</div>
