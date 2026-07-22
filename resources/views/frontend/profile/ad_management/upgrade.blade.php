@section('title', l('مدیریت ملک - ارتقا آگهی ملک'))

    <div class="row">
        @include('frontend.profile.ad_management.layouts.sidebar_right')

        <div class="col-lg-8">

            <div class="row">
                <div class="promote-item-checkbox">
                    <div class="promote-item">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="defaultChecked1" checked>
                            <label class="custom-control-label" for="defaultChecked1"></label>
                        </div>
                    </div>
                    <div class="promote-item-main">
                        <div class="promote-item-head">{{ l('ارتقا براساس امتیاز') }}</div>
                        <div class="promote-item-price">{{ l('100 امتیاز') }}</div>
                        <div class="promote-item-desc">{{ l('آگهی شما تا زمان دریافت ملک تازه‌تر در همان شهر، به عنوان اولین آگهی نمایش داده می‌شود.') }}</div>
                        <button class="btn promote-btn" type="button"><span class="fas fa-gift" style="padding-left: 5px;"></span>{{ l('ارتقا ملک') }}</button>
                    </div>
                </div>
            </div>
        </div>

        @include('frontend.profile.ad_management.layouts.sidebar_left')
    </div>
