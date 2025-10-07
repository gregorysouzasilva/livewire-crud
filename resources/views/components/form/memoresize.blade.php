<div class="form-floating">
    <textarea class="form-control" wire:model.blur="{{$wirePrefix}}{{$field ?? ''}}" id="{{$wirePrefix}}{{$field}}" @if(!empty($disabled))disabled @endif @if(!empty($readOnly))readonly @endif/>
</div>
{{$slot}}