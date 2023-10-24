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

    {{-- Add buttons that are not grouped in the table info --}}
    @foreach($pageInfo['table']['buttons'] ?? [] as $option)
        @php($option = (object)$option)
            @if($item->evalTags($option->show) &&
                (isset($option->grouped) && $option->grouped == false) &&
                (empty($option->role) || (auth()->user() && auth()->user()->hasRole($option->role))) )
            <!--begin::Menu item-->
                <a href="{{ $item->renderTags($option->url ?? '') }}" class="btn btn-sm btn-light btn-active-primary" target="{{ $option->target ?? '_self' }}" @if(!empty($option->action))wire:click="actionConfirm('{{$option->action}}','{{$item->getKey()}}', '{{$option->confirm ?? ''}}')"@endif wire:navigat>
                    <i class="{{$option->icon}}" style="padding-right: 8px" title="@lang($option->label)"></i> 
                </a>
        @endif
    @endforeach

    <x-button.group-options :options="$pageInfo['table']['buttons'] ?? []" icon="bi bi-list" label="" :item="$item" />
</div>