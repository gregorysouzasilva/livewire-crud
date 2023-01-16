@props(['id'])
<button wire:click="deleteConfirm('{{ $id }}')"
    class="btn btn-sm btn-light btn-active-danger">
    <i class="bi bi-x"></i>
</button>

