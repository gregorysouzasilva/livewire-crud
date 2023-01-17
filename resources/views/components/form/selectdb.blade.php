@props(['field','options', 'wirePrefix', 'value'])
<div class="form-floating" wire:ignore x-data="{}" x-init="
$('#{{$field}}').select2({
    allowClear: true,
    placeholder: 'Select'
});
$('#{{$field}}').on('change', function (e) {
    var data = $('#{{$field}}').select2('val');
    @this.set('{{$wirePrefix}}{{$field}}', data);
});
">
<select class="form-select {{$inputClass ?? ''}}"  id="{{$wirePrefix}}{{$field}}">
    <option></option>
    @php($select = (object)$options)
    @foreach (\DB::table($select->tabela)->get() as $option)
        @php($labelArray = explode('|',$select->label))
        @if(count($labelArray) > 1)
            @php($label = $option->{$labelArray[0]} . ' - ' . $option->{$labelArray[1]})
        @else
            @php($label = $option->{$labelArray[0]})
        @endif
        <option value="{{$option->{$select->campo} }}" @if($option->{$select->campo} == $value) selected @endif>{{$label }}</option>
    @endforeach
    @foreach ($options['opcoes'] ?? [] as $option)
        @if(empty(trim($option)))
            @continue
        @endif
        @php($optionArray = explode(',',$option))
        <option value="{{$optionArray[0]}}" @if($optionArray[0] == $value) selected @endif>{{$optionArray[1] ?? $optionArray[0]}}</option>
    @endforeach
</select>
{{$slot}}
</div>