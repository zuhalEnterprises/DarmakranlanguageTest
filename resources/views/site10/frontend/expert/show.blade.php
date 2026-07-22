@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2',['title'=>$user->fullname()])
@section('head')
<style>
    .object-fit-cover {
        object-fit: cover;
    }

    .pic-expert {
        width: 165px;
        height: 165px;
    }

    @media (min-width: 768px) {
                .pic-expert {
                width: 200px;
                height: 200px;
            }
        }
</style>
@endsection
@section('main_content')
    <!-- main -->
    <main class="page-wrapper">
        @include(ss('THEME').'.frontend.layouts.header_v2')

        <!-- Page content-->
        <div class="bg-secondary mt-5 pt-5">
            <section class="container mb-4">
                <!-- Breadcrumb-->
                <nav class="mb-3 pt-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                        <li class="breadcrumb-item"><a href="/{{$selectedCity}}/agents/search">{{l('کارشناسان')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> {{l('نمایش کارشناس')}}</li>
                    </ol>
                </nav>
            </section>
            <section class="container my-4 border rounded-1 p-4 bg-white">
                <div class="d-flex gap-2 gap-md-3">
                    <div class="avatar-export">
                        <img class="rounded-1 object-fit-cover pic-expert" style="max-height:200px" alt="{{$user ? $user->name:''}}" src="{{$user ? $user->photo():''}}">
                    </div>
                    <div class="d-flex flex-column gap-2">
                        <h2 class="m-0">
                            {{$user->fullname()}}
                        </h2>
                        <p class="fw-light m-0 fs-sm text-black-50">
                            @foreach($user->roles as $role)
                            @if($role->id == 9)
                            {{l('کارشناس '.($user->activity_type == 1 ? l('فروش') : ($user->activity_type == 2 ? l('اجاره') : l('فروش و اجاره'))))}}

                            @endif
                            @endforeach
                        </p>
                        <p class="m-0">
                            {{$user->bio}}
                        </p>
                        <div class="d-flex gap-1 justify-content-center mt-5">
                            @if($user->phone != '')
                            <a class="btn btn-secondary fw-bold" style="color:red" href="tel:{{!empty($user)?$user->phone:''}}">
                                <i class="fi-phone mt-n1 me-2 align-middle opacity-60"></i>
                                {{ l('تلفن') }}
                            </a>
                            @endif

                            @if($user->whatsapp != '')
                            <a class="btn btn-secondary fw-bold" style="color:green" href="https://wa.me/{{$user->whatsapp}}">
                                <i class="fi-whatsapp mt-n1 me-2 align-middle opacity-60" ></i>
                                Whatsapp
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
            <section class="container pb-md-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h2 class="h3 mb-0 ">{{l('لیست ملک های فعال')}}</h2>
                </div>
                <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside tns-nav-outside-flush mx-n2"
                    dir="ltr">
                    <div class="tns-carousel-inner row gx-4 mx-0 pt-3 pb-4"
                        data-carousel-options="{&quot;items&quot;: 4, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2},&quot;768&quot;:{&quot;items&quot;:3},&quot;992&quot;:{&quot;items&quot;:4}}}">
                        <!-- Item-->
                        @foreach( $user->estates as $estate)
                        <div class="col">
                            @include(ss('THEME').'.frontend.estate.card' , ['estate' => $estate])
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>

            </div>
    </main>
@include(ss('THEME').'.frontend.layouts.footer_v2',['cssClass'=>'intro'])
@endsection
