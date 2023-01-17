<div class="form-floating">
    <textarea class="form-control" wire:model.lazy="{{$wirePrefix}}{{$field ?? ''}}" placeholder="" id="{{$wirePrefix}}{{$field}}"/>
</div>
{{$slot}}