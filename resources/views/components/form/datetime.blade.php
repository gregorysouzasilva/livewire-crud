<div x-data="{}" x-init="
    Inputmask({
        mask : '99/99/9999 99:99',
        clearIncomplete: true,
    }).mask('#{{$field}}');" 
class="form-floating">
    <input type="text" class="form-control {{$inputClass ?? ''}} @if(!empty($disabled))form-control-solid @endif" wire:model{{ ($defer ?? false) ? '' : '.blur' }}="{{$wirePrefix}}{{$field ?? ''}}" id="{{$wirePrefix}}{{$field}}" @if(!empty($disabled))disabled @endif @if(!empty($readOnly))readonly @endif/>
    {{$slot}}
</div> 