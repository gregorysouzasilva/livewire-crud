<input type="checkbox" class="form-check-input {{$inputClass ?? ''}}" wire:model.lazy="{{$wirePrefix}}{{$field ?? ''}}" placeholder="" id="{{$wirePrefix}}{{$field}}" value="{{$value ?? '1'}}"/>

