@extends(ss('THEME') . '.frontend.layouts.intro.appnew_v2', [
'title' => ss('SITE_NAME'),
])
@section('head')



@endsection
@section('main_content')
<main class="page-wrapper">
    @include(ss('THEME') . '.frontend.layouts.header_v2')
    <div class="container mt-5 pt-3 p-0">
        <div class="row g-0 ">


            <!-- Page content-->
            <div class="main col-12 position-relative overflow-hidden px-3">
                <!-- Breadcrumb-->
                <nav class="pt-2 pt-lg-5" aria-label="Breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                        <li class="breadcrumb-item"><a href="/">{{l('ثبت نام پنل املاک ')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{l('ثبت نام  آژانس املاک ')}}</li>
                    </ol>
                </nav>
            </div>

        </div>
    </div>
    <section class="container">
        <div class=" m-auto  border p-3 p-lg-4 col-lg-4 rounded">
            <p>
                {{ l('نتیجه اعتبارسنجی ثبت نام آژانس بصورت پیامکی به اطلاعتان رسانده می شود.') }}
            </p>
            <p>
                {{ l('کاربر محترم کلبه با استفاده از این پنل از مزایای زیر بهره مند می‌شوید:') }}
            </p>
            <h3 class="fs-5">
                {{ l('مدیریت مشاوران املاک') }}
            </h3>
            <p>
                {{ l('می توانید به تعداد نامحدود مشاور به پنل خود اضافه کنید و به آنها به صورت روزانه یا ماهانه سهمیه کیف پول اختصاص دهید.') }}
            </p>
            <h3 class="fs-5">
                {{ l('بررسی فوری آگهی های ثبت شده') }}
            </h3>
            <p>
                {{ l('آگهی های ثبت شده در پنل املاک سریع تر از بقیه آگهی ها بررسی و منتشر میشوند.') }}
            </p>
            <h3 class="fs-5">
                {{ l('نردبان گروهی آگهی ها') }}
            </h3>
            <p>
                {{ l('با نردبان گروهی آگهی ها تنها با یک کلیک آگهی های خود را در صدر لیست های دیوار نگه دارید.') }}
            </p>
            <h3 class="fs-5">
                {{ l('گزارش مصرف مشاوران') }}
            </h3>
            <p>
                {{ l('میزان مصرف آگهی و نردبان مشاوران و همینطور آمار بازدید آگهی های منتشر شده را بررسی کنیدو') }}
            </p>


        </div>
    </section>


    @endsection
