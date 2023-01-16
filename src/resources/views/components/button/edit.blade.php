@props(['id'])
<button wire:click="edit('{{ $id }}')"
    class="btn btn-sm btn-light btn-active-primary">
    <i class="bi bi-pencil"></i>
</button>

