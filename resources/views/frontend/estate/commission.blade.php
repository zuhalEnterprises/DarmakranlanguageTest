@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2',
[
'title'=>' محاسبه کمیسیون املاک '
])

@section('head')
<style>
 .custom-heading {
            display: flex;
            align-items: center;
            text-align: center;
        }
.custom-heading::before, .custom-heading::after {
            content: "";
            flex: 1;
            border-bottom: 2px solid #000;
            margin: 0 10px;
}

</style>
@endsection

@section('main_content')
    <!-- main -->
    <main class="page-wrapper">
        @include(ss('THEME').'.frontend.layouts.header_v2')
        <!-- Page content-->
        <!-- Breadcrumb-->
        <div class="container mt-5 mb-md-4 pt-5">
            <nav class="mb-3 pt-md-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">{{ l('خانه') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ l('کمیسیون املاک') }}</li>
                </ol>
            </nav>
        </div>
        <!-- Hero-->
        <section class="container mb-5 pb-2 pb-lg-4">
            <div class="row align-items-center justify-content-between">

                <div class="col-md-8">
                    <h2 class="">
                        {{ l('محاسبه آنلاین حق کمیسیون املاک') }}
                    </h2>
                    <div class="m-auto d-block d-md-none " >
                        <img class="d-block m-auto p-5" src="/img/site3/commission3.jpg" width="416" alt="Illustration">
                    </div>

                    <div class="w-100">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold" >{{ l('نوع معامله:') }}</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" id="form-radio-4" type="radio" name="radios-inline" checked onclick="return typechange(1)">
                                        <label class="form-check-label" for="form-radio-4">{{ l('خرید و فروش') }}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" id="form-radio-5" type="radio" name="radios-inline" onclick="return typechange(2)">
                                        <label class="form-check-label" for="form-radio-5">{{ l('رهن و اجاره') }}</label>
                                    </div>
                                </div>
                                <div class=" align-items-center gap-5 kind1">
                                    <label for="text-input" class="fw-bold form-label ">{{ l('قیمت (تومان):') }}</label>
                                    <input class="form-control w-lg-75 number js_number js_Splitnumber1" type="text" id="price" onkeypress="OnlyNumber(event,false)"  onkeyup="SplitNumber($(this) , 'price');">
                                    <div id="divprice"  class="w-100"></div>
                                </div>
                                <div class=" align-items-center gap-5 kind2" style="display: none">
                                    <label for="text-input" class="fw-bold form-label ">{{ l('رهن:') }}</label>
                                    <input class="form-control w-lg-75 number js_number js_Splitnumber1" type="text" id="rahn" onkeypress="OnlyNumber(event,false)"  onkeyup="SplitNumber($(this) , 'rahn');">
                                    <div id="divrahn"  class="w-100"></div>
                                </div>
                                <div class=" align-items-center gap-5 kind2 mt-2" style="display: none">
                                    <label for="text-input" class="fw-bold form-label ">{{ l('اجاره:') }}</label>
                                    <input class="form-control w-lg-75 number js_number js_Splitnumber1" type="text" id="rent" onkeypress="OnlyNumber(event,false)"  onkeyup="SplitNumber($(this) , 'rent');">
                                    <div id="divrent"  class="w-100"></div>
                                </div>
                                <div class="text-center">
                                    <button class="btn btn-primary mt-3 btn-calculator"><i class="fi-calculator me-2"></i> {{ l('محاسبه') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-center flex-column flex-lg-row gap-3 commission_show  d-none">


                            <div class="mt-3 py-3 px-4 bg-success rounded-1 w-lg-50 w-75">
                                <p class="mb-2 text-center text-white fw-bold fs-5">{{ l('کل کمیسیون + ارزش افزوده') }}</p>
                                <p class="text-center text-white fs-5 mb-1 "><span class="pricecommission"></span>{{ l('تومان') }}</p>
                            </div>
                            <div class="mt-3 py-3 px-4 bg-warning rounded-1 w-lg-50 w-75">
                                <p class="mb-2 text-center text-white fw-bold fs-5">{{ l('کمیسیون هر کدام از طرفین') }}</p>
                                <p class="text-center text-white fs-5 mb-1 "><span class="pricecommission2"></span>{{ l('تومان') }}</p>
                            </div>
                            <!--div class="mt-3 py-3 px-4 bg-primary rounded-1 w-lg-34 w-75">
                                <p class="mb-2 text-center text-white fw-bold fs-5">{{ l('قراردادهای توافقی با 70 درصد تخفیف در کومه') }}</p>
                                <p class="text-center text-white fs-5 mb-1 "><span class="pricecommission3"></span>{{ l('تومان') }}</p>
                            </div-->
                        </div>
                    </div>

                </div>
                <div class="col-md-4 me-auto d-none d-md-block">
                    <img class="d-block me-auto " src="/img/site3/commission3.jpg" width="416" alt="Illustration">
                </div>
            </div>
      </section>
      <section class="container mb-5 pb-2 pb-lg-4">
            <div>
                <h3 class="fs-5">{{ l('کمیسیون املاک چیست ؟') }}</h3>
                <p class="text-justify fs-base">
                {{ l('حق کمیسیون مشاورین املاک به کارمزدی گفته می‌شود که مشاورین به‌عنوان دستمزد دریافت می‌کنند و در قدیم بنا به اختیار خریدار و فروشنده به آژانس املاک پرداخت می‌شد، اما از سال ۱۳۷۹ بر اساس قانون فرمول خاصی برای محاسبه حق کمیسیون برای انواع فعالیت های تجاری در زمینه مسکن مانند خرید، فروش، رهن و اجاره ی انواع املاک تجاری، مسکونی و اداری دریافت میشود. پرداخت کمیسیون یکی از مفاد و قوانین معاملاتی در کشور است و طرفین معامله ملزم به پرداخت آن هستند."کمیسیون املاک" توسط فروشنده و خریدار یا مؤجر و مستأجر به مشاوران املاک پرداخت می‌شود. با توجه به بازار املاک، این مبلغ بر اساس مصوبه صنف شهر مورد نظر برای هر معامله بر اساس فاکتورهای خاصی محاسبه می‌شود. مشاورین املاک موظفند، بر اساس تعرفه‌ای که هر سال از سوی') }} <b>{{ l('اتحادیه مشاورین املاک') }}</b>{{ l('شهرشان ابلاغ می‏شود، از طرفین معامله کارمزد بگیرند. در این مطلب فرمول محاسبه حق کمیسیون املاک در خرید، فروش، رهن و اجاره ملک را برای شما شرح می‌دهیم تا کاملا با نحوه محاسبه حق کمیسیون مشاورین املاک آشنا شوید.') }}<br>
                <b>{{ l('نکته') }}</b>{{ l(': این فرمول کشوری است و ملاک هر شهرستان، نامه اتحادیه مشاورین املاک آن شهرستان است که ممکن است با فرمول کشوری کمی تفاوت داشته باشد.') }}

                </p>

                <h3 class="fs-5">{{ l('علت پرداخت کمیسیون چیست ؟') }}</h3>
                <p class="text-justify fs-base">
                {{ l('همانطور که می دانید در ایران، خرید و یا فروش یک ملک یا اجاره کردن آن می‌تواند یک سرمایه‌گذاری مطمئن برای خانواده باشد، چرا که هم نرخ مسکن دائما رو به افزایش است و هم با خرید یک منزل می‌توان آن را به منبعی برای کسب درآمد تبدیل کرد. بنابراین هیچ‌کس دوست ندارد در این زمینه بی‌گدار به آب زده و پس‌انداز و سرمایه خود را در خانه‌ای با مشکلات حقوقی و فنی فراوان هدر دهد. در عین حال هیچ انسانی مایل نیست بخش اعظمی از حقوق ماهیانه خود را صرف پرداخت اجاره ملکی کند که قیمت آن از استانداردهای روز بازار بالاتر است یا مطلوبیتی برای اهالی خانه ندارد.') }}<br>
                {{ l('مجموعه این حساسیت‌ها باعث شده تا پیدا کردن ملکی که از نظر موقعیت جغرافیایی، مصالح ساخت ملک، اصول مهندسی و سایر فاکتورها بهترین بازار باشد، به امری پیچیده و دشوار و نیازمند تخصص تبدیل شود. شاید بتوان به جرات گفت پیدا کردن چنین ملکی خود یک کار تمام‌ وقت است که به تمام انرژی، تمرکز و صبر شما احتیاج دارد. به همین دلیل است که در بسیاری از کشورهای دنیا شغل مهمی با عنوان “مشاورین املاک” شکل گرفته. این افراد در ازای دریافت حق العمل، خدماتی را در حوزه ملک و مسکن به شما ارائه می‌دهند و با توجه به گستردگی و پیچیدگی های این کار بهتر است به یک دپارتمان املاک معتبر، مراجعه کنید. که در این امر دپارتمان املاک کومه با دارا بودن مشاورین متخصص در زمینه های مختلف ملکی می تواند همچون نیاز های ملکی شما را آسان، سریع و مطمئن مرتفع نماید.') }}<br>
                {{ l('در این مقاله قصد داریم همه‌ی آن چیزی که نیاز دارید درمورد حق کمیسیون املاک بدانید برای شما توضیح دهیم. اگر قصد خرید یا فروش و یا اجاره املاک را دارید لازم است این مقاله را تا انتها دنبال کنید.') }}

                </p>
                <div class="row align-items-center mb-4">
                    <div class="col-md-8">
                        <h3 class="fs-5">{{ l('حق کمیسیون در صورت فسخ قرارداد') }}</h3>
                        <p class="text-justify fs-base">
                        {{ l('در هر معامله‌ای امکان فسخ وجود دارد؛ اما آیا در صورت فسخ قرارداد خرید یا اجاره، کمیسیون املاک پرداخت می‌شود؟ همانطور که در بالا به طور کامل حق کمیسیون را تعریف کردیم، حق کمیسیون مشاورین املاک در ازای خدماتی است که آن‌ها برای پیشبرد معامله و عقد قرارداد انجام داده‌اند، این افراد پس از فسخ معامله نیز می‌توانند حق کمیسیون خود را طلب کنند. البته لازم به ذکر است که فسخ قراردادهای خرید و اجاره بر اساس مفاد قانونی، در شرایط خاصی امکان‌پذیر است و طرفین باید در خصوص فسخ قرارداد با یکدیگر اتفاق نظر داشته باشند. در چنین شرایطی، تمامی حق کمیسیون مشاورین املاک ۱۴۰3 (حتی سهم طرف دوم) را طرف فسخ‌کننده باید پرداخت کند.') }}
                        </p>
                    </div>
                    <div class="col-md-4">
                        <img class="rounded w-100 h-100" src="/img/site3/commission.jpg" alt="commission">
                    </div>
                </div>


                <h3 class="fs-5">{{ l('نحوه محاسبه کمیسیون املاک در شهرهای مختلف ایران در سال ۱۴۰۳') }}</h3>
                <p class="text-justify fs-base">
                {{ l('حق کمیسیون املاک در سال ۱۴۰۳ تفاوتی با سال ۱۴۰۲ نداشته و تا اعلام رسمی از سمت کمیسیون نظارت هر شهر، با همان نرخ سال گذشته محاسبه می‌گردد.') }}<br>
                {{ l('نرخ محاسبه کمیسیون در هر شهر توسط کمیسیون نظارت آن شهر مشخص می گردد و نحوه محاسبه و درصد آن در هر شهر متفاوت است اما عموما نحوه محاسبه به دو صورت انجام می شود.') }}
                </p>
                <div class="col-md-4 m-auto">
                    <img class="rounded w-100 h-100" src="/img/site3/commission2.jpg" alt="commission">
                </div>

                <h3 class="fs-5">{{ l('محساسبه کمیسون ثابت') }}</h3>
                <p class="text-justify fs-base">
                {{ l('در این روش درصد محاسبه میزان ثابتی دارد و افزایش قیمت تاثیری در درصد محاسبه ندارد، با توجه افزایش قیمت ها، شهرهایی مثل تهران- قم از روش ثابت استفاده می‌کنند و مبلغ به صورت درصدی از ارزش کل معامله تعیین می شود.') }} <br>
                {{ l('در بسیاری موارد مشاورین متخلف جهت دریافت کمیسیون بیشتر با فروشنده توافق میکنند که قیمت ملک را بالاتر برده و مازاد قیمت را به عنوان دستمزد دریافت کرده و همزمان درصد مصوب را از خریدار دریافت میکنند.') }}
                </p>

                <h3 class="fs-5">{{ l('محاسبه کمیسون پله‌ایی') }}</h3>
                <p class="text-justify fs-base">
                {{ l('در این روش مبلغ کل ملک در میزان درصد محاسبه تاثیر گذار است، به این صورت که اگر مبلغ بیشتر از مقداری مشخصی باشد درصد محاسبه تا پله تایین شده به یک میزان و مازاد قیمت از پله تایین شده با درصد پایین تری محاسبه می‌شود.') }}
                </p>

                <h2 class="custom-heading my-4">{{ l('نحوه محاسبه کمیسیون املاک در شهر تهران') }}</h2>
                <h3 class="fs-5">{{ l('کمیسیون خرید و فروش تهران') }}</h3>

                <p class="text-justify fs-base">
                {{ l('طبق مصوبه اتحادیه املاک تهران کمیسیون خرید و فروش ملک به صورت ثابت انجام می‌شود و هر کدام از طرفین معامله موظف به پرداخت ۲۵ صدم درصد قیمت ملک به علاوه 10 درصد مالیات ارزش افزوده می‌باشند.') }} <br>
                {{ l('طرفین ۰.۲۵ درصد از قیمت کل ملک + 10 درصد مالیات ارزش افزوده') }}
                </p>
                <h3 class="fs-5">{{ l('کمیسیون رهن و اجاره تهران') }}</h3>

                <p class="text-justify fs-base">
                {{ l('تبدیل مبلغ رهن به اجاره و جمع این مبلغ با اجاره‌ بهای ماهانه') }} <br>
                {{ l('تعیین 30 درصد از این مبلغ به عنوان حق کمیسیون مشاور') }} <br>
                {{ l('محاسبه 10 درصد از حق کمیسیون به عنوان مالیات بر ارزش افزوده و پرداخت آن به مشاور املاک') }}
                </p>

                <h3 class="fs-5">{{ l('کمیسیون تمدید اجاره تهران') }}</h3>

                <p class="text-justify fs-base">
                {{ l('کمیسیون تمدید اجاره ملک نیز برابر است با یک دهم مبلغ کمیسیون قرارداد اجاره بدین صورت که ابتدا مبلغ کمیسیون را محاسبه و مبلغ را تقسیم به ده می‌کنند.') }}<br>

                </p>

                <h2 class="custom-heading my-4">{{ l('نحوه محاسبه کمیسیون املاک در شهر قم') }}</h2>
                <h3 class="fs-5">{{ l('کمیسون خرید فروش در قم') }}</h3>

                <p class="text-justify fs-base">
                {{ l('طبق مصوب جلسه کمیسون نظارت نرخ حق العمل کاری مشاوران املاک و مسقلات قم هر کدام از طرفین معامله موظف به پرداخت ۲۵ صدم درصد قیمت ملک به علاوه 10 درصد مالیات ارزش افزوده می‌باشند.') }} <br>
                {{ l('به عبارتی کل مبلغ کمیسیون معادل 5/0 درصد کل مبلغ ملک است که بین طرفین تقسیم میشود') }}
                </p>

                <h3 class="fs-5">{{ l('کمیسون رهن اجاره در قم') }}</h3>

                <p class="text-justify fs-base">
                {{ l('به ازای هر یک میلیون تومان رهن 6 هزار تومن بعلاوه 30 درصد مبلغ اجاره بها بعلاوه 10 هزار تومن بعلاوه 10 درصد مالیات ارزش افزوده می‌باشند.') }}
                

                </p>

                <!--h3 class="fs-base text-center text-danger">{{ l('نکته قابل توجه') }}</h3>
                <p class="text-center m-auto fw-bold  rounded-1 p-4 border-2 border border-dark bg-faded-info">
                {{ l('در مجموعه املاک کومه قراردادهای توافقی با 70 درصد تخفیف انجام می شود') }}
                </p-->

                <h2 class="custom-heading my-4">{{ l('نحوه محاسبه کمیسیون املاک در شهر کرج') }}</h2>
                <h3 class="fs-5">{{ l('کمیسون خریدو فروش در کرج') }}</h3>

                <p class="text-justify fs-base">
                {{ l('طبق مصوبه اتحادیه املاک البرز کمیسیون خرید و فروش ملک به صورت ثابت انجام می‌شود') }}  <br>
                {{ l('کل مبلغ کمیسیون خرید و فروش 75/0درصد از ارزش معامله می باشد که بین طرفین تقسیم می شود') }}
                </p>

                <h3 class="fs-5">{{ l('کمیسون رهن و اجاره در کرج') }}</h3>

                <p class="text-justify fs-base">
                {{ l('تبدیل مبلغ رهن به اجاره و جمع این مبلغ با اجاره‌ بهای ماهانه') }} <br>
                {{ l('تعیین 25/0 درصد از این مبلغ به عنوان حق کمیسیون مشاور می باشد') }} <br>
                {{ l('که مستاجر موظف به پرداخت نصف مبلغ کمیسون و مالک موظف به پرداخت کامل مبلغ است.') }} <br>
                {{ l('محاسبه 10 درصد از حق کمیسیون به عنوان مالیات بر ارزش افزوده و پرداخت آن به مشاور املاک') }}
                </p>

                <h2 class="custom-heading my-4">{{ l('نحوه محاسبه کمیسیون املاک در شهر اصفهان') }}</h2>
                <h3 class="fs-5">{{ l('کمیسون خریدو فروش در اصفهان') }}</h3>

                <p class="text-justify fs-base">
                {{ l('طبق مصوبه اتحادیه املاک اصفهان کمیسیون خرید و فروش ملک به صورت پله ایی محاسبه می‌شود و هر کدام از طرفین معامله موظف به پرداخت نیم درصد قیمت ملک تا سقف دویست میلیون تومان و ۰.۲۵ درصد برای مازاد قیمت به علاوه 10 درصد مالیات ارزش افزوده می‌باشند') }} <br>
                {{ l('تا سقف ۲۰۰ میلیون تومان ۰.۵ درصد هر کدام از طرفین') }} <br>
                {{ l('مازاد بر ۲۰۰ میلیون ۰.۲۵ درصد هر کدام از طرفین') }}
                </p>

                <h3 class="fs-5">{{ l('کمیسیون اجاره اصفهان') }}</h3>

                <p class="text-justify fs-base">
                {{ l('برای محاسبه کمیسیون رهن و اجاره در اصفهان بابت هر یک میلیون تومان رهن مبلغ هفت هزار و پانصد تومان به علاوه یک چهارم اجاره یک ماه همراه با درصد مالیات ارزش افزوده را هر کدام از طرفین قرارداد به مشاورین پرداخت می‌کنند.') }} <br>
                <b>{{ l('نکته') }}</b>{{ l(': تبدیل نرخ رهن به اجاره جهت محاسبه کمیسیون طبق بخشنامه اتحادیه املاک اصفهان') }}<u class="text-danger">{{ l('ممنوع') }}</u>{{ l('می‌باشد.') }}<br>
                {{ l('هر ۱ میلیون تومان رهن = ۷،۵۰۰ تومان') }} <br>
                {{ l('¼ مبلغ اجاره یک ماه') }} <br>
                {{ l('محاسبه 10 درصد از جمع اعداد بالا به عنوان مالیات ارزش افزوده و پرداخت کل این اعداد به مشاور') }} <br>
                {{ l('کمیسیون تمدید اجاره اصفهان') }} <br>
                {{ l('جهت تمدید قرارد اگر توافقی بین مشاور و طرفین صورت گرفته باشد کمیسیون به صورت توافقی دریافت می‌گردد در غیر این صورت کمیسیون به طور کامل دریافت می‌گردد') }} <br>

                </p>

                <h2 class="custom-heading my-4">{{ l('نحوه محاسبه کمیسیون املاک در شهر تبریز') }}</h2>
                <h3 class="fs-5">{{ l('کمیسیون خرید و فروش تبریز') }}</h3>
                <h3 class="fs-5">{{ l('در شهر تبریز محاسبه کمیسیون به صورت چند پله‌ای انجام می گردد') }}</h3>

                <p class="text-justify fs-base">
                {{ l('تا سقف ۲۰ میلیون تومان ۰.۷۵ درصد هر کدام از طرفین') }} <br>
                {{ l('مازاد بر ۲۰ میلیون تومان تا ۱۰۰ میلیون تومان ۰.۵ درصد هر کدام از طرفین') }} <br>
                {{ l('مازاد بر ۱۰۰ میلیون تومان تا ۳۰۰ میلیون تومان ۰.۳ درصد هر کدام از طرفین') }} <br>
                {{ l('مازاد بر ۳۰۰ میلیون تومان تا ۵۰۰ میلیون تومان ۰.۲ درصد هر کدام از طرفین') }} <br>
                {{ l('مازاد بر ۵۰۰ میلیون تومان ۰.۱ درصد هر کدام از طرفین') }} <br>
                <b>{{ l('کمیسیون اجاره تبریز') }}</b><br>
                {{ l('تبدیل مبلغ رهن به اجاره و جمع این مبلغ با اجاره‌بهای ماهانه') }} <br>
                {{ l('تعیین ۳۳ درصد از این مبلغ به عنوان حق کمیسیون مشاور') }} <br>
                {{ l('محاسبه 10 درصد از حق کمیسیون به عنوان مالیات بر ارزش افزوده و پرداخت آن به مشاور') }} <br>
                <b>{{ l('کمیسیون تمدید اجاره تبریز') }}</b><br>
                {{ l('کمیسیون تمدید اجاره ملک در شهر تبریز نیز برابر است با یک دهم مبلغ کمیسیون قرارداد اجاره به علاوه ۹ درصد مالیت ارزش افزوده بدین صورت که ابتدا مبلغ کمیسیون را محاسبه و مبلغ را تقسیم به ده می‌کنند.') }} <br>


                </p>
            </div>
      </section>

    </main>

@section('js')
<script>
    var kind = 1;
    function typechange(id)
    {
        console.log(id);
        if(id == 1)
        {
            kind = 1;
            $('.kind2').hide();
            $('.kind1').show();
        }
        else
        {
            kind = 2;
            $('.kind1').hide();
            $('.kind2').show();
        }
    }
    $(document).ready(function(){
        $('.btn-calculator').on('click',function(){
            $('.commission_show').removeClass('d-none');
            var commission = 0;
            if(kind == 1)
            {
                var price =  parseInt($('#price').val().replaceAll(',',''));
                //alert(price);
                if(price <= 10000000)
                {
                    commission = price * 0.01;
                }
                else
                {
                    commission = (price * 0.005) + 50000;
                }
                commission = commission + (commission*0.10);
            }
            else
            {
                var rahn =  parseInt($('#rahn').val().replaceAll(',',''));
                commission = (rahn / 1000000) * 6000;
                var rent =  parseInt($('#rent').val().replaceAll(',',''));
                if(rent <= 100000)
                {
                    commission = (rent * 0.4) + commission;
                }
                else
                {
                    commission = ((rent - 100000) * 0.3) + commission + 40000;
                }
                commission = commission + (commission*0.10);
            }
            $('.pricecommission').html(addCommas(parseInt(commission)));
            $('.pricecommission2').html(addCommas(parseInt(commission/2)));
            $('.pricecommission3').html(addCommas(parseInt((commission*0.3)/2)));
        })
    })
    function OnlyNumber(event,HasBullet){
        if(HasBullet){
            var blockSpecialRegex = /[a-zA-Zآ-ی~`!@#$%*'"^&()_={}[\]:;,<>+\/?-]/;
        }
        else{
            var blockSpecialRegex = /[a-zA-Zآ-ی~`!@#$%*'"^&()_={}[\]:;,.<>+\\/?-]/; } var key = String.fromCharCode(!event.charCode ? event.which : event.charCode); if (blockSpecialRegex.test(key)) { event.preventDefault(); } } "use strict";var delimiter=l("و"),zero=l("صفر"),negative=l("منفی"),letters=[["",l("یک"),l("دو"),l("سه"),l("چهار"),l("پنج"),l("شش"),l("هفت"),l("هشت"),l("نه")],["ده",l("یازده"),l("دوازده"),l("سیزده"),l("چهارده"),l("پانزده"),l("شانزده"),l("هفده"),l("هجده"),l("نوزده"),l("بیست")],["","",l("بیست"),l("سی"),l("چهل"),l("پنجاه"),l("شصت"),l("هفتاد"),l("هشتاد"),l("نود")],["",l("یکصد"),l("دویست"),l("سیصد"),l("چهارصد"),l("پانصد"),l("ششصد"),l("هفتصد"),l("هشتصد"),l("نهصد")],["",l("هزار"),l("میلیون"),l("میلیارد"),l("بیلیون"),l("بیلیارد"),l("تریلیون"),l("تریلیارد"),l("کوآدریلیون"),l("کادریلیارد"),l("کوینتیلیون"),l("کوانتینیارد"),l("سکستیلیون"),l("سکستیلیارد"),l("سپتیلیون"),l("سپتیلیارد"),l("اکتیلیون"),l("اکتیلیارد"),l("نانیلیون"),l("نانیلیارد"),l("دسیلیون"),l("دسیلیارد")]],decimalSuffixes=["",l("دهم"),l("صدم"),l("هزارم"),l("ده‌هزارم"),l("صد‌هزارم"),l("میلیونوم"),l("ده‌میلیونوم"),l("صدمیلیونوم"),l("میلیاردم"),l("ده‌میلیاردم"),l("صد‌‌میلیاردم")],prepareNumber=function(e){var t=e;return"number"==typeof t&&(t=t.toString()),t.length%3==1?t="00".concat(t):t.length%3==2&&(t="0".concat(t)),t.replace(/\\d{3}(?=\\d)/g,"$&*").split("*")},tinyNumToWord=function(e){if(0===parseInt(e,0))return"";var t=parseInt(e,0);if(t<10)return letters[0][t];if(t<=20)return letters[1][t-10];if(t<100){var r=t%10,n=(t-r)/10;return r>0?letters[2][n]+delimiter+letters[0][r]:letters[2][n]}var i=t%10,u=(t-t%100)/100,s=(t-(100*u+i))/10,a=[letters[3][u]],o=10*s+i;return 0===o?a.join(delimiter):(o<10?a.push(letters[0][o]):o<=20?a.push(letters[1][o-10]):(a.push(letters[2][s]),i>0&&a.push(letters[0][i])),a.join(delimiter))},convertDecimalPart=function(e){return""===(e=e.replace(/0*$/,""))?"":(e.length>11&&(e=e.substr(0,11)),l("ممیز")+Num2persian(e)+" "+decimalSuffixes[e.length])},Num2persian=function(e){e=e.toString().replace(/[^0-9.-]/g,"");var t=!1,r=parseFloat(e);if(isNaN(r))return zero;if(0===r)return zero;r<0&&(t=!0,e=e.replace(/-/g,""));var n="",i=e,u=e.indexOf(".");if(u>-1&&(i=e.substring(0,u),n=e.substring(u+1,e.length)),i.length>66)return"خارج از محدوده";for(var s=prepareNumber(i),a=[],o=0;o<s.length;o+=1){var l=tinyNumToWord(s[o]);""!==l&&a.push(l+letters[4][s.length-(o+1)])}return n.length>0&&(n=convertDecimalPart(n)),(t?negative:"")+a.join(delimiter)+n};String.prototype.toPersianLetter=function(){return Num2persian(this)},Number.prototype.toPersianLetter=function(){return Num2persian(parseFloat(this).toString())},String.prototype.num2persian=function(){return Num2persian(this)},Number.prototype.num2persian=function(){return Num2persian(parseFloat(this).toString())}; function toEnglishNumber(strNum) { var pn = ["۰", l("۱"), l("۲"), l("۳"), l("۴"), l("۵"), l("۶"), l("۷"), l("۸"), l("۹")]; // Persian var an = ["٠", l("١"), l("٢"), l("٣"), l("٤"), l("٥"), l("٦"), l("٧"), l("٨"), l("٩")]; // Arabic var en = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"]; var cache = strNum; for (var i = 0; i < 10; i++) {
            cache = cache.replace(new RegExp(pn[i], 'g'), en[i]); // Persian digits
            cache = cache.replace(new RegExp(an[i], 'g'), en[i]); // Arabic digits
        }
        return cache;
    }
    function SplitNumber(obj , type){
        var Getnumber= toEnglishNumber(obj.val()).replace(/,/g,'');
        obj.val(Getnumber.split("").reverse().join("").replace(/(.{3}\B)/g, "$1,").split("").reverse().join(""));
        @if(env('COUNTRY') != 'UAE')
        obj.parent().parent().find("#div"+type).html(obj.val().num2persian()+" تومان");

        @endif
    }

    window.SplitNumber=SplitNumber;
    function addCommas(nStr) {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }
</script>

@endsection
@include(ss('THEME').'.frontend.layouts.footer_v2',['cssClass'=>'intro'])
@endsection
