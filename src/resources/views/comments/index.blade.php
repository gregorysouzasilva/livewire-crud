
    <div>
        <script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>

        @if($isModalOpen)
            <x-crud::modal title="Create Comment">
                @include($viewPath . $modal)
            </x-crud::modal>
        @endif
        <!--begin::Card-->
        <div class="w-80 rounded p-10 p-lg-10 mx-auto">
            @include($viewPath . 'create')
            @include($viewPath . 'list')
            @if(!empty($relation->checklist_uuid))
            <a href="{{route('checklist-answer', ['uuid' => $relation->checklist_uuid])}}" class="btn btn-secondary">@lang("Go back to checklist")</a>
            @endif
        </div>
        <!--end::Card-->
    </div>