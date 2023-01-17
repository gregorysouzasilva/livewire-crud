@if(!empty($pageInfo['shortcuts']) && empty($condensed))
    <x-button.shortcut-pages :pages="$pageInfo['shortcuts']" icon="bi bi-list" label="Shortcuts" />
@endif
@php
$hideCreateButton = $hideCreateButton ?? false;
@endphp
@if(($pageInfo['permissions']['complete'] ?? false) && $contact->getCurrentStateRelation(class_basename($this->model))->status != 'completed')
<button type="button" wire:click="confirmComplete('{{class_basename($this->model)}}')"
    class="btn btn-light-danger me-3">
    <i class="bi bi-lock-fill"></i>Complete
</button>
@elseif(($pageInfo['permissions']['complete'] ?? false) && $contact->getCurrentStateRelation(class_basename($this->model))->status == 'completed')
<button type="button" wire:click="confirmReopen('{{class_basename($this->model)}}')"
    class="btn btn-light-danger me-3">
    <i class="bi bi-unlock-fill"></i>Reopen
</button>
@endif
<!--begin::Add -->
@if($pageInfo['permissions']['create'] && !$hideCreateButton)
<x-button.create/>
@endif
<!--end::Add -->