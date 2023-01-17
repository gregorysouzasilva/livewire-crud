
<div id="laravel-livewire-modals" tabindex="-1"
    data-bs-backdrop="static" data-bs-keyboard="false"
    wire:ignore.self class="modal fade show" style="display:block">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang($title)</h5>
                <button type="button" class="btn-close" wire:click="closeModalPopover()" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>