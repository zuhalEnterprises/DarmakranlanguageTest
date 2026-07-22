@extends(ss('THEME') . '.frontend.layouts.intro.appnew_v2', [
'title' => ss('SITE_NAME'),
])
@section('head')

<style>
    @media (min-width: 500px) {

        .card-horizontal .card-img-top,
        .card-horizontal .card-img-bottom {
            max-width: 33%;
            min-width: 33%;
        }
    }
</style>

@endsection
@section('main_content')
<main class="page-wrapper">
    @include(ss('THEME') . '.frontend.layouts.header_v2')



    <div class="container pt-3 pb-lg-4 mt-5 mb-sm-2">
        <div class="row align-items-start">
            @include(ss('THEME') . '.frontend.layouts.sidebar', ['menu' => 'users' , 'menutype'=>'bongah'])
            <main class="col-12 col-md-7 mx-auto">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs justify-content-center" role="tablist">
                    <li class="nav-item">
                        <a href="#home1" class="nav-link active" data-bs-toggle="tab" role="tab">
                            {{ l('آژانس') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#profile1" class="nav-link" data-bs-toggle="tab" role="tab">
                            {{ l('شخصی') }}
                        </a>
                    </li>

                </ul>

                <!-- Tabs content -->
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="home1" role="tabpanel">
                        <div class="">
                            <!-- Item -->
                            <div class="card card-hover card-horizontal rounded border mb-2 p-4">

                                <div class="card-body d-flex flex-column p-0">
                                    <h3 class="h6 mb-2 fs-base">
                                        <a class="nav-link stretched-link" href="real-estate-single-v1.html">{{ l('اقامتگاه ویلایی | 200 متر مربع') }}</a>
                                    </h3>
                                    <div class="mt-auto">
                                        <p class="mb-2 fs-sm text-muted">{{ l('توسط رادمهر * شهر املاک') }}</p>
                                        <p class="mb-2 fs-sm text-muted">{{ l('نوع: فروش') }}</p>
                                        <p class="mb-0 fs-sm text-muted">{{ l('6 ساعت پیش در صفاشهر') }}</p>
                                    </div>

                                </div>
                                <div class="card-img-top position-relative rounded flex-column order-first order-md-last mb-3 mb-lg-0" style="background-image: url(https://gilandmelk.com/upload/images/estate/2024/05/img_66535eaf1723a_large.jpg);">
                                    <a class="stretched-link" href="real-estate-single-v1.html"></a>
                                    <span class="position-absolute  bottom-0  py-2 start-0 end-0 rounded-bottom text-center text-white" style="background-color:#156b23;">{{ l('منتشر شده') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile1" role="tabpanel">
                        <p class="fs-5">
                            {{ l('این قسمت مربوط به آگهی‌های شخصی املاک شماست. برای ثبت آگهی در این قسمت می‌توانید از بسته‌های شخصی خود استفاده کنید یا هزینهٔ آن را بپردازید.') }}
                        </p>
                    </div>
                </div>
            </main>
        </div>

    </section>

    @endsection
    @section('js')


    <script>
        // Sidebar desktop
        $(document).ready(function() {
            $(".sub-items, .sub-sub-items").hide();
            $(".item").click(function() {
                $('#filter_sidebar').hide()
                if ($(this).children(".sub-items").is(":visible")) {
                    $(this).children(".sub-items").hide();
                    $(".item").show();
                } else {
                    $(".item").not(this).hide();
                    $(this).children(".sub-items").show();
                    $(this).siblings().hide();
                }
                $(".sub-item").show();
                $(".sub-sub-items").hide();
            });

            $(".sub-item").click(function(e) {
                e.stopPropagation();
                $('#filter_sidebar').show()
                if ($(this).children(".sub-sub-items").is(":visible")) {
                    $(this).children(".sub-sub-items").hide();
                    $(".sub-item").show();
                } else {
                    $(this).siblings().hide();
                    $(this).children(".sub-sub-items").show();
                }
            });

            $(".sub-sub-items li").click(function(e) {
                e.stopPropagation();
            });
        });
    </script>

    @endsection
