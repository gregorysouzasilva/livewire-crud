<div class="form-floating">
    <input type="password" class="form-control {{$inputClass ?? ''}}" wire:model.blur="{{$wirePrefix}}{{$field ?? ''}}" id="{{$wirePrefix}}{{$field}}"/>
    {{$slot}}
</div>
