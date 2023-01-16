<div class="form-floating">
    <input type="number" class="form-control {{$inputClass ?? ''}}" wire:model.lazy="{{$wirePrefix}}{{$field ?? ''}}" placeholder="" id="{{$wirePrefix}}{{$field}}" @if(!empty($disabled))disabled @endif/>
    {{$slot}}
</div>
