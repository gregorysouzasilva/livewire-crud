@php
    $id = str_replace('.', '-', $wirePrefix) . $field;
    $slotId = 'slot-' . $id;
@endphp
<div id="{{$slotId}}" class="d-none">
    {{$slot}}
</div>
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

            // Listen for event to set editor content from AI
            window.addEventListener('set-editor-content', (event) => {
                if (event.detail.field === '{{$wirePrefix . $field}}') {
                    let content = event.detail.content;
                    if (content) {
                        // Convert newlines to HTML breaks to preserve line breaks
                        content = content.replace(/\n/g, '<br>');
                    }
                    editor.setData(content);
                    $wire.set('{{$wirePrefix . $field}}', editor.getData());
                }
            });

            // Register with unsaved changes detection
            if (typeof window.UnsavedChanges !== 'undefined') {
                window.UnsavedChanges.registerCKEditor('{{$id}}', editor);
            }

            // Move slot content to toolbar
            const toolbar = editor.ui.view.toolbar.element;
            const slotContent = document.getElementById('{{$slotId}}');
            if (slotContent && toolbar) {
                slotContent.classList.remove('d-none');
                // Append to toolbar items container
                const items = toolbar.querySelector('.ck-toolbar__items');
                if (items) {
                     items.appendChild(slotContent);
                } else {
                     toolbar.appendChild(slotContent);
                }

                // Fix styles for the button inside toolbar
                const floatEnd = slotContent.querySelector('.float-end');
                if (floatEnd) {
                    floatEnd.classList.remove('float-end');
                    floatEnd.classList.add('d-inline-block');
                }

                // Style the wrapper to handle dropdown positioning
                const xDataRoot = slotContent.querySelector('[x-data]');
                if (xDataRoot) {
                    xDataRoot.style.position = 'relative';
                    xDataRoot.style.display = 'inline-block';

                    // Find the collapsible content and style it as a dropdown
                    const collapseContent = xDataRoot.querySelector('[x-show]');
                    if (collapseContent) {
                        collapseContent.style.position = 'absolute';
                        collapseContent.style.top = '100%';
                        collapseContent.style.right = '0';
                        collapseContent.style.zIndex = '1000';
                        collapseContent.style.background = 'white';
                        collapseContent.style.border = '1px solid #ccc';
                        collapseContent.style.padding = '10px';
                        collapseContent.style.borderRadius = '4px';
                        collapseContent.style.boxShadow = '0 2px 5px rgba(0,0,0,0.2)';
                        collapseContent.style.minWidth = '300px';
                    }
                }
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
