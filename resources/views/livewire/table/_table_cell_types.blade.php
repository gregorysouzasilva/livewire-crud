@if($field->type == 'DATE' && !empty($item->{$field->field}))
    {{$item->{$field->field}->format('d/m/Y')}}

@elseif($field->type == 'date_time' && !empty($item->{$field->field}))
    {{$item->{$field->field}->timezone('America/Vancouver')->format('d/m/Y H:i')}}

@elseif($field->type == 'currency' && !empty($item->{$field->field}))
    {{ money_format("%i", $item->{$field->field})}}

@elseif($field->type == 'gravatar' && !empty($item->{$field->field}))
    <img src="{{'http://www.gravatar.com/avatar/' . md5($item->{$field->field})}}?size=50">   

@elseif($field->type == 'comment' && !empty($item->{$field->field}))
    {!! $item->{$field->field} !!} ...

@elseif($field->type == 'boolean')
    @if($item->{$field->field})<i class="bi bi-check-circle fs-2" style="color:green"></i>@else <i class="bi bi-x-circle fs-2" style="color:red"></i>@endif      

@elseif($field->type == 'status')
    @if($item->{$field->field})
    <x-badge-status>{{$item->{$field->field} }}</x-badge-status>
    @endif

@elseif($field->type == 'email') 
    <a href="https://mail.google.com/mail/u/?authuser={{env('MAIL_ADMIN_ADDRESS')}}#search/ {{$item->{$field->field} }}" target="_blank">{{$item->{$field->field} }}</a>

@elseif($field->type == 'phone')
    @php
        $phoneNumber = preg_replace('/\D+/', '', $item->{$field->field});
        if (!Str::startsWith($phoneNumber, '1') && !Str::startsWith($phoneNumber, '55')) {
            if (Str::length($phoneNumber) == 10) {
                $phoneNumber = '1' . $phoneNumber;
            } else {
                $phoneNumber = '55' . $phoneNumber;
            }
        }
    @endphp
    <a href="https://wa.me/{{$phoneNumber}}">{{$item->{$field->field} }}</a>
@elseif($field->type == 'audio')
    <video>
        <source src="{{$item->full_path }}" type="video/mp4">
    </video>
@elseif($field->type == 'view')
    @include($field->view)
@elseif($field->type == 'client' && !empty($item->client) && !empty($item->client->uuid))
    <a href="{{ route('clients.index', ['client_uuid' => $item->client->uuid] ) }}" class="dashboard"> {{$item->{$field->field} }} </a>

@else
    {{$item->{$field->field} }}
@endif