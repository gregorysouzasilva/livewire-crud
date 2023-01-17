
<div class="mb-7">
    @foreach($item->replies as $reply)
    <!--begin::Reply-->
    <div class="d-flex mb-5" wire:key="{{$reply->getKey()}}R">
        <!--begin::Avatar-->
        <div class="symbol symbol-45px me-5">
            <img src="{{$reply->user->avatar_url ?? asset(theme()->getMediaUrlPath() . 'avatars/blank.png')}}" alt="">
        </div>
        <!--end::Avatar-->
        <!--begin::Info-->
        <div class="d-flex flex-column flex-row-fluid">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mb-1">
                <a href="#" class="text-gray-800 text-hover-primary fw-bold me-2">{{$reply->user->name ?? 'Client'}}</a>
                <span class="text-gray-400 fw-semibold fs-7">{{$reply->created_at->timezone('America/Vancouver')->format('d M,Y h:i')}} (PT)</span>
            </div>
            <!--end::Info-->
            <!--begin::Post-->
            <span class="text-gray-800 fs-7 fw-normal pt-1">{!! nl2br($reply->comment) !!}</span>
            <!--end::Post-->
        </div>
        <!--end::Info-->
    </div>
    <!--end::Reply-->
    @endforeach
</div>