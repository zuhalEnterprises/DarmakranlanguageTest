@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
    'title' => l('ویرایش اطلاعات'),
])
@section('main_content')
    <!-- Vendor Styles-->
    <link rel="stylesheet" media="screen" href="/vendor/simplebar/dist/simplebar.min.css" />
    <link rel="stylesheet" media="screen"
        href="/vendor/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css" />
    <link rel="stylesheet" media="screen" href="/vendor/filepond/dist/filepond.min.css" />
    <!-- Main Theme Styles + Bootstrap-->
    <main class="page-wrapper">
        <!-- Navbar-->
        @include(ss('THEME').'.frontend.layouts.header_v2', ['isadmin' => true])
        <!-- Page content-->
        <div class="container pt-5 pb-lg-4 mt-5 mb-sm-2">
            <!-- Breadcrumb-->
            <nav class="mb-4 pt-md-3" aria-label="Breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">{{ l('خانه') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ l('اطلاعات حساب کاربری') }}</li>
                </ol>
            </nav>
            <!-- Page content-->


            <div class="row">
                <!-- Sidebar-->

                @include('frontend.layouts.sidebar', ['menu' => '6'])
                <!-- Content-->

                <div class="col-lg-9 col-md-12 mb-5 account">
                    <form class="bg-gray-100 p-6 rounded-2xl mt-2 md:mt-0 " method="POST" action="{{url('/profile/info/update')}}" enctype="multipart/form-data" id="myform">
                        @csrf
                        @method('put')
                        <input type="hidden" id="activity_type" name="activity_type" />
                        <input type="hidden" name="images1" class="images1" />
                        <input type="hidden" name="images2" class="images2" />
                        <input type="hidden" name="photoshow" class="photo" value="{{!empty($currentUser)?0:1}}" />
                    <h1 class="h2">{{ l('اطلاعات حساب کاربری') }}</h1>

                    <div class="progress mb-4" style="height: .25rem;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <label class="form-label fw-bold" for="name">{{ l('تغییر رمز عبور') }}</label>
                        <input class="form-control" type="password" type="text" id="password" name="password">
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label class="form-label fw-bold" for="mobile">{{ l('تکرار رمز عبور جدید') }}<span
                                class="text-danger">*</span></label>
                        <input class="form-control" type="password" id="password_confirmation" name="password_confirmation">
                    </div>


                    <div class="d-flex align-items-center justify-content-between border-top mt-4 pt-4 pb-1">
                        <button type="submit" id="btnsave" class="btn btn-primary px-3 px-sm-4" type="button">{{ l('ذخیره تغییرات') }}</button>
                    </div>
                    </form>
                    @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif
                </div>

            </div>

        </div>
    </main>
    @include(ss('THEME').'.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
@endsection
@section('js')
    <script src="/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/vendor/simplebar/dist/simplebar.min.js"></script>
    <script src="/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>
    <script src="/vendor/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.min.js"></script>
    <script src="/vendor/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
    <script src="/vendor/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.min.js"></script>
    <script src="/vendor/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.min.js"></script>
    <script src="/vendor/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.min.js"></script>
    <script src="/vendor/filepond/dist/filepond.min.js"></script>
    <!-- Main theme script-->
    <script src="/js/theme.min.js"></script>
@endsection
