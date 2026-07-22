@section('title', l('جستجوهای ذخیره شده'))
@extends('frontend.profile.layouts.panel')
@section('panel_content')

        @if(count($searches) == 0)
            <p class="p-top text-center">{{ l('اطلاعاتی جهت نمایش وجود ندارد!') }}</p>
        @else

            <div class="row">
                <!---------------table-------------------->
                <div class="table-responsive p-3">
                    <table class="border-0 shadow table table-borderless table-hover" >
                        <thead>
                        <tr class="bg1-primary">
                            <th scope="col" class="font-weight-bold">{{ l('عنوان جستجو') }}</th>
                            <th scope="col" class="font-weight-bold">{{ l('آدرس اینترنتی') }}</th>
                            <th scope="col" class="font-weight-bold">{{ l('عملیات') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($searches as $item)
                            <tr id="s-{{$item->id}}">
                                <td scope="row">{{$item->title}}</td>
                                <td class="table-trash">
                                    <a href="{{$item->url}}" target="_blank" class="text-primary"><i class="fa fa-earth"></i>{{ l('نمایش جستجو') }}</a>
                                </td>
                                <td class="table-trash">
                                    <a class="search-del text-danger" data-id="{{$item->id}}" href="javascript:;"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>
                <!--------------end-table---------------->
            </div>

        @endif


    <script type="text/javascript">
        $(document).ready(function () { }); // remove item $(".search-del").on("click", function () { var id = $(this).data('id'); $.get("/profile/searches/" + id +"/delete", function (data, status) { if (data.result == 1) { toast({ type: 'error', text: 'گزینه مورد نظر با موفقیت حذف شد.' }); $("#s-" + id).remove(); } }); });
    </script>
@endsection
