<div x-data="{}" x-init="
    Inputmask({
        mask : '99/99/9999 99:99',
        clearIncomplete: true,
    }).mask('#{{$field}}');" 
class="form-floating">
    <input type="text" class="form-control {{$inputClass ?? ''}}" wire:model.blur="{{$wirePrefix}}{{$field ?? ''}}" id="{{$wirePrefix}}{{$field}}"/>
    {{$slot}}
</div>