<div class="col-12 col-lg-3 d-flex d-none">

    <div class="account-nav flex-grow-1">
        <h4 class="account-nav__title">{{ l('پنل کاربری') }}</h4>
        <ul class="account-nav__list hide-mobile" style="">
            @if(Auth::check())
            <li class="session account-nav__item {{ \Request::is('*dashboard*') ? 'account-nav__item--active' : '' }}">
                <a href="/dashboard_v2">
                    <span class="mi mi-dashboard"></span>
                    {{ l('داشبورد') }}</a>
            </li>
            @endif
            @if($currentUser->isExpert())
            <!-- /.search form -->
            <li class="comment account-nav__item {{ \Request::is('*intro/agents*') ? 'account-nav__item--active' : '' }}">
                <a class="sidebar-svg" href="/profile/expertlevel">
                    <span class="mi mi-bazaryabi"></span>
                    {{ l('بازاریابی') }}</a>
            </li>
            @endif
            <li class="treeview general account-nav__item">
                <a class="" href="javascript:;">
                    <span class="mi mi-personal-office"></span>
                    {{ l('دفتر املاک شخصی') }}
                    <span class="pull-left-container">
                        <i class="fa fa-angle-right pull-left"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="general account-nav__item {{ \Request::is('*profile/my-estate-ads*') ? 'account-nav__item--active' : '' }}">
                        <a href="/profile/my-estate-ads>
                            <span class="mi mi-my-estates"></span>
                            {{ l('ملک های من') }}</a>
                    </li>
                    @if($currentUser->isExpert())
                    <li class="general account-nav__item  {{ \Request::is('*/customers*') ? 'active' : null }}">
                        <a class="" href="/customer">
                            <span class="mi mi-my-customers"></span>
                            {{ l('لیست خریداران') }}
                        </a>
                    </li>
                    <li class="general account-nav__item  {{ \Request::is('*/goals*') ? 'active' : null }}">
                        <a class="" href="/goals">
                            <span class="mi mi-targeting"></span>
                            {{ l('هدف گذاری') }}
                        </a>
                    </li>
                    @endif
                    <li class="monetization account-nav__item {{ \Request::is('*profile/notes*') ? 'account-nav__item--active' : '' }}">
                        <a href="/profile/notes">
                            <span class="mi mi-my-notes"></span>
                            {{ l('یادداشت های من') }} </a>
                    </li>
                    <li class="history account-nav__item {{ \Request::is('*profile/history*') ? 'account-nav__item--active' : '' }}">
                        <a href="/profile/history">
                            <span class="mi mi-recent"></span>

                            {{ l('بازدید های اخیر') }} </a>
                    </li>
                    @if($currentUser->isExpert())
                    <li class="general account-nav__item  {{ \Request::is('*/chats*') ? 'active' : null }}">
                        <a class="" href="/chats">
                            <span class="mi mi-dialogues"></span>
                            {{ l('گفتگوها') }}
                            <span class="pull-left-container">
                                @if($chatCount > 0)
                                <small class="label pull-left bg-yellow" id="chat-count">{{toPersianNumbers($chatCount)}}</small>
                                @endif
                        </a>
                    </li>

                    @endif
                    <li class="monetization account-nav__item {{ \Request::is('*profile/bookmark-estate*') ? 'account-nav__item--active' : '' }}">
                        <a href="/profile/bookmark-estate">
                            <span class="mi mi-Saved-estates"></span>
                            {{ l('ملک های نشان شده') }} </a>
                    </li>

                    <li class="ticket account-nav__item {{ \Request::is('*profile/bookmark-expert*') ? 'account-nav__item--active' : '' }}">
                        <a href="/profile/bookmark-expert">
                            <span class="mi mi-experts-saved"></span>
                            {{ l('کارشناسان نشان شده') }} </a>
                    </li>
                </ul>
            </li>

            <li class="profile account-nav__item {{ \Request::is('*profile/info*') ? 'account-nav__item--active' : '' }}">
                <a href="/profile/info_v2">
                    <span><svg style="color:black" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M7.5 6.5C7.5 8.981 9.519 11 12 11s4.5-2.019 4.5-4.5S14.481 2 12 2 7.5 4.019 7.5 6.5zM20 21h1v-1c0-3.859-3.141-7-7-7h-4c-3.86 0-7 3.141-7 7v1h1 1 14H20z"></path>
                        </svg></span>
                    {{ l('ویرایش اطلاعات پروفایل') }}</a>
            </li>
            @if($currentUser->isExpert())
            <li class="general account-nav__item  {{ \Request::is('*/notifications*') ? 'active' : null }}">
                <a class="" href="/admin/notifications">
                    <i class="fa fa-bell" style="color:black"></i>
                    {{ l('اعلان ها') }}
                </a>
            </li>
            @endif
            <li class="general account-nav__item  {{ \Request::is('*/logout*') ? 'active' : null }}">
                <a class="" href="/logout">
                    <span><i class="fa fa-sign-out text-red"></i></span>
                    {{ l('خروج') }}
                </a>
            </li>
        </ul>
    </div>
</div>
