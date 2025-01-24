<div class="modal-footer">
    {{-- left --}}
    <div>
        @if($item->evalTags($pageInfo['permissions']['delete'] ?? true) && !empty($item->getKey()))
            <button type="button" class="btn btn-danger" wire:confirm="Are you sure you want to delete this item?" wire:click="onDelete('{{ $item->getKey() }}')""><i class="bi bi-x"></i> @lang('Delete')</button>
        @endif
    </div>
    {{-- right --}}
    <div>
        {{ $slot}}
        <button type="button" class="btn btn-light" wire:click="onShowForm(false)" ><i class="bi bi-x"></i> @lang('Cancel')</button>
        <x-button.group-options :options="$pageInfo['table']['buttons'] ?? []" icon="bi bi-list" label="" :item="$item" size="" />
        <button type="button" class="btn btn-primary" wire:click="store()" wire:loading.attr="disabled"><i class="bi bi-check"></i> @lang('Save')</button>
    </div>
</div>