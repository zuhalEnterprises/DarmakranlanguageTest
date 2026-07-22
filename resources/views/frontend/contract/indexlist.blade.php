<table id="example" style="width: 100%" class="table table-bordered table-striped table-hover" dir="rtl">
    <thead class="table-primary">
            <tr>
                {{-- <th class="text-center" style="width: 50px;">{{ l('ردیف') }}</th>--}}
                <th class="text-center fixed-width-sm">{{ l('شناسه') }}
                    <a href="{{url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' =>'id']))}}"><i class="icon-caret-down"></i></a>
                    <a href="{{url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' =>'-id']))}}"><i class="icon-caret-up"></i></a>
                </th>

                <th class="text-center">{{ l('کد قرارداد') }}</th>
                <th class="text-center">{{ l('تاریخ ثبت قرارداد') }}
                    <a href="{{url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' =>'register_at']))}}"><i class="icon-caret-down"></i></a>
                    <a href="{{url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' =>'-register_at']))}}"><i class="icon-caret-up"></i></a>
                </th>
                <th class="text-center">{{ l('نوع قرارداد') }}</th>
                <th class="text-center">{{ l('نوع ملک') }}</th>
                <th class="text-center">{{ l('فروشنده') }}</th>
                <th class="text-center">{{ l('خریدار') }}</th>

                <th class="text-center">{{ l('ابزار') }}</th>
            </tr>

    </thead>
    <tbody>
            @foreach( $model as $item)
            <tr id="row_{{$item->id}}">
                {{-- <td class="text-center"><input type="checkbox" class="checkboxes" name="ids[]" value="{{$item->id}}" /></td>--}}
                {{-- <td class="text-center">{{toPersianNumbers($loop->iteration)}}</td>--}}
                <td tabindex="0" class="text-center"> {{$item->id}} </td>
                <td class="text-center"><span class="bg-gray label text-sm">{{$item->contractid}}</span></td>
                <td align="center">{{($item->register_at > '1970-01-01') ? toPersianDateYdm($item->register_at):''}}</td>
                <td align="center">{{$item->typeName()}}</td>
                <td align="center">{{mapEstateCategoryName($item->estate_type)}}</td>
                <td  align="center" class="text-center">
                    {{$item->estate_name}} <br>
                    {{$item->estate_phone}} <br>
                    {{$item->estate_nationalId}}
                </td>
                <td  align="center" class="text-center">
                    {{$item->customer_name}} <br>
                    {{$item->customer_phone}} <br>
                    {{$item->customer_nationalId}}
                </td>
                <td  align="center" class="text-center">
                    <button class="btn btn-icon btn-light btn-xs rounded-circle shadow-sm" type="button" id="contextMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fi-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu my-1" aria-labelledby="contextMenu2" style="">
                        @if($currentUser->isAdmin() || $currentUser->hasAnyRole('admin_super'))
                        <li>
                            <a class="dropdown-item"  href="/profile/contract/{{$item->id}}/edit">
                                <i class=" opacity-60 me-2 fa-light fa-edit"></i>
                                {{ l('ویرایش قرارداد') }}
                            </a>
                        </li>
                        @endif
                        @if($currentUser->isAdmin() || $currentUser->hasAnyRole('admin_super'))
                        <li>
                            <a class="dropdown-item"href="/profile/contractearn/{{$item->id}}" >
                                <i class="fa-light fa-eye opacity-60 me-2"></i>{{ l('نمایش پرداختی های قرارداد') }}</a>
                        </li>
                        @endif
                        @if($currentUser->isAdmin() || $currentUser->hasAnyRole('admin_super'))
                        <li>
                            <a class="dropdown-item" style="cursor:pointer" onclick="destroy({{$item->id}})" >
                                <i class=" opacity-60 me-2 fa-light fa-trash-can"></i>
                                {{ l('حذف قرارداد') }}
                            </a>
                        </li>
                        @endif
                    </ul>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
<script>
  function destroy(id){

swal({
text: " {{l('آیا از حذف گزینه مورد نظر اطمینان دارید')}} ?",
type: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
cancelButtonText: "{{l('لغو')}}",
confirmButtonText: "{{l('بله')}}",
showLoaderOnConfirm: true,
preConfirm: function () {
    return new Promise(function (resolve) {
        $.get("/profile/Contract/destroy/"+id, function(data, status) {
            swal({
                    title: "",
                    text: "{{l('گزینه مورد نظر با موفقیت حذف شد')}}.",
                    type: 'success',
                }).then((result)=>{
                    $('#row_'+id).remove();
            });
        })
    })
},
allowOutsideClick: ()=>!swal.isLoading()
});
}
</script>
