@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
'title' => l('بلاگ'),
])
@section('main_content')
<link rel="stylesheet" href="{{asset('/mainpage/css/cropper.css')}}">
<!-- Vendor Styles-->
<link rel="stylesheet" media="screen" href="/vendor/simplebar/dist/simplebar.min.css" />
<link rel="stylesheet" href="{{asset('/frontend/vendor/dropzone/dropzone.min.css')}}" />
<style>
    .table-p{
        max-height:600px;
        overflow:auto;
        }

    thead tr:nth-child(1) th{
        position: sticky;
        top: 0;
        z-index: 10;
    }
</style>
<!-- Main Theme Styles + Bootstrap-->
<main class="page-wrapper">
    @include(ss('THEME').'.frontend.layouts.header_v2', ['isadmin' => true])
    <!-- Page content-->
    <div class="container pt-5 pb-lg-4 mt-5 mb-sm-2">
        <!-- Page content-->
        <div class="row">
            @include('frontend.layouts.sidebar', ['menu' => '6'])
            <!-- Page content-->
            <div class="col-lg-9 col-md-12 mb-5 account add-property">
                <!-- Breadcrumb-->
                <nav class="mb-4 pt-md-3" aria-label="Breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{l('نمایش لیست بلاگ')}}</li>
                    </ol>
                </nav>
                <!-- Page content-->
                <div class="mb-4 d-flex align-items-center justify-content-between">
                    <h1 class="h2">{{l('نمایش لیست بلاگ')}}</h1>
                    <a href="/profile/createBlog" class="btn btn-primary" >
                                    <i class="fi fi-plus"></i>{{ l('افزودن') }}</a>
                </div>
                <div class="my-3 table-responsive table-p">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th valign="middle" class="header" style="text-align:center" scope="col">#</th>
                                <th valign="middle" class="header" style="text-align:center" scope="col">{{ l('شناسه') }}</th>
                                <th valign="middle" class="header" style="text-align:center" scope="col">{{ l('تصویر') }}</th>
                                <th valign="middle" class="header" style="text-align:center" scope="col">{{ l('دسته بندی') }}</th>
                                <th valign="middle" class="header" style="text-align:center" scope="col">{{ l('عنوان') }}</th>
                                <th valign="middle" class="header" style="text-align:center" scope="col">{{ l('تاریخ انتشار') }}</th>
                                <th valign="middle" class="header" style="text-align:center" scope="col">{{ l('وضعیت') }}</th>
                                <th valign="middle" class="header" style="text-align:center" scope="col">{{ l('ابزار') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td valign="middle" align="center">
                                    <!-- <div class="form-check"> -->
                                        <input class="form-check-input" type="checkbox" >
                                    <!-- </div> -->
                                </td>
                                <td valign="middle" align="center">1</td>
                                <th valign="middle" scope="row" >
                                    <a class="d-block " style="width: 100px;  height:80px;" href=l("/v/9190/آپارتمان-پردیسان") target="_blank">
                                        <img class="w-100 object-cover rounded-1 " src="http://127.0.0.1:8000/upload/images/estate/2023/09/img_6512fd0f80de0_medium.jpg" alt="real estate">
                                    </a>
                                </th>
                                <td valign="middle" align="center">{{ l('اقتصادی') }}</td>
                                <td valign="middle" align="center">{{ l('تورم املاک') }}</td>
                                <td valign="middle" align="center">
                                    {{ l('۱۹:۱۷ ۱۴۰۲/۰۷/۰۴') }}
                                </td>
                                <td valign="middle" align="center">
                                    <i class="fi-check me-2 text-success"></i>
                                </td>

                                <td valign="middle" align="center">
                                    <button class="btn btn-icon btn-light btn-xs rounded-circle shadow-sm" type="button" id="contextMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fi-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu my-1" aria-labelledby="contextMenu2">

                                        <li>
                                            <a class="dropdown-item" target="_blank" href=l("/v/9190/آپارتمان-پردیسان")>
                                                <i class="fa-light fa-eye opacity-60 me-2"></i>{{ l('مشاهده جزئیات') }}</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" target="_blank" href="/estates/9190/edit">
                                                <i class=" opacity-60 me-2 fa-light fa-edit"></i>
                                                {{ l('ویرایش ملک') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" style="cursor:pointer" onclick="if(confirm(l('آیا از حذف این ملک مطمئن هستید؟')))destroy(9190)">
                                                <i class=" opacity-60 me-2 fa-light fa-trash-can"></i>
                                                {{ l('حذف ملک') }}
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td valign="middle" align="center">
                                    <!-- <div class="form-check"> -->
                                        <input class="form-check-input" type="checkbox" >
                                    <!-- </div> -->
                                </td>
                                <td valign="middle" align="center">2</td>
                                <th valign="middle" scope="row" >
                                    <a class="d-block " style="width: 100px;  height:80px;" href=l("/v/9190/آپارتمان-پردیسان") target="_blank">
                                        <img class="w-100 object-cover rounded-1 " src="http://127.0.0.1:8000/upload/images/estate/2023/09/img_6512fd0f80de0_medium.jpg" alt="real estate">
                                    </a>
                                </th>
                                <td valign="middle" align="center">{{ l('اجتماعی') }}</td>
                                <td valign="middle" align="center">{{ l('خانواده های قمی') }}</td>
                                <td valign="middle" align="center">
                                    {{ l('۱۹:۱۷ ۱۴۰۲/۰۷/۰۴') }}
                                </td>
                                <td valign="middle" align="center">
                                    <i class="fi-x me-2 text-danger"></i>
                                </td>

                                <td valign="middle" align="center">
                                    <button class="btn btn-icon btn-light btn-xs rounded-circle shadow-sm" type="button" id="contextMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fi-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu my-1" aria-labelledby="contextMenu2">

                                        <li>
                                            <a class="dropdown-item" target="_blank" href=l("/v/9190/آپارتمان-پردیسان")>
                                                <i class="fa-light fa-eye opacity-60 me-2"></i>{{ l('مشاهده جزئیات') }}</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" target="_blank" href="/estates/9190/edit">
                                                <i class=" opacity-60 me-2 fa-light fa-edit"></i>
                                                {{ l('ویرایش ملک') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" style="cursor:pointer" onclick="if(confirm(l('آیا از حذف این ملک مطمئن هستید؟')))destroy(9190)">
                                                <i class=" opacity-60 me-2 fa-light fa-trash-can"></i>
                                                {{ l('حذف ملک') }}
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td valign="middle" align="center">
                                    <!-- <div class="form-check"> -->
                                        <input class="form-check-input" type="checkbox" >
                                    <!-- </div> -->
                                </td>
                                <td valign="middle" align="center">3</td>
                                <th valign="middle" scope="row" >
                                    <a class="d-block " style="width:100px; height:80px;" href=l("/v/9190/آپارتمان-پردیسان") target="_blank">
                                        <img class="w-100 object-cover rounded-1" src="http://127.0.0.1:8000/upload/images/estate/2023/09/img_6512fd0f80de0_medium.jpg" alt="real estate">
                                    </a>
                                </th>
                                <td valign="middle" align="center">{{ l('سیاسی') }}</td>
                                <td valign="middle" align="center">{{ l('سیاست املاک در ایران') }}</td>
                                <td valign="middle" align="center">
                                    {{ l('۱۹:۱۷ ۱۴۰۲/۰۷/۰۴') }}
                                </td>
                                <td valign="middle" align="center">
                                    <i class="fi-x me-2 text-danger"></i>
                                </td>

                                <td valign="middle" align="center">
                                    <button class="btn btn-icon btn-light btn-xs rounded-circle shadow-sm" type="button" id="contextMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fi-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu my-1" aria-labelledby="contextMenu2">

                                        <li>
                                            <a class="dropdown-item" target="_blank" href=l("/v/9190/آپارتمان-پردیسان")>
                                                <i class="fa-light fa-eye opacity-60 me-2"></i>{{ l('مشاهده جزئیات') }}</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" target="_blank" href="/estates/9190/edit">
                                                <i class=" opacity-60 me-2 fa-light fa-edit"></i>
                                                {{ l('ویرایش ملک') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" style="cursor:pointer" onclick="if(confirm(l('آیا از حذف این ملک مطمئن هستید؟')))destroy(9190)">
                                                <i class=" opacity-60 me-2 fa-light fa-trash-can"></i>
                                                {{ l('حذف ملک') }}
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td valign="middle" align="center">
                                    <!-- <div class="form-check"> -->
                                        <input class="form-check-input" type="checkbox" >
                                    <!-- </div> -->
                                </td>
                                <td valign="middle" align="center">4</td>
                                <th valign="middle" scope="row" >
                                    <a class="d-block"  style="width: 100px;  height:80px;" href=l("/v/9190/آپارتمان-پردیسان") target="_blank">
                                        <img class="w-100 object-cover rounded-1" src="http://127.0.0.1:8000/upload/images/estate/2023/09/img_6512fd0f80de0_medium.jpg" alt="real estate">
                                    </a>
                                </th>
                                <td valign="middle" align="center">{{ l('اقتصادی') }}</td>
                                <td valign="middle" align="center">{{ l('تورم املاک') }}</td>
                                <td valign="middle" align="center">
                                    {{ l('۱۹:۱۷ ۱۴۰۲/۰۷/۰۴') }}
                                </td>
                                <td valign="middle" align="center">
                                    <i class="fi-check me-2 text-success"></i>
                                </td>

                                <td valign="middle" align="center">
                                    <button class="btn btn-icon btn-light btn-xs rounded-circle shadow-sm" type="button" id="contextMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fi-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu my-1" aria-labelledby="contextMenu2">

                                        <li>
                                            <a class="dropdown-item" target="_blank" href=l("/v/9190/آپارتمان-پردیسان")>
                                                <i class="fa-light fa-eye opacity-60 me-2"></i>{{ l('مشاهده جزئیات') }}</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" target="_blank" href="/estates/9190/edit">
                                                <i class=" opacity-60 me-2 fa-light fa-edit"></i>
                                                {{ l('ویرایش ملک') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" style="cursor:pointer" onclick="if(confirm(l('آیا از حذف این ملک مطمئن هستید؟')))destroy(9190)">
                                                <i class=" opacity-60 me-2 fa-light fa-trash-can"></i>
                                                {{ l('حذف ملک') }}
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
@include(ss('THEME').'.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
@endsection
@section('js')

@endsection
