<div class="btn-group" role="group" aria-label="group">
    @if($item->evalTags($pageInfo['permissions']['edit'] ?? true))
        <x-button.edit :id="$item->getKey()"/>
    @endif
    @if($item->evalTags($pageInfo['permissions']['duplicate'] ?? true) && !empty($model->getFillable()))
        <x-button.duplicate :id="$item->getKey()"/>
    @endif
    @if($item->evalTags($pageInfo['permissions']['delete'] ?? true))
        <x-button.delete :id="$item->getKey()"/>
    @endif
    <x-button.group-options :options="$pageInfo['table']['buttons'] ?? []" icon="bi bi-list" label="" :item="$item" />
</div>