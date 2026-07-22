@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', ['title' => l('بنگاه های املاک')])
@section('main_content')
    <!-- main -->
    <main class="page-wrapper">
        @include(ss('THEME').'.frontend.layouts.header_v2')
        <section class="container mt-5 mb-lg-5 mb-4 pt-5 pb-lg-5">
            <!-- Breadcrumb-->
            <nav class="mb-3 pt-md-5" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page"> {{l('بنگاه های املاک')}}</li>
                </ol>
            </nav>

            <div class="my-4">
                <div class="row"  id="agent-list-wrapper">
                    <div class="col-lg-4 mb-3">
                        <div class="d-flex d-md-block d-lg-flex align-items-center p-3 mb-2 border rounded-1 ">
                            <img class="rounded-circle" src="https://kolbeh.ir/upload/images/profile/img_kJ75TxMv44CqHQ2m.jpg"  style="width:110px;height:110px" alt="{{ l('املاک بنفش') }}" />
                            <div class="pt-md-2 pt-lg-0 pe-3 pe-md-0 pe-lg-3">
                                <a href="#" class="text-decoration-none text-dark fw-bold fs-lg mb-0">
                                    {{ l('املاک بنفش') }}
                                </a>
                                <ul class="list-unstyled fs-sm mt-3 mb-0">
                                    <li>
                                        <a class="nav-link fw-normal p-0" >
                                            <i class="fi-map-pin opacity-60 me-2"></i>
                                            {{ l('آدرس: قم، زنبیل آباد، خ 20 متری امام حسین') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link fw-normal p-0" href="tel:09335512584">
                                            <i class="fi-phone opacity-60 me-2"></i>09335512584</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>
    @include(ss('THEME').'.frontend.layouts.footer_v2',['cssClass'=>'intro'])
@endsection
@section('js')

@endsection
