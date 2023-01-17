<div class="mb-3">
    @if(!$hideLabel)
    <label class="form-label">{{$label ?? ''}} ({{$validations ?? 'all types'}})</label>
    @endif
    <input type="file" class="form-control" wire:model="{{$wirePrefix.$field}}" accept="
    @foreach(explode(',', $validations ?? '') as $validation)
        .{{$validation}},
    @endforeach
    ">
    <div wire:loading wire:target="{{$wirePrefix.$field}}">Uploading...</div>
    {{-- @error("$wirePrefix$field") <span class="invalid-feedback" style="display: block">@lang($message)</span>@enderror --}}
</div>
{{-- 
@if ({{$value}})
    <div class="row">

        <div class="col-11 card me-1 mb-1">
            {{$value->getClientOriginalName()}}
        </div>
    </div>
@endif --}}