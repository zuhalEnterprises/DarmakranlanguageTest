@extends(ss('THEME') . '.frontend.layouts.intro.appnew_v2', [
'title' => l('گیلند ملک | چگونه میزبان شویم')])

@section('head')

<style>
        .host-box {
            position: relative;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            background-color: white;
            align-items: center;
            margin-top: calc(44px);
            border-top: 2px solid #086402;
            box-shadow: rgba(160, 160, 160, 0.7) 0px 3px 10px -3px;
            height: 100%;
        }

        .card-host-header {
            margin-top: calc(-44px);
            background: linear-gradient(0deg, #086402 0%, #086402 50%, rgb(255, 255, 255) 50%, rgb(255, 255, 255) 100%);
            box-shadow: unset;
            border-radius: 50%;
            width: 70px;
            height: 70px;
            display: flex;
            justify-content: center;
            align-items: center;
            transform: translateY(7px);
        }

        .host-icon {
            inset: 0px;
            margin: auto;
            border-radius: 50%;
            width: 64px;
            height: 64px;
            background-color: #086402;
            border: 4px solid rgb(255, 255, 255);
            display: flex;
            align-items: center;
            justify-content: center;
        }


        .card-host-body {
            padding: 1rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .host-p {
            font-size: 14px;
            font-weight: 400;
            font-variation-settings: "wght"400;
            color: rgb(64, 64, 64);
            line-height: 24px;
            text-align: justify;
            margin: 0px;
        }
        .fixed-button {
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1000;
    }
    </style>
@endsection

@section('main_content')
<main class="page-wrapper" style="background-color:#fff;">
    @include(ss('THEME') . '.frontend.layouts.header_rent')

    <section class="container mt-5 pt-5">
        <nav class="mb-3 pt-md-3 " aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">{{ l('خانه') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ l('چگونه میزبان شوم؟') }}</li>
            </ol>
        </nav>
    </section>
    <section class=" bg-primary mb-5">
        <div class="container py-4">
            <h2 class="fw-bold fs-5 text-white">{{ l('چگونه میزبان شوم؟') }}</h2>
            <p class="text-white mb-0">
                {{ l('نکات زیر را مطالعه کنید تا با اطلاعات کافی در گیلند ملک میزبان شوید و با خیال آسوده کسب درآمد کنید.') }}
            </p>
        </div>
    </section>

    <section class="container py-5">
        <div class="mb-4">
            <div class="text-center">
                <h4 class="fw-bold">
                    {{ l('1- اقامتگاه خودر را ثبت کنید') }}
                </h4>
                <p class="fs-base">
                    {{ l('حال می بایست برای معرفی اقامتگاه خود به گردشگران, یک نمایه (پروفایل) برای اقامتگاه خود ایجاد کنید‎.‎') }}
                </p>
            </div>
            <div class="row">
                <div class="col-12 col-lg-4">
                    <div class=" host-box">
                        <div color="#FFFFFF" class="card-host-header">
                            <i class="d-flex align-items-center justify-content-center fi-home fs-4 host-icon text-white"></i>
                        </div>
                        <div class="card-host-body">
                            <h3 class=" fs-5 mt-4" title="{{ l('نمایه اقامتگاه من حاوی چه مطالبی ست؟') }}">{{ l('نمایه اقامتگاه من حاوی چه مطالبی ست؟') }}</h3>
                            <p class="host-p">
                                {{ l('در ‎نمایه اقامتگاه‎, شما می بایست مشخصات دقیق منزل و امکانات قابل استفاده توسط میهمانان را مشخص کنید. ‎عکسهایی واضح و جدید‎ ‏از اقامتگاه خود فراهم نموده و‎ Upload ‎کنید, همچنین ‎نرخ اجاره بها و تقویم اجاره‎ منزل خود را نیز تنظیم کنید . در آخر مقرراتی که می باید توسط میهمانان رعایت شود را نیز مشخص کنید. ‎نمایه اقامتگاه شما درواقع بیانگر مشخصات و ویژگیهای واقعی ‏منزل شما برای گردشگران علاقه مند خواهد بود‎.‎') }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class=" host-box">
                        <div color="#FFFFFF" class="card-host-header">
                            <i class="d-flex align-items-center justify-content-center fi-home fs-4 host-icon text-white"></i>
                        </div>
                        <div class="card-host-body">
                            <h3 class=" fs-5 mt-4" title="{{ l('چه کسانی می‌توانند اقامتگاهم را اجاره کنند؟') }}">{{ l('چه کسانی می‌توانند اقامتگاهم را اجاره کنند؟') }}</h3>
                            <p class="host-p">
                                {{ l('شما در کنار ثبت مشخصات و امکانات اقامتگاه خود, مواردی همچون ‎ اجاره بها و مقررات منزل‎ را نیز تعیین می کنید. سپس نمایه اقامتگاه شما در وبسایت ‎منتشر‎ می شود و برای مسافرین و گردشگران به نمایش درمی آید. گردشگران با جستجو در وبسایت, در صورتی که مشخصات اقامتگاه شما را مناسب نیاز خود بیابند درصورت قبول مقررات منزل, برای اجاره اقامتگاه در بازه زمانی ‏مد نظر با گیلندملک تماس میگیرند.‏ درصورت تایید شما و پرداخت صورتحساب توسط مهمان، رزرو قطعی می شود.') }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class=" host-box">
                        <div color="#FFFFFF" class="card-host-header">
                            <i class="d-flex align-items-center justify-content-center fi-map-pin fs-4 host-icon text-white"></i>
                        </div>
                        <div class="card-host-body">
                            <h3 class=" fs-5 mt-4" title="{{ l('آیا میزبانی و رزرو اینترنتی سخت است؟') }}">{{ l('آیا میزبانی و رزرو اینترنتی سخت است؟') }}</h3>
                            <p class="host-p">
                                {{ l('امکانات تعبیه شده در سایت بگونه ای ست تا پس از صرف وقت کافی برای ثبت و انتشار اقامتگاه خود, بتوانید تمام مراحل میزبانی را طی فرایندی ساده و کاربردی و با صرف زمانی اندک, برای شما امکانپذیر نماید. با این وجود, ما از لحظه ثبت‌نام، ثبت اقامتگاه و آغاز میزبانی, در کنارتان هستیم و شما را در این مسیر هیجان انگیز همراهی میکنیم.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-secondary py-5">
        <div class="mb-4 container">
            <div class="text-center">
                <h4 class="fw-bold">
                    {{ l('2- برای ورود مهمانان آماده شوید') }}
                </h4>
                <p class="fs-base">
                    {{ l('میزبان های محبوب, به گرمی از میهمان خود استقبال می کنند. بعضی ورود میهمان را با چای و لبخند خاطره انگیز می کنند. اینکه چگونه محبوب میهمان خود می شوید با شماست.‎') }}
                </p>
            </div>
            <div class="row">
                <div class="col-12 col-lg-4">
                    <div class=" host-box">
                        <div color="#FFFFFF" class="card-host-header">
                            <i class="d-flex align-items-center justify-content-center fi-bell fs-4 host-icon text-white"></i>
                        </div>
                        <div class="card-host-body">
                            <h3 class=" fs-5 mt-4" title="{{ l('چگونه از دریافت درخواست رزرو مطلع شوم؟') }}">{{ l('چگونه از دریافت درخواست رزرو مطلع شوم؟') }}</h3>
                            <p class="host-p">{{ l('برای سرعت بخشیدن به فرایند رزرو, ثبت درخواست رزرو توسط میهمان یا قطعی شدن رزرو با بهره گیری از سامانه اس ام اس متنی  به اطلاع میزبان می‌رسد تا در اسرع وقت از وضعیت رزرو آگاهی یافته و اقدامات لازم را به انجام برساند. در مواقع ضروری تیم پشتیبانی گیلندملک نیز با دو طرف رزرو تماس خواهند گرفت. هرگونه تغییری در وضعیت رزرو, به همین روشها به اطلاع دو طرف خواهد رسید.') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class=" host-box">
                        <div color="#FFFFFF" class="card-host-header">
                            <i class="d-flex align-items-center justify-content-center fi-bell fs-4 host-icon text-white"></i>
                        </div>
                        <div class="card-host-body">
                            <h3 class=" fs-5 mt-4" title="{{ l('فرایند تحویل اقامتگاه چگونه است؟') }}">{{ l('فرایند تحویل اقامتگاه چگونه است؟') }}</h3>
                            <p class="host-p">
                                {{ l('پس از قطعی شدن رزرو اقامتگاه, سند رزرو قطعی حاوی اطلاعات کامل رزرو , نام و نام خانوادگی, تعداد نفرات, تاریخ و ساعت ورود و خروج, جزییات صورتحساب پرداخت شده, آدرس دقیق اقامتگاه و شماره تماس میهمان و میزبان برای هر دو طرف ارسال می گردد. توصیه می شود میزبان پیش از شروع سفر با میهمان تماس گرفته و هماهنگی های لازم برای نحوه و زمان تحویل اقامتگاه به ایشان را به انجام برساند تا میهمان با خیالی آسوده سفر خود را آغاز نماید.') }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class=" host-box">
                        <div color="#FFFFFF" class="card-host-header">
                            <i class="d-flex align-items-center justify-content-center fi-map-pin fs-4 host-icon text-white"></i>
                        </div>
                        <div class="card-host-body">
                            <h3 class=" fs-5 mt-4" title="{{ l('کارمزد گیلندملک چگونه محاسبه می شود؟') }}">{{ l('کارمزد گیلندملک چگونه محاسبه می شود؟') }}</h3>
                            <p class="host-p">
                                {{ l('عضویت در گیلندملک, ثبت حساب کاربری, و ثبت و انتشار اقامتگاه شما در وبسایت بصورت کاملا رایگان انجام می پذیرد. تنها پس از به اجاره رفتن اقامتگاه, گیلندملک ۱۰٪ از کل مبلغ اجاره بهای تعیین شده توسط میزبان را بعنوان کارمزد خدمات خود کسر نموده و مابقی مبلغ اجاره بها را به حساب بانکی میزبان واریز می کند. با توجه به الزام اداره امور مالیاتی، 0.9 درصد ارزش افزوده هم به صورتحساب میزبان اضافه می شود. لذا مجموع کسورات از صورتحساب 10.9 درصد می‌باشد.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-secondary py-5">
        <div class="mb-4 container">
            <div class="text-center fixed-button bg-faded-dark rounded p-3">
                <a class="btn btn-primary rounded-4 btn-sm order-lg-3" href="/rental/estate/create">
                    <i class="fi-plus me-2"></i>{{ l('ثبت رایگان اقامتگاه') }}</a>
            </div>
        </div>
    </section>

    @include(ss('THEME') . '.frontend.layouts.footer_rent', ['cssClass' => 'intro'])
</main>
@endsection

@section('js')

@endsection
