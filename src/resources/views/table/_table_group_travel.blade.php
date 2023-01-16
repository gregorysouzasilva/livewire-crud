@if (!empty($pageInfo['table']['group_travel']) && !empty($lastEndDate))
{{-- && Carbon\Carbon::parse($lastEndDate)->diffInDays(Carbon\Carbon::parse($item->start_date)) > 1 --}}
<tbody>
<tr>
    <td colspan="10%" class="text-center">
        ...
    </td>
</tr>
</tbody>
@endif
@php
$lastEndDate = $item->end_date ?? null;
@endphp