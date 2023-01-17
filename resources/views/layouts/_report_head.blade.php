<head>
    <meta charset="utf-8"/>
    <title>{{ ucfirst(theme()->getOption('meta', 'title')) }} | Canada Immigration</title>
    <meta name="description" content="{{ ucfirst(theme()->getOption('meta', 'description')) }}"/>
    <meta name="keywords" content="{{ theme()->getOption('meta', 'keywords') }}"/>
    <link rel="canonical" href="{{ ucfirst(theme()->getOption('meta', 'canonical')) }}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="shortcut icon" href="{{ asset(theme()->getDemo() . '/' .theme()->getOption('assets', 'favicon')) }}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Alpine Plugins -->
    <script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- begin::Fonts --}}
    {{ theme()->includeFonts() }}
    {{-- end::Fonts --}}
    @if(!empty($media) && $media =='pdf')
        <style>
            body {
                background-color: #F5F8FA;
            }
            body {
                display: flex;
                flex-direction: column;
                color: #181C32;
                height: 100%;
                margin: 0px;
                padding: 0px;
                font-size: 13px !important;
                font-weight: 400;
                font-family: Poppins, Helvetica, "sans-serif";
            }
.print-content-only {
    padding: 0 !important;
    background: none !important;
}

.flex-root {
    flex: 1;
}

.flex-column {
    flex-direction: column !important;
}
.d-flex {
    display: flex !important;
}

.flex-column-fluid {
    flex: 1 0 auto;
}
.flex-row {
    flex-direction: row !important;
}
.flex-row-fluid {
    flex: 1 auto;
    min-width: 0;
}
.flex-column {
    flex-direction: column !important;
}

.flex-xl-row {
    flex-direction: row !important;
}

.content {
    padding: 5px 0;
}

.container-xxl {
    padding: 0 5px;
    width: 735px;
}

.card {
    border: 0;
    box-shadow: 0px 0px 20px 0px rgb(76 87 125 / 2%);
    width: 805px;
}
.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #ffffff;
    background-clip: border-box;
    border: 1px solid #EFF2F5;
    border-radius: 0.475rem;
    box-shadow: 0px 0px 20px 0px rgb(76 87 125 / 2%);
}

.card .card-body {
    padding: 2rem 2.25rem;
}

/* .p-lg-20 {
    padding: 5rem !important;
} */
.card-body {
    flex: full;
    padding: 1rem 1rem;
}

.flex-lg-row-fluid {
    flex: 1 auto;
    min-width: 0;
}
.mb-xl-0 {
    margin-bottom: 0 !important;
}
.me-xl-18 {
    margin-right: 4.5rem !important;
}
.mb-10 {
    margin-bottom: 2.5rem !important;
}
.mt-n1 {
    margin-top: -0.25rem !important;
}
.flex-stack {
    justify-content: space-between;
    align-items: center;
}
.pb-10 {
    padding-bottom: 2.5rem !important;
}

a {
    transition: color 0.2s ease, background-color 0.2s ease;
}
a {
    color: #009EF7;
    text-decoration: none;
}

img, svg {
    vertical-align: middle;
}

h1, .h1 {
    font-size: 20px;
}

.text-gray-800 {
    color: #3F4254 !important;
}

.fw-bolder {
    font-weight: 600 !important;
}
.fs-3 {
    font-size: 14px !important;
}
.mb-2 {
    margin-bottom: 0.5rem !important;
}
.mt-5 {
    margin-top: 1.25rem !important;
}

.m-0 {
    margin: 0 !important;
    width: 650px;
}

.mb-12 {
    margin-bottom: 3rem !important;
}
.g-5, .gy-5 {
    --bs-gutter-y: 1.25rem;
}
.g-5, .gx-5 {
    --bs-gutter-x: 1.25rem;
}
.row {
    display: flex;
    flex-wrap: wrap;
    margin-top: calc(-1 * var(0));
    margin-right: calc(-.5 * var(1.5rem));
    margin-left: calc(-.5 * var(1.5rem));
}

.col-sm-6 {
    flex: 0 0 auto;
    width: 50%;
}

.flex-grow-1 {
    flex-grow: 1 !important;
}

.mb-9 {
    margin-bottom: 2.25rem !important;
}
.border-bottom {
    border-bottom: 1px solid #EFF2F5 !important;
}

.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.mb-3 {
    margin-bottom: 0.75rem !important;
}
.table {
    width: 100%;
    margin-bottom: 1rem;
    color: #181C32;
    vertical-align: top;
    border-color: #EFF2F5;
}

table {
    caption-side: bottom;
    border-collapse: collapse;
}

.text-muted {
    color: #A1A5B7 !important;
}

.fw-bolder {
    font-weight: 600 !important;
}

.justify-content-end {
    justify-content: flex-end !important;
}

        </style>
        {{-- <link href="file://{{base_path('public/demo6/css/style.bundle.css')}}" rel="stylesheet" type="text/css"/> --}}
    @else
    @if (theme()->hasOption('page', 'assets/vendors/css'))
        {{-- begin::Page Vendor Stylesheets(used by this page) --}}
        @foreach (array_unique(theme()->getOption('page', 'assets/vendors/css')) as $file)
            {!! preloadCss(assetCustom($file)) !!}
        @endforeach
        {{-- end::Page Vendor Stylesheets --}}
    @endif

    @if (theme()->hasOption('page', 'assets/custom/css'))
        {{-- begin::Page Custom Stylesheets(used by this page) --}}
        @foreach (array_unique(theme()->getOption('page', 'assets/custom/css')) as $file)
            {!! preloadCss(assetCustom($file)) !!}
        @endforeach
        {{-- end::Page Custom Stylesheets --}}
    @endif

    @if (theme()->hasOption('assets', 'css'))
        {{-- begin::Global Stylesheets Bundle(used by all pages) --}}
        @foreach (array_unique(theme()->getOption('assets', 'css')) as $file)
            @if (strpos($file, 'plugins') !== false)
                {!! preloadCss(assetCustom($file)) !!}
            @else
                <link href="{{ assetCustom($file) }}" rel="stylesheet" type="text/css"/>
            @endif
        @endforeach
        {{-- end::Global Stylesheets Bundle --}}
    @endif

    @if (theme()->getViewMode() === 'preview')
        {{ theme()->getView('partials/trackers/_ga-general') }}
        {{ theme()->getView('partials/trackers/_ga-tag-manager-for-head') }}
    @endif
    @endif

    @yield('styles')
</head>
{{-- end::Head --}}