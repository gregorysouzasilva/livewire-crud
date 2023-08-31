<div class="">
    <textarea class="form-control {{$inputClass ?? ''}} pt-10" wire:model.lazy="{{$wirePrefix}}{{$field ?? ''}}" id="{{$wirePrefix}}{{$field}}" rows="4" style="height: auto" @if(!empty($disabled))disabled @endif></textarea>
</div>
{{$slot}}