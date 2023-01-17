@php
// color secondary for status open
// color warning for status pending, sent, 
// color success for status paid, received, deposited,
// color primary for status confirmed, completed
// color danger for status cancelled, declined, voided, rejected, failed, error

$color = 'secondary';
$status = $slot;
switch ($status) {
    case 'open':
    case 'low':
        $color = 'secondary';
        break;
    case 'pending':
    case 'sent':
    case 'medium':
        $color = 'warning';
        break;
    case 'paid':
    case 'received':
    case 'deposited':
        $color = 'success';
        break;
    case 'confirmed':
    case 'completed':
        $color = 'primary';
        break;
    case 'cancelled':
    case 'declined':
    case 'voided':
    case 'rejected':
    case 'failed':
    case 'error':
    case 'high':
    case 'on hold':
        $color = 'danger';
        break;
}
@endphp
<span class="badge badge-{{$color}}">
{{ strtoupper($slot) }}
</span>