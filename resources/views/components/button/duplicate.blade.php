@props(['id'])
<button wire:click="duplicate('{{ $id }}')"
    class="btn btn-sm btn-light btn-active-primary">
    <i class="bi bi-files"></i>
</button>

