<div x-data="{}" x-init="$('#{{$field}}').flatpickr({dateFormat: 'm/Y'});" class="form-floating">
    <input type="" class="form-control" wire:model.blur="{{$wirePrefix}}{{$field}}" id="{{$wirePrefix}}{{$field}}" />
    {{$slot}}
</div>