<input type="checkbox" class="form-check-input {{$inputClass ?? ''}}" wire:model.blur="{{$wirePrefix}}{{$field ?? ''}}" id="{{$wirePrefix}}{{$field}}" value="{{$value ?? '1'}}"/>

