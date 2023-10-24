@if(($service->serviceType->histories[$serviceTypeHistory] ?? false) && (!in_array($contact->getCurrentStateRelation($stateRelation)->status, ['dismissed']) || hasRole('consultant')))
    <a href="{{route('clients.contacts.' . $routeName, ['client_uuid' => $client->uuid, 'contact_uuid' => $contact->uuid])}}" class="btn btn-light p-2 position-relative m-2" style="min-width: 50px;" wire:navigat>
        <i class="bi {{$icon}}"></i> <br>
        @lang($label) 
        <x-badge color="{{$contact->getRelationColor($stateRelation)}}" position='top' showZero=true>{{$contact->{$contactRelation}->count()}}</x-badge>
    </a>
@endif