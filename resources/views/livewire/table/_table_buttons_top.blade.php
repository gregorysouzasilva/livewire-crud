@if (!empty($pageInfo['shortcuts']) && empty($condensed))
    <x-button.shortcut-pages :pages="$pageInfo['shortcuts']" icon="bi bi-list" label="Shortcuts" />
@endif
@php
    $hideCreateButton = $hideCreateButton ?? false;
@endphp
@if (
    ($pageInfo['permissions']['complete'] ?? false) &&
        !in_array($contact->getCurrentStateRelation(class_basename($this->model))->status ?? null, [
            'completed',
            'dismissed',
        ]))
    <button type="button" wire:click="confirmComplete('{{ class_basename($this->model) }}')"
        class="btn btn-light-danger me-3">
        <i class="bi bi-lock-fill"></i>@lang('Complete')
    </button>
    @if (hasRole('consultant'))
        <button type="button" wire:click="onPageDismiss('{{ class_basename($this->model) }}')"
            class="btn btn-light-danger me-3">
            <i class="bi bi-lock-fill"></i>@lang('Dismiss')
        </button>
    @endif
    
@elseif(
    ($pageInfo['permissions']['complete'] ?? false) &&
        in_array($contact->getCurrentStateRelation(class_basename($this->model))->status ?? null, [
            'completed',
            'dismissed',
        ]))
    <button type="button" wire:click="confirmReopen('{{ class_basename($this->model) }}')"
        class="btn btn-light-danger me-3">
        <i class="bi bi-unlock-fill"></i>@lang('Reopen')
        {{ $contact->getCurrentStateRelation(class_basename($this->model))->status }}
    </button>
@endif
@if ($pageInfo['permissions']['print'] ?? false && !empty($pageInfo['print_link'] ?? false))
    <a href="{{$pageInfo['print_link']}}" class="btn btn-light me-3" target="_blank">
        <i class="bi bi-printer"></i>Print
    </a>
@endif
<!--begin::Add -->
@if ($pageInfo['permissions']['create'] && !$hideCreateButton)
    <x-button.create />
@endif
<!--end::Add -->
