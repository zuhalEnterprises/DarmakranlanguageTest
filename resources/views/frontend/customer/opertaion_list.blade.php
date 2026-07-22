
@php
    $customerid = 0;
@endphp
@foreach($customerOperations as $customerOperation)
@php
    $customerid = $customerOperation->customer_id;
@endphp
<div class=" py-2 px-1  rounded border-bottom box">
    <div class="d-flex justify-content-between mb-1">

        <div class="d-flex align-items-center">
            @if($customerOperation->expert)
            <img class="rounded-circle ms-1 me-1" src="{{$customerOperation->expert->photo()}}" width="40" alt="Avatar">
            <div class="d-flex flex-column gap-1">
                <div class="pe-2">
                    <h6 class="fs-base mb-0">{{$customerOperation->expert->fullname()}}</h6>
                </div>
            </div>
            @endif
        </div>
        <span class="text-muted fs-sm">{{toPersianDate($customerOperation->created_at)}}</span>
    </div>
    <div class="d-flex justify-content-between mb-1 vv">
        <div class="pe-2">
            <span class="mb-0"><b>{{l('نوع')}} </b>: {{l($customerOperation->typeName())}}</span>
        </div>
        @if($customerOperation->type==2 && $customerOperation->customer_id > 0 && env('COUNTRY') != 'UAE')
        <div>
            <span class="text-muted fs-sm">
                {{ l('ملک:') }}
                <a target="_blnak" href="/v/{{$customerOperation->estate_id}}"> کد ملک: {{$customerOperation->estate_id > 0  ? $customerOperation->estate_id : ''}}</a>
            </span>
        </div>
        @endif
    </div>
    <p class="pe-2 mb-0 comment{{$customerOperation->id}}">{{$customerOperation->comment}}</p>
    <div class="d-flex gap-2 justify-content-end">
        @if($currentUser->isAdmin())
        <a href="javascript:void(0)" class="btn btn-danger btn-xs fw-bold" onclick="if(confirm('{{l('آیا از حذف مطمئن هستید؟')}}'))removeOperation({{$customerOperation->id}})"> {{l('حذف')}} <i class="fi fi-trash"></i> </a>
        @endif
        @if($currentUser->isAdmin() || ($currentUser->isExpert() && $currentUser->id == $customerOperation->expert_id))
        <a href="javascript:void(0)" class="btn btn-primary btn-xs fw-bold" onclick="updateOperation({{$customerOperation->id}})">{{l('ویرایش')}} <i class="fi fi-edit"></i> </a>
        @endif
    </div>
</div>
@endforeach
<div class="modal fade" id="modal-editreview" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header d-block position-relative border-0 pb-0 px-sm-5 px-4">
            <h4 class="modal-title mt-4 text-center font-vazir">{{l('ویرایش عملکرد')}}</h4>
            <button class="btn-close position-absolute top-0 end-0 mt-3 me-3" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 px-4">
                <input type="hidden" name="operationid" id="operationid">
                <div class="mb-4">
                    <label class="form-label" for="comment">{{l('توضیحات')}} </label>
                    <textarea class="form-control" id="editcomment" name="editcomment" rows="5" placeholder="{{l('توضیحات')}}" required></textarea>
                    <div class="invalid-feedback">{{l('نظر خود را ثبت کنید')}}</div>
                </div>
                <button class="btn btn-primary d-block w-100 mb-4 btnEditOperation" type="submit">{{l('ویرایش عملکرد')}}</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var boxes = $(".boxes .box");
        var count = boxes.length;
        for (var i = 0; i < count; i++) {
            if (i % 2 === 1) {
                boxes[i].classList.add("bg-white");
            } else {
                boxes[i].classList.add("bg-secondary");
            }
        }
    });
    function removeOperation(id){
        $.get("/profile/operationEstate/destroy/"+id , function (data, status)
        {
            toast({
                type: 'success',
                text: '{{l('با موفقیت حذف شد')}}'
            });
            getOperations({{$customerid}});
        });
    }
    function updateOperation(id){
        $('#editcomment').val($('.comment' + id).html());
        $('#operationid').val(id);
        $('#modal-editreview').modal('toggle');
    }
    $(document).ready(function() {

        $(".btnEditOperation").click(function() {
            $('#modal-editreview').modal('toggle');
            comment = $('#editcomment').val();
            id = $('#operationid').val();
            if (comment.length == 0) {
                $('#editcomment').focus();
                return false;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            });
            $.ajax({
                url: '/estate/editOperation',
                type: "POST",
                data: {
                    'id': id,
                    'comment': comment,
                },
                success: function(data) {
                    var res = data.data;
                    var operation = res.operation_id;
                    $('#comment').val('');

                    swal({
                        title: "{{l('عملکرد با موفقیت ویرایش شد')}}",
                        message: "",
                        confirmButtonColor: '#025EC6',

                        confirmButtonText: '{{l('باشه')}}',
                        type: "success",
                        timer: 2000
                    });
                    getOperations({{ $customerid }});
                },
            });
        });

    })
</script>
