@foreach($collection as $item)
    {{-- @include('crud::livewire.table._table_group_travel') --}}
   
    <tbody x-data="{ expanded: false }" wire:key="line-{{$item->getKey()}}" wire:poll.50s>
        <tr>
            @if(!empty($tableInfo->hasHidden()))
                <td><x-button.expand/></td>
            @endif
            @foreach($tableInfo as $field)
                @if(!$field->visible)
                    @continue
                @endif
                <td style="text-align: {{$field->alignment ?? 'left'}}" class="d-md-table-cell @if($field->hide_mobile ?? false) d-none @else d-block @endif">
                    @include('crud::livewire.table._table_cell_types')
                </td>
            @endforeach
            <td 
                @if(!empty($item->created_at)) title="{{Carbon\Carbon::parse($item->created_at, 'UTC')->setTimezone('America/Vancouver');}} ({{$item->getKey()}})" @endif>
                @include('crud::livewire.table.' . '_table_buttons')
            </td>

        
        @if(!empty($tableInfo->hasHidden()))
        <tr x-show="expanded" x-collapse wire:key="line-expand-{{$item->getKey()}}" x-cloak>
            <td colspan="100%">
            @foreach($tableInfo->getHidden() as $field)
                @if(empty($item->{$field->field}))
                    @continue
                @endif
                <b>{{$field->label}}: </b>
                @include('crud::livewire.table._table_cell_types')
                <br>
            @endforeach
            </td>
        </tr>


        @endif
    </tbody>
    @endforeach

    @if($collection->isEmpty())
    <tbody>
        <tr>
            <td colspan="100%" class="text-center">
                <i class="bi bi-exclamation-triangle"></i> @lang('No records found.')
                @if($pageInfo['permissions']['create'])
                    <br> @lang('Click on the Create button to create a new record.')
                @endif
            </td>
        </tr>
    </tbody>
    @endif