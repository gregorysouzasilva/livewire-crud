<div>
<!--begin::Trigger-->
<button type="button" class="btn btn-light btn-active-primary me-3"
    data-kt-menu-trigger="click"
    data-kt-menu-placement="bottom-start">
    <span class="svg-icon svg-icon-5 rotate-180"><i class="{{$icon}}"></i></span>@lang($label)
</button>
<!--end::Trigger-->

<!--begin::Menu-->
<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-200px py-4"
    data-kt-menu="true">
    @foreach($pages as $option)
    @php($option = (object) $option)
    <!--begin::Menu item-->
    <div class="menu-item px-3">
        <a href="{{ $option->url}}" target='_blank' class="menu-link px-3">
            <i class="{{$option->icon}}"></i> @lang($option->name)
        </a>
    </div>
    <!--end::Menu item-->
    @endforeach

    
</div>
<!--end::Menu-->
</div>