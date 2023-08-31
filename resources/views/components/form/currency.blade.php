<div class="form-floating">
    <input type="number" class="form-control" wire:model.lazy="{{$wirePrefix}}{{$field ?? ''}}" id="{{$wirePrefix}}{{$field}}" @if(!empty($disabled))disabled @endif/>
    {{$slot}}
</div>
