<div class="form-floating">
    <input type="text" class="form-control" wire:model.lazy="{{$wirePrefix}}{{$field ?? ''}}" placeholder="" id="{{$wirePrefix}}{{$field}}" @if(!empty($disabled))disabled @endif/>
    {{$slot}}
</div>
