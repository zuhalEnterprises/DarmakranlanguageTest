<!-- Sidebar-->
<style>
.font-weight-bold{font-weight: bold;font-size: :20px}


.rotade {
    transform: rotate(0deg);
    transition: all  1s;
}
.rotated {
    -webkit-transform: rotate(180deg);
    -moz-transform: rotate(180deg);
    -ms-transform: rotate(180deg);
    -o-transform: rotate(180deg);
    transform: rotate(180deg);
}
.containerheader{border:0px !important}
</style>
<aside class="col-lg-3 d-none d-lg-block mb-1 mb-lg-5 mt-3 pe-0">
    <!-- Account nav-->
    <div class="card card-body shadow-sm rounded pb-1 me-lg-1">
        <div class="d-flex d-md-block d-lg-flex align-items-start pt-lg-2 mb-4 gap-2">
            <div class="" style="width:48px">
                <img class="rounded-circle" src="{{ !empty($currentUser) ? $currentUser->photo() : '' }}" alt="{{ !empty($currentUser) ? $currentUser->fullname() : '' }}" style="height: 48px">
            </div>
            <div class="pt-md-2 pt-lg-0 pe-3 pe-md-0 ps-lg-3">
                <h2 class="fs-lg mb-0">{{ !empty($currentUser) ? $currentUser->fullname() : '' }}</h2>
                <span class="star-rating">
                    <?php
                    $listArray = json_decode(Auth::user()->role_ids);

                    if(ss('SITE_ID') == 3 && $IpLogin == null){
                        $listArray = null;
                    }
                    ?>
                    @if(!empty($currentUser))
                        @if($currentUser->isAdmin())
                        {{l('مدیر اصلی')}}
                        @elseif($currentUser->isExpert())
                        {{l('مشاور')}}
                        @elseif($currentUser->isReferrer())
                        {{l('بازاریاب')}}
                        @else
                        {{l('کاربر عادی')}}
                        @endif
                    @endif
                </span>
            </div>
        </div>

        <a class="btn btn-primary btn-lg w-100 mb-3" href="/add"><i class="fi-plus me-2"></i>{{l('ثبت ملک')}}</a>

        <a class="btn btn-outline-secondary d-block d-md-none w-100 mb-3" href="#account-nav" data-bs-toggle="collapse"><i class="fi-align-justify me-2"></i>{{ l('منو') }}</a>
        <div class="collapse d-md-block mt-3" id="account-nav">
            <div class="card-nav">

                @if(!empty($currentUser) && $currentUser->isExpert())

                <a class="card-nav-link  px-0 align-middle rotate d-flex align-items-center gap-2 {{$menu==13?'active':''}}" href="/dashboard">
                    <i class="fi-edit opacity-60 me-2"></i>{{l('داشبورد')}}
                </a>

                @endif
                @if(env('COUNTRY') != 'UAE' && ($currentUser->isExpert() || ss('SITE_ID') != 3))
                <a class="card-nav-link  px-0 align-middle rotate d-flex align-items-center gap-2 {{$menu==7?'active':''}} {{chatNewCount(Auth::User()->id)>0?"font-weight-bold":""}}" href="/chats">
                    <i class="fi-messenger opacity-60 me-2 "></i>{{l('پیام')}}
                    @if(chatNewCount(Auth::User()->id)>0)
                    <span style="color:red">({{chatNewCount(Auth::User()->id)}} {{ l('پیام جدید') }})</span>
                    @endif
                </a>
                @endif
                <a class="card-nav-link  px-0 align-middle rotate d-flex align-items-center gap-2" data-bs-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample2">
                    <i class="fi-home opacity-60 me-2 "></i>
                    <span class="ms-1 d-none d-sm-inline">{{l('مدیریت املاک')}}</span>
                    <i class="fi-chevron-down opacity-60  me-auto"></i>
                </a>
                <div class="collapse" id="collapseExample2">
                    <div class="card card-body shadow-none mb-3 px-3 py-1">
                        <ul class=" nav flex-column ms-1 ">
                            <li class="w-100">
                                <a class="nav-link  px-0 {{$menu==2?'active':''}}" href="/profile/my-estate-ads">
                                    <i class="fi-home opacity-60 me-2"></i>{{l('لیست املاک')}}
                                </a>
                            </li>
                            <li>
                                <a class="nav-link  px-0" href="/add">
                                    <i class="fi-home opacity-60 me-2"></i>{{l('ثبت ملک')}}
                                </a>
                            </li>
                            @if(!empty($currentUser) && $currentUser->isExpert())
                            @if(ss('SITE_ID') == 8 || ss('SITE_ID') == 3 || ss('SITE_ID') == 5 || ss('SITE_ID') == 2 || env('COUNTRY') == 'UAE')
                            @if($currentUser->isAdmin())
                            <li>
                                <a href="/profile/operationEstate"  class="nav-link px-0 {{$menu==9?'active':''}}">
                                    <i class="fa fa-home opacity-60 me-2"></i>{{l('عملکرد املاک')}}
                                </a>
                            </li>
                            @endif
                            @endif
                            @endif
                            @if($currentUser->isAdmin())
                            @if(ss('SITE_ID') == 10)
                            <li>
                                <a class="nav-link px-0 {{$menu=='comment'?'active':''}}" href="/comment">
                                    <i class="fa fa-user  opacity-60 me-2"></i>{{l('نظرات املاک')}}
                                </a>
                            </li>
                            @endif
                            @if(ss('SITE_ID') == 3)
                            <li>
                                <a class="nav-link px-0 {{$menu==15?'active':''}}" href="/profile/reportEstate">
                                    <i class="fa fa-user  opacity-60 me-2"></i>{{ l('گزارشهای مشکل در املاک') }}
                                </a>
                            </li>
                            @endif
                            @if(env('COUNTRY') != 'UAE')
                            <li>
                                <a class="nav-link px-0 {{$menu==16?'active':''}}" href="/profile/editsEstate">
                                    <i class="fa fa-user  opacity-60 me-2"></i>{{ l('ویرایش های املاک') }}
                                </a>
                            </li>
                            @endif
                            @endif
                            <li>
                                <a class="nav-link px-0 {{$menu==5?'active':''}}" href="/favorite"><i class="fi-heart opacity-60 me-2"></i>{{l('موردعلاقه ها')}}</a>
                            </li>
                            @if(env('COUNTRY') != 'UAE')
                            <li>
                                <a class="nav-link px-0 {{$menu==8?'active':''}}" href="/compare"><i class="fa-solid fa-code-compare opacity-60 me-2"></i>{{l('مقایسه املاک')}}</a>
                            </li>
                            @endif
                            @if($currentUser->isAdmin())
                            @if (env('COUNTRY') == 'UAE')
                            <li>
                                <a class="nav-link px-0 {{$menu=='manufacturer'?'active':''}}" href="/profile/manufacturer">
                                    <i class="fa fa-user  opacity-60 me-2"></i>{{l('لیست سازندگان')}}
                                </a>
                            </li>
                            <li>
                                <a class="nav-link px-0 {{$menu=='project'?'active':''}}" href="/profile/project">
                                    <i class="fa fa-user  opacity-60 me-2"></i>{{l('لیست پروژه ها')}}
                                </a>
                            </li>
                            <li>
                                <a class="nav-link px-0 {{$menu=='brand'?'active':''}}" href="/profile/brand">
                                    <i class="fa fa-user  opacity-60 me-2"></i>{{l('لیست برند ها')}}
                                </a>
                            </li>
                            @endif
                            @endif
                        </ul>
                    </div>
                </div>

                <a class="card-nav-link  px-0 align-middle rotate d-flex align-items-center gap-2" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <i class="fi-building opacity-60 me-2 "></i>
                    <span class="ms-1 d-none d-sm-inline">{{l('مدیریت مشتریان')}}</span>
                    <i class="fi-chevron-down opacity-60  me-auto"></i>
                </a>
                <div class="collapse" id="collapseExample">
                    <div class="card card-body shadow-none mb-3 px-3 py-1">
                        <ul class=" nav flex-column ms-1">
                            @if($currentUser->isReferrer() && ss('SITE_ID') == 10)
                            <li class="w-100">
                                <a class="nav-link px-0 {{$menu==3?'active':''}}" href="/customerReferrer">
                                    <i class="fi-building opacity-60 me-2"></i>{{l('بازاریابی تقاضا')}}
                                </a>
                            </li>
                            @endif
                            <li class="w-100">
                                <a class="nav-link px-0 {{$menu==3?'active':''}}" href="/customer">
                                    <i class="fi-building opacity-60 me-2"></i>{{l('لیست مشتریان')}}
                                </a>
                            </li>
                            <li class="w-100">
                                <a class="nav-link px-0 {{$menu==4?'active':''}}" href="/customers/create">
                                    <i class="fi-check opacity-60 me-2"></i>{{l('ثبت مشتری')}}
                                </a>
                            </li>
                            @if(ss('SITE_ID') == 10)
                            <li class="w-100">
                                <a class="nav-link px-0 {{$menu=="booking"?'active':''}}" href="/customerBooking">
                                    <i class="fi-building opacity-60 me-2"></i>{{l('لیست قرار بازدید')}}
                                </a>
                            </li>
                            @endif
                            @if(!empty($currentUser) && $currentUser->isAdmin() && env('COUNTRY') == 'UAE')
                            <!--li class="w-100">
                                <a href="/acquaintance"  class="nav-link px-0">
                                    <i class="fa fa-home opacity-60 me-2"></i>{{l('Lead Sources')}}
                                </a>
                            </li-->
                            @endif
                            @if(!empty($currentUser) && $currentUser->isExpert())
                            @if(ss('SITE_ID') == 8 || ss('SITE_ID') == 3 || ss('SITE_ID') == 5 || ss('SITE_ID') == 2 || env('COUNTRY') == 'UAE')
                            <li class="w-100">
                                <a href="/profile/operationCustomer"  class="nav-link px-0 {{$menu==17?'active':''}}">
                                    <i class="fa fa-home opacity-60 me-2"></i>{{l('عملکرد مشتریان')}}
                                </a>
                            </li>
                            @endif
                            @endif
                        </ul>

                    </div>
                </div>

                @if(ss('SITE_ID') == 2)
                <a class="card-nav-link  px-0 align-middle rotate d-flex align-items-center gap-2" data-bs-toggle="collapse" href="#collapseExample10" role="button" aria-expanded="false" aria-controls="collapseExample10">
                    <i class="fi-building opacity-60 me-2 "></i>
                    <span class="ms-1 d-none d-sm-inline">{{ l('اجاره کوتاه مدت') }}</span>
                    <i class="fi-chevron-down opacity-60  me-auto"></i>
                </a>
                <div class="collapse" id="collapseExample10">
                    <div class="card card-body shadow-none mb-3 px-3 py-1">
                        <ul class=" nav flex-column ms-1">
                            <li class="w-100">
                                <a class="nav-link px-0 {{$menu=='rentallists'?'active':''}}" href="/rental/estates">
                                    <i class="fi-building opacity-60 me-2"></i>{{ l('لیست اقامتگاه‌ها') }}
                                </a>
                            </li>
                            <li class="w-100">
                                <a class="nav-link px-0 {{$menu=='rentalcreate'?'active':''}}" href="/rental/estate/create">
                                    <i class="fi-building opacity-60 me-2"></i>{{ l('ثبت اقامتگاه‌ها') }}
                                </a>
                            </li>
                            @if(!empty($currentUser) && $currentUser->isAdmin())
                            <li class="w-100">
                                <a class="nav-link px-0 {{$menu=='rentalusers'?'active':''}}" href="/rental/users">
                                    <i class="fi-check opacity-60 me-2"></i>{{ l('لیست موجرین') }}
                                </a>
                            </li>
                            <li class="w-100">
                                <a class="nav-link px-0 {{$menu=='rentaladduser'?'active':''}}" href="/rental/users/create">
                                    <i class="fi-check opacity-60 me-2"></i>{{ l('اضافه کردن موجر') }}
                                </a>
                            </li>
                            <li class="w-100">
                                <a class="nav-link px-0 {{$menu=='rentalcustomers'?'active':''}}" href="/rental/customers">
                                    <i class="fi-check opacity-60 me-2"></i>{{ l('تقاضاهای اجاره') }}
                                </a>
                            </li>
                            <li class="w-100">
                                <a class="nav-link px-0 {{$menu=='rentaladdcustomer'?'active':''}}" href="/rental/customer/create">
                                    <i class="fi-check opacity-60 me-2"></i>{{ l('ثبت تقاضا') }}
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
                @endif
                @if(!empty($currentUser) && $currentUser->isExpert())
                @if(ss('SITE_ID') == 8 || ss('SITE_ID') == 3 || ss('SITE_ID') == 5 || ss('SITE_ID') == 2)
                <a class="card-nav-link  px-0 align-middle rotate d-flex align-items-center gap-2" data-bs-toggle="collapse" href="#collapseExample4" role="button" aria-expanded="false" aria-controls="collapseExample4">
                    <i class="fi-building opacity-60 me-2 "></i>
                    <span class="ms-1 d-none d-sm-inline">{{l('مدیریت عملکرد مشاور')}}</span>
                    <i class="fi-chevron-down opacity-60  me-auto"></i>
                </a>
                <div class="collapse" id="collapseExample4">
                    <div class="card card-body shadow-none mb-3 px-3 py-1">
                        <ul class=" nav flex-column ms-1">
                            @if(ss('SITE_ID') == 3)
                            <li class="w-100">
                                <a href="/profile/phonebook"  class="nav-link px-0 {{$menu=='phonebook'?'active':''}}">
                                    <i class="fa fa-building opacity-60 me-2"></i>{{ l('دفترچه تلفن') }}
                                </a>
                            </li>
                            @endif
                            <li class="w-100">
                                <a href="/profile/relationEstateCustomer"  class="nav-link px-0 {{$menu==10?'active':''}}">
                                    <i class="fa fa-building opacity-60 me-2"></i>{{l('مشتریان و املاک متناسب')}}
                                </a>
                            </li>
                            <li class="w-100">
                                <a href="/profile/report" class="nav-link px-0 {{$menu==11?'active':''}}">
                                    <i class="fa fa-bar-chart opacity-60 me-2"></i>{{l('آمار مشاوران')}}
                                </a>
                            </li>
                            @if(ss('SITE_ID') == 3 || ss('SITE_ID') == 5)
                            <li class="w-100">
                            <a href="/task" class="nav-link px-0 {{$menu==20?'active':''}}">
                                <i class="fa fa-city opacity-60 me-2"></i>{{ l('تقویم کاری') }}
                            </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
                @endif
                @endif
                @if($currentUser->isAdmin())
                <a class="card-nav-link  px-0 align-middle rotate d-flex align-items-center gap-2" data-bs-toggle="collapse" href="#collapseExample3" role="button" aria-expanded="false" aria-controls="collapseExample3">
                    <i class="fi-building opacity-60 me-2 "></i>
                    <span class="ms-1 d-none d-sm-inline">{{l('مدیریت سیستم')}}</span>
                    <i class="fi-chevron-down opacity-60  me-auto"></i>
                </a>
                <div class="collapse" id="collapseExample3">
                    <div class="card card-body shadow-none mb-3 px-3 py-1">
                        <ul class=" nav flex-column ms-1">
                            @if(env('COUNTRY') != 'UAE')
                            <li class="w-100">
                                <a class="nav-link px-0 {{$menu==14?'active':''}}" href="/profile/sms">
                                    <i class="fa fa-user  opacity-60 me-2"></i>{{l('پیامکهای ارسالی و دریافتی')}}
                                </a>
                            </li>
                            @endif
                            @if(ss('SITE_ID') == 3)
                            <li class="w-100">
                                <a class="nav-link px-0" href="/profile/branches">
                                    <i class="fa fa-sitemap  opacity-60 me-2"></i>
                                    {{ l('شعبه ها') }}
                                </a>
                            </li>
                            @endif
                            @if(env('COUNTRY') != 'UAE')
                            <li class="w-100">
                                <a href="/profile/settings" class="nav-link px-0 {{$menu=='setting'?'active':''}}">
                                    <i class="fa fa-gears opacity-60 me-2"></i>{{l('تنظیمات')}}
                                </a>
                            </li>
                            @endif

                            @if(ss('SITE_ID') != 2 && env('COUNTRY') != 'UAE')
                            <li class="w-100">
                                <a href="/profile/province" class="nav-link px-0 {{$menu=='province'?'active':''}}">
                                    <i class="fa fa-city opacity-60 me-2"></i>{{l('لیست استان‌ها')}}
                                </a>
                            </li>
                            @endif
                            <li class="w-100">
                                <a href="/profile/city" class="nav-link px-0 {{$menu=='city'?'active':''}}">
                                    <i class="fa fa-city opacity-60 me-2"></i>{{l('لیست شهرها')}}
                                </a>
                            </li>
                            <li class="w-100">
                                <a href="/profile/district" class="nav-link px-0 {{$menu=='district'?'active':''}}">
                                    <i class="fa fa-city opacity-60 me-2"></i>{{l('لیست محله‌ها')}}
                                </a>
                            </li>

                            @if(ss('SITE_ID') == 8 || ss('SITE_ID') == '3' || ss('SITE_ID') == '5')
                            <li class="w-100">
                                <a href="/profile/street" class="nav-link px-0 {{$menu=='street'?'active':''}}">
                                    <i class="fa fa-city opacity-60 me-2"></i>{{ l('لیست خیابان‌ها') }}
                                </a>
                            </li>
                            @endif

                            <li class="w-100">
                                <a class="nav-link px-0 {{$menu=='users'?'active':''}}" href="/profile/users">
                                    <i class="fa fa-user  opacity-60 me-2"></i>{{l('اعضای سیستم')}}</a>
                            </li>
                            @if(!empty($currentUser) && $currentUser->isExpert())
                            @if(ss('SITE_ID') == 3)
                            <li class="w-100">
                                <a href="/profile/operationUser"  class="nav-link px-0 {{$menu=='operationUser'?'active':''}}">
                                    <i class="fa fa-home opacity-60 me-2"></i>{{ l('عملکرد کارشناسان') }}
                                </a>
                            </li>
                            @endif
                            @endif
                            @if(ss('SITE_ID') == 8 || ss('SITE_ID') == 5 || ss('SITE_ID') == 3 || ss('SITE_ID') == 2)
                            <li class="w-100">
                                <a href="/profile/contract" class="nav-link px-0 {{$menu=='contract'?'active':''}}">
                                    <i class="fa fa-city opacity-60 me-2"></i>{{ l('مدیریت قرارداد') }}
                                </a>
                            </li>
                            @endif
                            @if(ss('SITE_ID') == 3 || ss('SITE_ID') == 2 || env('COUNTRY') == 'UAE')
                            <li class="w-100">
                                <a href="/profile/posts" class="nav-link px-0 {{$menu=='article'?'active':''}}">
                                    <i class="fa fa-city opacity-60 me-2"></i>{{l('مدیریت مطالب')}}
                                </a>
                            </li>
                            @endif
                            @if(ss('SITE_ID') == 3)
                            <li class="w-100 d-none">
                                <a class="nav-link px-0 {{$menu=='appraisal'?'active':''}}" href="/profile/appraisal">
                                    <i class="fa fa-user  opacity-60 me-2"></i>{{ l('کارشناسی قیمت') }}</a>
                            </li>
                            @endif
                            @if(ss('SITE_ID') == 2)
                            <li class="w-100">
                                <a class="nav-link px-0 {{$menu=='appraisal'?'active':''}}" href="/profile/appraisal">
                                    <i class="fa fa-user  opacity-60 me-2"></i>{{ l('استخدام در گیلند ملک') }}</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
                @endif
                @if(ss('SITE_ID') != 6)
                <a class="card-nav-link  px-0 align-middle rotate d-flex align-items-center gap-2 {{$menu==6?'active':''}}" href="/profile/info_v2">
                    <i class="fi-edit opacity-60 me-2"></i>{{l('ویرایش مشخصات')}}
                </a>
                @endif
                <a class="card-nav-link px-0 align-middle rotate d-flex align-items-center gap-2" href="/logout">
                    <i class="fi-logout opacity-60 me-2"></i>{{l('خروج')}}
                </a>
            </div>
        </div>
    </div>
</aside>

<script>
$('.rotate').click(function() {
    $(this).children(":last").toggleClass('rotated');
});
</script>
