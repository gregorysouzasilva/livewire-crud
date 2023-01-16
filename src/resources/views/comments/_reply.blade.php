<div wire:key="{{$item->getKey()}}CR">
<div class="separator mb-4"></div>
    <!--end::Separator-->
    <!--begin::Reply input-->
    <form class="position-relative mb-6">
        <textarea class="form-control border-0 p-0 pe-10 resize-none min-h-25px" rows="3" 
            placeholder="Reply.." data-kt-initialized="1" style="overflow: hidden; overflow-wrap: break-word;" wire:model="replies.{{$item->getKey()}}.comment">
        </textarea>
        <div class="position-absolute top-0 end-0 me-n5">
            <button type="button" class="btn btn-icon btn-active-light-primary" wire:click="saveReply({{$item->getKey()}})">
                <span class="svg-icon svg-icon-2">
                    <!--begin::Svg Icon | path: icons/duotone/Communication/Send.svg-->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24"></rect>
                            <path d="M2.99987709,21.0000002 L21.9998771,12.0000002 L2.99987709,3.00000024" fill="#000000" fill-rule="nonzero" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>
            </button>
        </div>
    </form>
</div>