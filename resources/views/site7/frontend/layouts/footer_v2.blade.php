<div class="bg-white position-fixed bottom-0 right-0 left-0 w-100 p-2 border-top border-2 d-lg-none " style="z-index: 1080;">
    <div class="d-flex align-items-center justify-content-between">
        <a href="" class="d-flex flex-column align-items-center justify-content-center fs-xs text-dark opacity-75">
           <img src="/img/site7/logo.png" alt="logo" style="height:28px;">
        </a>
        <a href="" class="d-flex flex-column align-items-center justify-content-center fs-xs text-dark opacity-75">
            <i class="fs-4 fi-folder-plus"></i>
            <span class="/customer/add">{{ l('ثبت مشتری') }}</span>
        </a>
        <a href="" class="d-flex flex-column align-items-center justify-content-center fs-xs text-dark opacity-75">
            <i class="fs-4 fi-plus"></i>
            <span class="/add">{{ l('ثبت ملک') }}</span>
        </a>
        <a href="" class="d-flex flex-column align-items-center justify-content-center fs-xs text-dark opacity-75">
            <i class="fs-4 fi-heart"></i>
            <span class="">{{ l('مورد علاقه') }}</span>
        </a>

        <a href="" class="d-flex flex-column align-items-center justify-content-center fs-xs text-dark opacity-75" data-bs-toggle="modal" data-bs-target="#myAccount" aria-controls="myAccount">
            <i class="fs-4 fi-user"></i>
            <span class="">{{ l('حساب من') }}</span>
        </a>
    </div>
</div>
<!-- hh -->
<div class="modal fade" id="myAccount" tabindex="-1" aria-labelledby="myAccountLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="">
                    <div class="border-bottom">
                        <h2 class=" p-3 fs-base">
                            {{ l('کلبه من') }}
                        </h2>
                    </div>
                    <div class="border-bottom">
                        <div class="d-flex gap-3 p-3 align-items-baseline">
                            <i class="fi fi-user"></i>
                            <div>
                                <p class="mb-1">{{ l('کاربر کلبه') }}</p>
                                <span class="text-muted fs-sm">{{ !empty($currentUser) ? $currentUser->fullname() : '' }}</span>
                            </div>
                        </div>
                    </div>
                    @if(!empty($currentUser) &&  $currentUser->branch_id>0 && isset($currentUser->branch))
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs justify-content-center mb-0 my-3 pb-3 border-bottom" role="tablist">
                        <li class="nav-item">
                            <a href="#advertisements" class="nav-link active" data-bs-toggle="tab" role="tab">
                                {{ l('پنل املاک') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#about" class="nav-link" data-bs-toggle="tab" role="tab">
                                {{ l('حساب شخصی') }}
                            </a>
                        </li>
                    </ul>
                    @endif
                    <!-- Tabs content -->
                    <div class="tab-content">
                        @if(!empty($currentUser) &&  $currentUser->branch_id>0 && isset($currentUser->branch))
                        <div class="tab-pane fade {{(isset($menutype) && $menutype == 'branch')?'show active':'' }}" id="advertisements" role="tabpanel">
                            <div class="px-3 pt-3 mb-2 border-bottom ">
                                <div class="d-flex flex-column gap-2 pb-2">
                                    @if($currentUser->branch->coverImage() != '')
                                    <a href="/branch/{{$currentUser->branch_id}}" class="me-2">
                                        <img src="{{$currentUser->branch->coverImage()}}" style="height: 50px">
                                    </a>
                                    @endif
                                    <a href="/branch/{{$currentUser->branch_id}}">
                                        {{$currentUser->branch->name}}
                                    </a>
                                </div>
                            </div>
                            <div class="px-3">
                                <ul class="list-group list-group-flush ">
                                    <li class="list-group-item px-0 border-bottom-0">
                                        <a class="text-body" href="/profile/branch-estate-ads">
                                            <i class="fi fi-home"></i> {{l('لیست املاک')}}
                                        </a>
                                    </li>
                                    <li class="list-group-item px-0 border-bottom-0">
                                        <a class="text-body" href="/branchcustomer">
                                            <i class="fi fi-building"></i> {{l('لیست مشتریان')}}
                                        </a>
                                    </li>
                                    <li class="list-group-item px-0 border-bottom-0">
                                        <a href="/profile/report" class="text-body"> <i class="fi fi-house-chosen"></i>{{ l('آمار و مدیریت آگهی ها') }}</a>
                                    </li>
                                    <li class="list-group-item px-0 border-bottom-0">
                                        <a href="/profile/users" class="text-body"> <i class="fi fi-users"></i>{{ l('مدیریت مشاوران') }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @endif
                        <div class="tab-pane fade {{(isset($menutype) && $menutype == 'agent')?'show active':'' }}" id="about" role="tabpanel">
                            <div class="p-3 mb-2 border-bottom ">
                                <p  class="text-body mb-0">
                                    <i class="fi fi-check-circle"></i>
                                    {{ !empty($currentUser) ? $currentUser->fullname() : '' }}
                                </p>
                            </div>
                            <div class="px-3">
                                <ul class="list-group list-group-flush ">
                                    <li class="list-group-item px-0 border-bottom-0">
                                        <a href="" class="text-body"> <i class="fi fi-house-chosen"></i>{{ l('آگهی های من') }}</a>
                                    </li>
                                    <li class="list-group-item px-0 border-bottom-0">
                                        <a class="text-body" href="/customer">
                                            <i class="fi fi-building"></i> {{ l('مشتریان من') }}
                                        </a>
                                    </li>

                                    <li class="list-group-item px-0 border-bottom-0">
                                        <a href="/profile/myreport" class="text-body"> <i class="fi fi-file"></i>{{ l('آمار من') }}</a>
                                    </li>

                                    <li class="list-group-item px-0 border-bottom-0">
                                        <a href="/admin/logout" class="text-body"> <i class="fi fi-logout"></i>{{ l('خروج') }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
