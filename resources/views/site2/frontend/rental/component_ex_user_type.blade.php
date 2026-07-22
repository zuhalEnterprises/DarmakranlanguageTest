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

<div class="border rounded p-3 bg-secondary mb-2">
    <div class="d-flex align-items-center gap-3 flex-wrap">
        <p class="m-0">
            <b>{{ l('تعداد نتایج:') }}</b>
            {{$totalCount}}
        </p>

    </div>
</div>
<div class="table-p">
<table class="table table-bordered table-striped table-hover">
    <thead class="table-primary">
        <tr>
            <th valign="middle" style="text-align:center" scope="col">
                {{ l('کد') }}
            </th>
            <th valign="middle" style="text-align:center" scope="col">{{ l('عکس') }}</th>
            <th valign="middle" style="text-align:center" scope="col">{{ l('نام') }}</th>
            <th valign="middle" style="text-align:center" scope="col">{{ l('نام کاربری') }}</th>
            <th class="text-center" scope="col">{{ l('نقش') }}</th>
            <th class="text-center" scope="col">{{ l('وضعیت') }}</th>
            @if($currentUser->isAdmin())
            <th valign="middle" style="text-align:center" scope="col">{{ l('ابزار') }}</th>
            @endif
        </tr>
    </thead>
    <tbody>

@foreach($model as $item)
<tr>
    <td valign="middle" align="center">{{$item->id}}</td>
    <td valign="middle" align="center">
        @if(!empty($item->photo))
        <img src="{{ $item->photo() }}" width="48px" style="max-height: 80px;max-width: 100px;"/>
        @else
        <img src="/upload/images/avatar_man.png" width="48px" />
        @endif
    </td>
    <td  valign="middle" align="center">{{$item->fullname()}} </td>
    <td valign="middle" align="center">
        {{$item->username}}
    </td>
    <td valign="middle" align="center">
        <label >
            @foreach($item->roles as $role)
                {{ $role->title }}
                @if(!$loop->last)<br><hr style="margin: 5px;"/>@endif
            @endforeach
        </label>
    </td>
    <td valign="middle" align="center">
        @if($item->status == 1)
            مجاز
        @elseif($item->status == 2)
            معلق
        @elseif($item->status == -1)
            در انتظار تائید
        @endif

    </td>
    <td valign="middle" align="center">
        <button class="btn btn-icon btn-light btn-xs rounded-circle shadow-sm" type="button" id="contextMenu2" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fi-dots-vertical"></i>
        </button>
        <ul class="dropdown-menu my-1" aria-labelledby="contextMenu2">
            
            <li>
                <a  class="dropdown-item"  target="_blank" href="/rental/users/edit/{{$item->id}}">
                    <i class=" opacity-60 me-2 fa-light fa fa-edit"></i>
                    {{ l('ویرایش') }}
                </a>
            </li>
            <li style="text-align: right;">

                <a  class="dropdown-item remove"  onclick="return destroy({{$item->id}})" style="cursor:pointer">
                    <i class=" opacity-60 me-2 fa-light fa-trash-can"></i>
                    {{ l('حذف') }}
                </a>
            </li>

        </ul>
    </td>
</tr>

@endforeach
</tbody>
</table>
</div>
<script>

    jQuery(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });
});
</script>
<style>
    .clickable-row{cursor: pointer}
</style>
<script>

</script>
<style>
    .sortable{
        /* color:blue !important; */
        cursor: pointer
    }
    .table > :not(caption) > * > * {
        padding: 0.5rem;
    }
</style>
