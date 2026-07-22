<style>
    .sortable{
        /* color:blue !important; */
        cursor: pointer
    }
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
<div class="border rounded p-3 bg-secondary mb-2">
    <div class="d-flex align-items-center gap-3 flex-wrap">
        <p class="m-0">
            <b>{{ l('تعداد نتایج:') }}</b>
            {{$totalCount}}
        </p>

    </div>
</div>
<div class="my-3 table-responsive table-p">
    <table class="table table-bordered table-striped table-hover">
        <thead class="table-primary">
            <tr>

                <th class="text-center" scope="col" class="sortable" onclick="sort('estate_id')">{{ l('ملک') }}</th>
                <th class="text-center" scope="col" onclick="sort('estate_expert_id')">{{ l('مشاور فروش') }}</th>
                <th class="text-center" scope="col" class="sortable" onclick="sort('customer_id')">{{ l('مشتری') }}</th>
                <th class="text-center" scope="col" onclick="sort('customer_expert_id')">{{ l('مشاور خرید') }}</th>

                <th scope="col" class="sortable text-center" onclick="sort('send_at')">{{ l('تاریخ ارسال به مشتری') }}</th>
                <th scope="col" class="sortable text-center">{{ l('وضعیت') }}</th>
                <th class="text-center" scope="col">{{ l('مشاهده شده') }}</th>
                <th class="text-center" scope="col">{{ l('ابزار') }}</th>
            </tr>
        </thead>
        <tbody>

            @foreach($relationEstateCustomer as $relEstateCustomer)
            <tr>
                <td width="100" class="text-center">
                    @if($relEstateCustomer->estate_id>0 && $relEstateCustomer->estate != null)
                    <a href="{{$relEstateCustomer->estate->url()}}" target="_blank">
                        {{$relEstateCustomer->estate_id}}
                    </a>
                    @else
                    -
                    @endif
                </td>
                <td align="center" class="text-center">
                    @if($relEstateCustomer->estate_expert_id>0 && $relEstateCustomer->estate_expert != null)
                    <a class="text-body text-decoration-none" href="/agents/{{$relEstateCustomer->estate_expert->id}}" target="_blank">
                        {{$relEstateCustomer->estate_expert->fullname()}}
                    </a>
                    @else
                    -
                    @endif
                </td>
                <td width="100" class="text-center">
                    @if($relEstateCustomer->customer_id>0 && $relEstateCustomer->customer != null)
                    <a href="/customer/{{$relEstateCustomer->customer->id}}/{{$relEstateCustomer->customer->link_rewrite}}" target="_blank">
                        {{$relEstateCustomer->customer_id}}
                    </a>
                    @else
                    -
                    @endif
                </td>
                <td align="center" class="text-center">
                    @if($relEstateCustomer->customer_expert_id>0 && $relEstateCustomer->customer_expert != null)
                    <a class="text-body text-decoration-none" href="/agents/{{$relEstateCustomer->customer_expert->id}}" target="_blank">
                        {{$relEstateCustomer->customer_expert->fullname()}}
                    </a>
                    @else
                    -
                    @endif
                </td>

                <td class="text-center">
                    @if($relEstateCustomer->send_at != null)
                    {{toPersianDate($relEstateCustomer->send_at)}}
                    @else
                    ارسال نشده
                    @endif
                </td>
                <td class="text-center">
                    {{$relEstateCustomer->strstatus()}}
                </td>
                <td width="100" class="text-center">

                    @if($relEstateCustomer->seen_estate)
                        مشاهده شده
                    @else
                        مشاهده نشده
                    @endif
                </td>


                <td class="text-center">
                    <button class="btn btn-icon btn-light btn-xs rounded-circle shadow-sm" type="button" id="contextMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fi-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu my-1" aria-labelledby="contextMenu2">
                        @if($relEstateCustomer->status == 0 || $relEstateCustomer->status == 1)
                        <li>
                            <a class="dropdown-item"  onclick="confirm({{$relEstateCustomer->id}})" href="javascript:void(0)" class="flex items-center gap-2 p-2 hover:text-blue-500">

                                {{ l('تائید') }}
                            </a>
                        </li>
                        @endif
                        @if($relEstateCustomer->status == 0 || $relEstateCustomer->status == 2)
                        <li>
                            <a class="dropdown-item"  onclick="reject({{$relEstateCustomer->id}})" href="javascript:void(0)" class="flex items-center gap-2 p-2 hover:text-blue-500">

                                {{ l('رد') }}
                            </a>
                        </li>
                        @endif
                        @if($relEstateCustomer->priority == 0 || $relEstateCustomer->priority == 2)
                        <li>
                            <a class="dropdown-item"  onclick="priority(1 , {{$relEstateCustomer->id}})" href="javascript:void(0)" class="flex items-center gap-2 p-2 hover:text-blue-500">
                                {{ l('انتقال به اولویت نقره‌ای') }}
                            </a>
                        </li>
                        @endif
                        @if($relEstateCustomer->priority == 1 || $relEstateCustomer->priority == 2)
                        <li>
                            <a class="dropdown-item"  onclick="priority(0 , {{$relEstateCustomer->id}})" href="javascript:void(0)" class="flex items-center gap-2 p-2 hover:text-blue-500">
                                {{ l('انتقال به اولویت برنزی') }}
                            </a>
                        </li>
                        @endif
                        @if($relEstateCustomer->priority == 1 || $relEstateCustomer->priority == 0)
                        <li>
                            <a class="dropdown-item"  onclick="priority(2 , {{$relEstateCustomer->id}})" href="javascript:void(0)" class="flex items-center gap-2 p-2 hover:text-blue-500">
                                {{ l('انتقال به اولویت طلایی') }}
                            </a>
                        </li>
                        @endif

                        @if($currentUser->id == $relEstateCustomer->estate_expert_id)
                            <a style="cursor: pointer" class="dropdown-item"  class="flex items-center gap-2 p-2 hover:text-blue-500" onclick="addComment({{$relEstateCustomer->id}} , 'estate')">
                                <i class=" opacity-60 me-2 fa-light fa-comment"></i>
                                 {{ l('ثبت نظر') }}
                            </a>
                        @endif
                        @if($currentUser->id == $relEstateCustomer->customer_expert_id)
                        <a style="cursor: pointer" class="dropdown-item"  class="flex items-center gap-2 p-2 hover:text-blue-500" onclick="addComment({{$relEstateCustomer->id}} , 'customer')">
                            <i class=" opacity-60 me-2 fa-light fa-comment"></i>
                            {{ l('ثبت نظر') }}
                        </a>
                        @endif
                    </ul>

                </td>

            </tr>

            @endforeach

        </tbody>
    </table>
