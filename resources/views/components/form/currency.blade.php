<div class="form-floating">
    <input type="number" class="form-control" wire:model{{ ($defer ?? false) ? '' : '.blur' }}="{{$wirePrefix}}{{$field ?? ''}}" id="{{$wirePrefix}}{{$field}}" @if(!empty($disabled))disabled @endif @if(!empty($readOnly))readonly @endif/>
    {{$slot}}
</div>
