<div class="card-header border-0 p-3">
    <div>
        <span class="text-muted fw-semibold fs-7">@lang($pageInfo['description'] ?? '')</span>
        @if(!empty($pageInfo['table']['search_fields']) && empty($condensed))
            @include('livewire.table.' . '_table_search')
        @else
            {{-- <h3>@lang($pageInfo['title'])</h3> --}}
        @endif
    </div>

    <!--begin::Card title-->
    <!--begin::Card toolbar-->
    <div class="card-toolbar">
        <!--begin::Toolbar-->
        <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base" x-data="{}" x-init="KTMenu.createInstances();">
           @if(($pageInfo['table']['filters'] ?? true) == false || !empty($condensed))

            @else
                @include('livewire.table.' . '_table_filter')
                {{-- @include('livewire.table.' . '_table_export') --}}
            @endif
            @include('livewire.table.' . '_table_buttons_top')
        </div>
        <!--end::Toolbar-->
        <!--begin::Group actions-->
        <div class="d-flex justify-content-end align-items-center d-none" data-kt-customer-table-toolbar="selected">
            <div class="fw-bolder me-5">
            <span class="me-2" data-kt-customer-table-select="selected_count"></span>Selected</div>
            <button type="button" class="btn btn-danger" data-kt-customer-table-select="delete_selected">Delete Selected</button>
        </div>
        <!--end::Group actions-->
    </div>
    <!--end::Card toolbar-->
</div>