</div>

<script>
    function editCommentRelation(){

        relation_id = $('#relId').val();
        comment = $('#comment').val();
        type = $('#type').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            }
        });
        $.ajax({
            url: '/estate/editRelationComment',
            type: "POST",
            data: {
                'relation_id': relation_id,
                'comment': comment,
                'type': type
            },
            success: function(data) {
                var res = data.data;
                $('#relId').val('');
                $('#type').val('');
                $('#comment').val('');
                $('#commentModal').modal('toggle');
                swal({
                    title: l("نظرتان با موفقیت ثبت شد"),
                    message: "",
                    confirmButtonColor: '#025EC6',
                    confirmButtonText: l('باشه'),
                    type: "success",
                    timer: 2000
                });
                CheckSend();
            },
        });
    }
</script>
<div class="modal fade" id="commentModal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header px-4 py-3">
                <h4 class="modal-title" id="exampleModalLabel">{{ l('افزودن') }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding:40px 30px;">
                <div class="row">
                    <input type="hidden" name="relId" id="relId" value="">
                    <input type="hidden" name="type" id="type" value="">
                    <div class="col-md-6 col-lg-12 col-sm-12">
                        <label>{{ l('توضیحات') }}</label>
                        <textarea class="form-control" id="comment" name="comment"></textarea>
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-12">
                        <label>&nbsp;</label>
                        <button id="form_add" class="form-control btn btn-primary" onclick="editCommentRelation()" style="width:100%">{{ l('اضافه کردن نظر') }}</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


