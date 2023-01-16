<div class="form-floating mb-4 col-{{$width ?? 4}}" id='div-{{$field}}'>
    <label for="{{$field}}" class="readOnlyLabel">@lang($label)</label>
    <input type="text" class="form-control form-control-solid" id="{{$field}}" name="{{$field}}" value="{{$value}}" @if(!$pageInfo['is_editable'])disabled @else readonly @endif>
</div>