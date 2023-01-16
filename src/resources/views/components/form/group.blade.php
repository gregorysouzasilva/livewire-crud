@php
$disabled = $disabled ?? 0;
$width = $width ?? 4;
$wirePrefix = $wirePrefix ?? 'model.';
$label= $label ??  ucwords(str_replace(['_', '.'], ' ', $field));
$hideLabel = $hideLabel ?? false;
if(!empty($options) && empty($type)) {
    $type = 'select';
}
$type = $type ?? 'text';
@endphp
<!--begin::Input group-->
<div class="form-floating mb-4 col-xl-{{$width}} col-md-{{$width+2}} col-sm-12" id='div-{{$wirePrefix}}-{{$field}}'>
        <x-crud::dynamic-component component="{{'form.' . $type}}" :field="$field" :options="$options ?? []" :wirePrefix="$wirePrefix" :value="$value ?? []" 
            :disabled="$disabled ?? false" :multiple="$multiple ?? false" :useIndex="$useIndex ?? false" label="{{$label}}" :hideLabel="$hideLabel">
            @if(!$hideLabel)
                <label for="{{$field}}" @if($type=="memoeditor")style="margin-top:-17px;"@endif>@lang($label)</label>
            @endif
        </x-crud::dynamic-component>
        @error("$wirePrefix$field") <span class="invalid-feedback" style="display: block">@lang($message)</span>@enderror
</div>