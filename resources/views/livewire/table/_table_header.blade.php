<thead>
    <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
        @if($tableInfo->hasHidden())
            <th style="width: 75px"></th>
        @endif
        @foreach($tableInfo as $field)
            @if(isset($field->visible) && !$field->visible)
                @continue
            @endif
            <th style="text-align: {{$field->alignment ?? 'left'}}"><a @if($field->order)wire:click.prevent="sortBy('{{($field->prefix ?? '') .  ($field->sortField ?? $field->field)}}')" style="cursor:pointer" @endif>@lang($field->label)
            @if($sortField == $field->field || $sortField == ($field->prefix ?? '') . $field->field)
                @if($sortDirection == 'asc')
                    <i class="fas fa-sort-up"></i>
                @else
                    <i class="fas fa-sort-down"></i>
                @endif
            @endif
            </th>
        @endforeach
        <th class="col-1">@lang('Actions')</th>
    </tr>
</thead>