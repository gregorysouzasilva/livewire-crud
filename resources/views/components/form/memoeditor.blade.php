@php
    $id = str_replace('.', '-', $wirePrefix) . $field;
@endphp
{{$slot}}<br>
<div
    wire:ignore 
    class="form-textarea w-full"
    x-data="{}"
    x-init="
    ClassicEditor.create(document.querySelector('#{{$id}}'))
        .then( function(editor){
            @if(!empty($disabled) || !empty($readOnly))
            editor.enableReadOnlyMode('{{$id}}');
            @endif

            editor.ui.focusTracker.on( 'change:isFocused', ( evt, name, isFocused ) => {
                if ( !isFocused ) {
                    $wire.set('{{$wirePrefix . $field}}', editor.getData())
                }
            } );

            Livewire.on('clearForm', () => {
                editor.setData('','')
            })
            
            Livewire.on('setForm', (data) => {
                data = data[0].data
                editor.setData(data)
            })

            // Register with unsaved changes detection
            if (typeof window.UnsavedChanges !== 'undefined') {
                window.UnsavedChanges.registerCKEditor('{{$id}}', editor);
            }
        })
        .catch( error => {
            console.error( error );
        } );
    "
    wire:key="{{$id}}"
    x-ref="{{$id}}"
    wire:model.debounce.9999999ms="{{$wirePrefix}}{{$field ?? ''}}"
    id='{{$id}}'
>{!! $value !!}
</div>