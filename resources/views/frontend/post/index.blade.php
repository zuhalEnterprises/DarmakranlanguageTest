@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
    'title' => l('لیست مطالب')
])
@section('main_content')
<link href="{{asset('admin/css/date_picker/kamadatepicker.css')}}" rel="stylesheet">
<script src="{{asset('admin/js/date_picker/kamadatepicker.js')}}"></script>
<!-- main -->
<main class="page-wrapper">
    @include(ss('THEME').'.frontend.layouts.header_v2', ['isadmin' => true])
    <!-- Page content-->
    <div class="container pt-5 pb-lg-4 mt-5 mb-sm-2">
        <!-- Page content-->
            <div class="row">
                @include('frontend.layouts.sidebar', ['menu' => '18'])
                <div class="col-lg-12">
                    <section class="box">
                        <header class="box-header with-border clearfix">{{ l('لیست مطالب') }}
                            <span class="panel-heading-action pull-left">
                                <a href="{{url('admin/posts/create?type='.$post_type)}}" class="btn btn-info">
                                    <i class="fa fa-plus add-item"></i>{{ l('افزودن') }}</a>
                               {{-- @include('admin.component.panel_heading_buttons', [
                                    'route' => 'posts', 'items' => [ 'export', 'refresh' ]
                                ])--}}
							</span>
                        </header>
                        <div class="box-body table-responsive no-padding">
                            <input type="hidden" name="csrf-token" value="{{ csrf_token() }}">
                            <table class="table table-advance table-striped table-hover">
                                <thead class="filter" id="">
                                <tr>
                                    <th class="text-center" style="width: 50px;">#</th>
                                    <th class="text-center fixed-width-sm">{{ l('شناسه') }}
                                        <a href="{{url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' =>'id']))}}"><i class="fa fa-caret-down"></i></a>
                                        <a href="{{url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' =>'-id']))}}"><i class="fa fa-caret-up"></i></a>
                                    </th>
                                    <th class="text-center" style="width: 50px;">{{ l('تصویر') }}</th>
                                    @if($post_type == 'post')
                                        <th class="text-center">{{ l('دسته بندی') }}</th>
                                    @endif
                                    <th class="text-center">{{ l('عنوان') }}</th>
                                    <th class="text-center">{{ l('تاریخ انتشار') }}
                                        <a href="{{url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' =>'created_at']))}}"><i class="fa fa-caret-down"></i></a>
                                        <a href="{{url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' =>'-created_at']))}}"><i class="fa fa-caret-up"></i></a>
                                    </th>
                                    <th class="text-center">{{ l('وضعیت') }}</th>
                                    <th></th>
                                </tr>
                                <tr class="nodrag filter bg-gray-light  row_hover">
                                    <form method="get" action="/admin/posts">
                                        <input type="hidden" name="type" value="{{$post_type}}">
                                        <input type="hidden" name="filter[type]" value="{{$post_type}}">
                                        <th class="text-center"></th>
                                        <th class="center"><input type="text" class="filter form-control" name="filter[id]" value=""></th>
                                        <th class="text-center">--</th>
                                        @if($post_type == 'post')
                                            <th>
                                                <select class="filter center form-control" name="filter[categories.id]">
                                                    <option value="">{{ l('انتخاب کنید') }}</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                                    @endforeach
                                                </select>
                                            </th>
                                        @endif
                                        <th><input type="text" class="filter form-control" name="filter[title]" value=""></th>
                                        <th class="text-center">
                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="icon-calendar"></span></div>
                                                <input type="text" name="created_at" id="created_at" class="filter form-control number" readonly>
                                            </div>
                                            <input type="hidden" class="filter form-control" id="input_created_at" name="input_created_at"/>
                                            <script>
                                                initDatePicker('created_at');
                                            </script>
                                        </th>
                                        <th class="center">
                                            <select class="filter center form-control" name="filter[active]">
                                                <option value="">{{ l('انتخاب کنید') }}</option>
                                                <option value="1">{{ l('فعال') }}</option>
                                                <option value="0">{{ l('غیرفعال') }}</option>
                                            </select>
                                        </th>
                                        <th class="actions">
									    <span class="pull-right">
                                            <button type="submit" class="btn btn-info submit-filter">
                                                <i class="icon-search"></i> {{ l('جستجو') }}
                                            </button>
										</span>
                                        </th>
                                        <div class="cls"></div>
                                    </form>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach( $model as $item)
                                    <tr>
                                        <td class="text-center"><input type="checkbox" class="checkboxes" name="ids[]" value="{{$item->id}}" /></td>
                                        <td class="text-center" data-id="{{$item->id}}">{{$item->id}}</td>
                                        <td class="text-center" data-id="{{$item->id}}">

                                            <img src="{{$item->img()}}" width="24" height="24"/>
                                        </td>
                                        @if($post_type == 'post')
                                            <td>{{!empty($item->categories) && $item->categories->count() > 0 ? implode(', ',$item->categories->pluck('name')->toArray()) : ''}}</td>
                                        @endif
                                        <td>{{$item->title}}</td>
                                        <td class="text-center">{{$item->publish_date}}</td>
                                        <td class="text-center">
                                            @if($item->active == 1)
                                                <a href="javascript:void(0);"
                                                   data-id="{{$item->id}}" id="itemID-{{$item->id}}"
                                                   class="status change_status itemStatus-{{$item->id}}" title="{{ l('فعال') }}">
                                                    <i class="fa fa-check text-green active"></i>
                                                </a>
                                            @else
                                                <a href="javascript:void(0);"
                                                   data-id="{{$item->id}}" id="itemID-{{$item->id}}"
                                                   class="status change_status itemStatus-{{$item->id}}" title="{{ l('غیرفعال') }}">
                                                    <i class="fa fa-close text-red inactive"></i>
                                                </a>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a data-toggle="tooltip" title="{{ l('ویرایش') }}" data-id="{{$item->id}}"
                                               data-name="{{$item->title}}" data-type="{{$post_type}}"
                                               class="icon edit ">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a data-toggle="tooltip" title="{{ l('حذف') }}" data-id="{{$item->id}}"
                                               id="itemID-{{$item->id}}" data-name="{{$item->title}}"
                                               class="icon remove">
                                                <i class="fa fa-trash "></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="panel-footer clearfix">
                            @include('admin.component.data_table_group_selector', ['route' => 'posts'])
                            @include('admin.component.data_table_pagination')
                        </div>
                    </section>
                </div>
            </div>
    </div>
