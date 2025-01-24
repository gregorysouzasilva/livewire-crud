@props(['id'])
<button wire:click="onDelete('{{ $id }}')" wire:confirm="Are you sure you want to delete this item?"
    class="btn btn-sm btn-light btn-active-danger">
    <i class="bi bi-x"></i>
</button>

