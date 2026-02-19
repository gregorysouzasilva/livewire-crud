<div class="form-floating">
    <input type="text" class="form-control {{$inputClass ?? ''}}" wire:model{{ ($defer ?? false) ? '' : '.blur' }}="{{$wirePrefix}}{{$field ?? ''}}" id="{{$wirePrefix}}{{$field}}" @if(!empty($disabled))disabled @endif @if(!empty($readOnly))readonly @endif max="255"/>
    {{$slot}}
</div>