</main>
    <script type="text/javascript">
        $(document).ready(function () {
            var CSRF_TOKEN = $('input[name="csrf-token"]').attr('value');

            // edit
            $("a.edit").on("click", function () {
                var id = $(this).data('id');
                var type = $(this).data('type');
                location.href = "/admin/posts/"+id+"/edit?type="+type;
            });

            // remove item
            $("a.remove").on("click", function () {
                var id = $(this).data('id');
                var name = $(this).data('name');
                swal({
                            title: l("حذف") + name + " !",
                            text: l("آیا از حذف گزینه مورد نظر اطمینان دارید؟"),
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            cancelButtonText: l('لغو'),
                            confirmButtonText: l('بله'),
                            showLoaderOnConfirm: true,
                            preConfirm: function () {
                                return new Promise(function (resolve) {
                                    $.ajax({
                                                url: '/admin/posts/' + id,
                                                type: 'DELETE',
                                                data: {_token: CSRF_TOKEN},
                                                dataType: 'json'
                                            })
                                            .done(function (response) {
                                                swal({
                                                    title: l('گزینه مورد نظر با موفقیت حذف شد.'),
                                                    text: "",
                                                    type: 'success',
                                                    allowOutsideClick: false,
                                                }).then((result)=>{
                                                    location.reload();
                                            });

                                            })
                                            .fail(function () {
                                                swal('خطا!', l('حذف با مشکل مواجه شد!'), 'error');
                                            });
                                });
                            },
                            allowOutsideClick: ()=>!swal.isLoading() }); }); // change status $("a.change_status").on("click", function () { var id = $(this).data('id'); $.get("/admin/posts/status/" + id, function (data, status) { if (data.result) { toast({ type: 'success', title: 'گزینه مورد نظر فعال شد.' }); $("a.itemStatus-" + id).attr('title','فعال'); $("a.itemStatus-" + id+" i").removeClass("fa fa-close text-red inactive").addClass("fa fa-check text-green active"); } else { toast({ type: 'error', title: 'گزینه مورد نظر غیرفعال شد.' }); $("a.itemStatus-" + id).attr('title','غیرفعال'); $("a.itemStatus-" + id+" i").removeClass("fa fa-check text-green active").addClass("fa fa-close text-red inactive"); } }); }); });
    </script>

@endsection
