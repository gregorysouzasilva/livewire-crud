<div>
    <!--begin::Demos drawer-->
    <div
        id="drawer-assessment"
        class="bg-body drawer drawer-end drawer-on" style="width:30%">
    
        <!--begin::Card-->
        <div class="card shadow-none rounded-0 w-100">
            <!--begin::Header-->
            <div class="card-header" id="kt_engage_demos_header">
                <h3 class="card-title fw-bolder text-gray-700">@lang($title)</h3>
    
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-icon btn-active-color-primary h-40px w-40px me-n6" id="kt_engage_demos_close">
                        {!! theme()->getSvgIcon("icons/duotune/arrows/arr061.svg", "svg-icon-2") !!}
                    </button>
                </div>
            </div>
            <!--end::Header-->
    
            <!--begin::Body-->
            <div class="card-body" id="kt_engage_demos_body">
                <!--begin::Content-->
                <div
                    id="kt_explore_scroll"
                    class="scroll-y me-n5 pe-5"
                    data-kt-scroll="true"
                    data-kt-scroll-height="auto"
                    data-kt-scroll-wrappers="#kt_engage_demos_body"
                    data-kt-scroll-dependencies="#kt_engage_demos_header"
                    data-kt-scroll-offset="5px">
    
                    {{$slot}}
                </div>
                <!--end::Content-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Demos drawer-->
    
    
    
    <!--begin::Engage toolbar-->
    <div class="engage-toolbar d-flex position-fixed px-5 fw-bolder zindex-2 top-50 end-0 transform-90 mt-20 gap-2">
        {{ theme()->getView('partials/engage/demos/__toggle') }}
    </div>
    <!--end::Engage toolbar-->
    
    </div>