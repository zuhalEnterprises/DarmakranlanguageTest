<aside class="d-none d-lg-block col-md-3 position-sticky rounded p-3">
    @if($menutype == 'agent')
    <div>
        <div class="px-3 pt-3 mb-2 border-bottom ">
            <div class="d-flex flex-column gap-2 pb-2">
                <div class="" style="width:48px">
                    <img class="rounded-circle" src="{{ !empty($currentUser) ? $currentUser->photo() : '' }}" alt="{{ !empty($currentUser) ? $currentUser->fullname() : '' }}" style="height: 48px">
                </div>
                <a href="">{{ !empty($currentUser) ? $currentUser->fullname() : '' }}</a>

            </div>
        </div>
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
                <a href="/profile/report" class="text-body"> <i class="fi fi-file"></i>{{ l('آمار من') }}</a>
            </li>

            <li class="list-group-item px-0 border-bottom-0">
                <a href="/admin/logout" class="text-body"> <i class="fi fi-logout"></i>{{ l('خروج') }}</a>
            </li>
        </ul>
        <div class="px-4 mt-3">
            <div class="d-flex flex-wrap gap-3 justify-content-center mb-3">
                <a href="" class="opacity-60 text-dark fs-xs">{{ l('درباره کلبه') }}</a>
                <a href="" class="opacity-60 text-dark fs-xs">{{ l('تماس با ما') }}</a>

                <a href="" class="opacity-60 text-dark fs-xs">{{ l('پشتیبانی') }}</a>
                <a href="" class="opacity-60 text-dark fs-xs">{{ l('قوانین') }}</a>
            </div>

        </div>
    </div>
    @endif

    @if($menutype == 'branch')
    @if(!empty($currentUser) &&  $currentUser->branch_id>0 && isset($currentUser->branch))
    <div>
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
        <div class="px-4 mt-3">
            <div class="d-flex flex-wrap gap-3 justify-content-center mb-3 ">
                <a href="" class="opacity-60 text-dark fs-xs">{{ l('درباره کلبه') }}</a>
                <a href="" class="opacity-60 text-dark fs-xs">{{ l('تماس با ما') }}</a>
                <a href="" class="opacity-60 text-dark fs-xs">{{ l('پشتیبانی') }}</a>
                <a href="" class="opacity-60 text-dark fs-xs">{{ l('قوانین') }}</a>
                @if(!empty($currentUser) &&  $currentUser->isAdmin())
                <a href="/profile/branches" class="opacity-60 text-dark fs-xs">{{ l('مدیریت آژانسها') }}</a>
                <a href="/profile/users" class="opacity-60 text-dark fs-xs">{{ l('مدیریت مشاوران') }}</a>
                @endif
            </div>

        </div>
    </div>
    @endif
    @endif

</aside>
