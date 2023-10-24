@if(!empty($options) && !empty($item->getKey()))
@php
$size = $size ?? 'sm';
@endphp
    <div x-data="{ open: false }" style="display:inline">
        <button class="btn btn-{{$size}} btn-light btn-active-primary me-3"
            @click="open = true">
            <span class="svg-icon svg-icon-5 rotate-180"><i class="{{$icon}}"></i></span>@lang($label)
        </button>

        <div class="menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-200px py-4 show"
            x-show="open" @click.outside="open = false" style="position: absolute;right:-40px; display:block" x-cloak >
            @foreach($options as $option)
            @php($option = (object)$option)
            @if($item->evalTags($option->show) && 
                (!isset($option->grouped) || $option->grouped == true) &&
                (empty($option->role) || (auth()->user() && auth()->user()->hasRole($option->role))))
                <div class="menu-item px-3">
                    <a href="{{ $item->renderTags($option->url ?? '') }}" class="menu-link px-3" target="{{ $option->target ?? '_self' }}" @if(!empty($option->action))wire:click="actionConfirm('{{$option->action}}','{{$item->getKey()}}', '{{$option->confirm ?? ''}}')"@endif wire:navigat>
                        <i class="{{$option->icon}}" style="padding-right: 8px"></i> @lang($option->label)
                    </a>
                </div>
            @endif
            @endforeach
        </div>
    </div>
@endif