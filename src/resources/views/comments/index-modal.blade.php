
    <div>
        @if($isModalOpen)
        <x-crud::modal title="Create Comment">
        <script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>


               
        <!--begin::Card-->
        <div class="w-80 rounded p-10 p-lg-15 mx-auto" style="max-width: 1050px;">
            @include($viewPath . 'create')
            @include($viewPath . 'list')
        </div>
        <!--end::Card-->
        @include($viewPath . $modal)
    </x-crud::modal>
    @endif
    </div>