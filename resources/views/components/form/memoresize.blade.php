<div class="form-floating">
    <textarea class="form-control" wire:model.blur="{{$wirePrefix}}{{$field ?? ''}}" id="{{$wirePrefix}}{{$field}}"/>
</div>
{{$slot}}