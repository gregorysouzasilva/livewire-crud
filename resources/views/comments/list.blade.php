@foreach($collection as $item)
<div class="card" wire:key="C{{$item->getKey()}}">
<div class="card-body pb-0">
    <!--begin::Header-->
    <div class="d-flex align-items-center mb-3">
        <!--begin::User-->
        <div class="d-flex align-items-center flex-grow-1">
            <!--begin::Avatar-->
            <div class="symbol symbol-45px me-5">
                <img src="{{$item->user->avatar_url ?? asset(theme()->getMediaUrlPath() . 'avatars/blank.png')}}" alt="">
            </div>
            <!--end::Avatar-->
            <!--begin::Info-->
            <div class="d-flex flex-column">
                <a href="#" class="text-gray-900 text-hover-primary fs-6 fw-bold">{{$item->user->name ?? 'Client'}}</a>
                <span class="text-gray-400 fw-bold">{{$item->created_at->timezone('America/Vancouver')->format('d M,Y h:i')}} (PT)</span>
            </div>
            <!--end::Info-->
        </div>
        <!--end::User-->
        <!--begin::Menu-->
        @if($allowDone)
            <div class="my-0">
                @if(!$item->is_done)
                <button class="btn btn-success btn-sm " wire:click="onDone({{$item->getKey()}})">
                    <i class="fas fa-check"></i> Mark as Done
                </button>
                @else
                <button class="btn btn-danger btn-sm " wire:click="onDone({{$item->getKey()}})">
                    <i class="fas fa-times"></i> Mark as Undone
                </button>
                @endif
            </div>
        @endif
        <!--end::Menu-->
    </div>
    <!--end::Header-->
    <!--begin::Post-->
    <div class="mb-7">
        <!--begin::Text-->
        <div class="text-gray-800 mb-5">{!! $item->comment !!}</div>
        <!--end::Text-->
        
    </div>
    <!--end::Post-->
    @if($allowReply)
        <!--begin::Replies-->
        @include($viewPath . '_replies')
        <!--end::Replies-->
        
        <!--begin::Separator-->
        @if(!$item->is_done)
            @include($viewPath . '_reply')
        @endif
    @endif
    <!--edit::Reply input-->
</div>
</div>
@endforeach