<div class="row g-5 g-xl-8">
    <div class="card">
        <div class="card-body">
        <h2>{{ $pageInfo['title'] }}</h2>
        {{-- <div class="text-gray-400 fw-bold fs-4">
            <p> {!! $relation->label !!} </p>
        </div> --}}
        <!--begin::Col-->
        <div class="col-xl-12">
            <!--begin::Feeds Widget 1-->
            <div class="card mb-5 mb-xl-8">
                <!--begin::Body-->
                <div class="card-body pb-0">
                    <!--begin::Header-->
                    <div class="d-flex align-items-center">
                        <!--begin::User-->
                        <div class="d-flex align-items-center flex-grow-1">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-45px me-5">
                                <img src="{{ auth()->user()->avatar_url ?? asset(theme()->getMediaUrlPath() . 'avatars/blank.png') }}"
                                    alt="">
                            </div>
                            <!--end::Avatar-->
                            <!--begin::Info-->
                            <div class="d-flex flex-column">
                                <a href="#"
                                    class="text-gray-900 text-hover-primary fs-6 fw-bold">{{ auth()->user()->name ?? 'Client' }}</a>
                                <span class="text-gray-400 fw-bold">{{ auth()->user()->email ?? 'Not logged' }}</span>
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::User-->
                    </div>
                    <!--end::Header-->
                    <form>
                        <div class="row" wire:key="{{$memoKey}}">
                            <x-form.group-editor label="" field="comment" type="memoeditor" width="12"
                                required=true wirePrefix="model." :value="$model['comment'] ?? ''" />
                        </div>
                    </form>
                    <div class="modal-footer">
                        @if(!$condensed)
                            <button type="button" class="btn btn-light"
                                wire:click="showForm(false)">@lang('Cancel')</button>
                        @endif
                        <button type="button" class="btn btn-primary"
                            wire:click.prevent="store()">@lang('Save')</button>
                    </div>
                </div>
                <!--end::Body-->
            </div>
            <!--end::Feeds Widget 1-->
        </div>
        </div>
    </div>
