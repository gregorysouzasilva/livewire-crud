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
    <button type="button" wire:click="onPageComplete('{{ class_basename($this->model) }}')"
        wire:confirm="Are you sure you want to complete? Complete action will block {{ class_basename($this->model) }} from further editing for this person."
        wire:attr.disabled="$livewire.isLoading"
        class="btn btn-light-danger me-3">
        <i class="bi bi-lock-fill"></i>@lang('Complete')
    </button>
    @if (hasRole('consultant'))
        <button type="button" wire:click="onPageDismiss('{{ class_basename($this->model) }}')"
            wire:attr.disabled="$livewire.isLoading"
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
    <button type="button" wire:click="onPageReopen('{{ class_basename($this->model) }}')"
        wire:confirm="Are you sure you want to reopen? Reopen will unlock {{ class_basename($this->model) }} for client users editing for this person."
        wire:attr.disabled="$livewire.isLoading"
        class="btn btn-light-danger me-3">
        <i class="bi bi-unlock-fill"></i>@lang('Reopen')
        {{ $contact->getCurrentStateRelation(class_basename($this->model))->status }}
    </button>
@endif
{{-- Add button to AI Validation using wire:click --}}
@if ($pageInfo['permissions']['validate_ai'] ?? false)
    <button type="button" wire:click="validateAI"
        wire:attr.disabled="$livewire.isLoading"
        class="btn btn-light-success me-3">
        <i class="bi bi-check-circle"></i>@lang('Validate AI')
    </button>
@endif

@if ($pageInfo['permissions']['print'] ?? false && !empty($pageInfo['print_link'] ?? false))
    <a href="{{$pageInfo['print_url'] ?? ''}}" class="btn btn-light me-3" target="_blank">
        <i class="bi bi-printer"></i>Print
    </a>
@endif
@if ($pageInfo['permissions']['export'] ?? false && !empty($pageInfo['export_link'] ?? false))
    <a href="{{$pageInfo['export_url'] ?? ''}}" class="btn btn-light me-3" target="_blank">
        <i class="bi bi-file-earmark-excel-fill"></i>Export
    </a>
@endif
{{-- Custom top buttons --}}
@foreach($pageInfo['top_buttons'] ?? [] as $button)
    @php
        $button = (object) $button;
        $buttonCanShow = ($button->show ?? true)
            && (empty($button->role) || (auth()->user() && auth()->user()->hasRole($button->role)));
    @endphp

    @if($buttonCanShow)
        @if(!empty($button->action))
            <button
                type="button"
                wire:click="{{ $button->action }}"
                class="btn {{ $button->class ?? 'btn-light' }} me-3"
                @if(!empty($button->confirm))
                    wire:confirm="{{ $button->confirm }}"
                @endif
                @if(!empty($button->loading_target))
                    wire:loading.attr="disabled"
                    wire:target="{{ $button->loading_target }}"
                @endif
                @if(!empty($button->disabled) || !empty($button->loading_when))
                    disabled
                @endif
            >
                @if(!empty($button->loading_when))
                    @if(!empty($button->loading_icon))
                        <i class="{{ $button->loading_icon }}"></i>
                    @endif
                    @lang($button->loading_label ?? ($button->label ?? ''))
                @elseif(!empty($button->loading_target))
                    <span wire:loading.remove wire:target="{{ $button->loading_target }}">
                        @if(!empty($button->icon))
                            <i class="{{ $button->icon }}"></i>
                        @endif
                        @lang($button->label ?? '')
                    </span>
                    <span wire:loading wire:target="{{ $button->loading_target }}" style="display:none">
                        @if(!empty($button->loading_icon))
                            <i class="{{ $button->loading_icon }}"></i>
                        @endif
                        @lang($button->loading_text ?? ($button->label ?? ''))
                    </span>
                @else
                    @if(!empty($button->icon))
                        <i class="{{ $button->icon }}"></i>
                    @endif
                    @lang($button->label ?? '')
                @endif
            </button>
        @else
            <a
                href="{{ $button->url ?? '#' }}"
                class="btn {{ $button->class ?? 'btn-light' }} me-3"
                target="{{ $button->target ?? '_self' }}"
            >
                @if(!empty($button->icon))
                    <i class="{{ $button->icon }}"></i>
                @endif
                @lang($button->label ?? '')
            </a>
        @endif
    @endif
@endforeach
<!--begin::Add -->
@if ($pageInfo['permissions']['create'] && !$hideCreateButton)
    <x-button.create />
@endif
<!--end::Add -->
