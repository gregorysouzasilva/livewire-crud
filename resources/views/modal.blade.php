<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Modal title</h5>
            <button type="button" class="btn-close" wire:click="$emit('hideModal') aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p>Modal body text goes here.</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" wire:click="$emit('hideModal')">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
        </div>
    </div>
</div>

<x-modal title="Create Comment">
    {{-- @include($viewPath . 'create') --}}
</x-modal>