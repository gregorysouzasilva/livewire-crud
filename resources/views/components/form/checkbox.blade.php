<input type="checkbox" class="form-check-input {{$inputClass ?? ''}}" wire:model.change="{{$wirePrefix}}{{$field ?? ''}}" id="{{$wirePrefix}}{{$field}}" value="{{$value ?? '1'}}"/>

