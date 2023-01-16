<div class="form-floating">
    <input type="text" class="form-control {{$inputClass ?? ''}}" wire:model.lazy="{{$wirePrefix}}{{$field ?? ''}}" placeholder="" id="{{$wirePrefix}}{{$field}}" @if(!empty($disabled))disabled @endif max="255"/>
    {{$slot}}
</div>
