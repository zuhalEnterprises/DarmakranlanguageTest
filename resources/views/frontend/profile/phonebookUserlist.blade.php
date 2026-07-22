@if(count($modelUser)>0)
<div class="border rounded p-3 bg-secondary mb-2">
    <div class="d-flex align-items-center gap-3 flex-wrap">
        <p class="m-0">
            {{ l('لیست کاربران') }}
        </p>

    </div>
</div>
<table class="table table-bordered table-striped table-hover">
    <thead class="table-primary">
        <tr>
            <th valign="middle" style="text-align:center" scope="col">
                {{l('کد')}}
            </th>
            <th valign="middle" style="text-align:center" scope="col">{{l('عکس')}}</th>
            <th valign="middle" style="text-align:center" scope="col">{{l('نام')}}</th>
            <th valign="middle" style="text-align:center" scope="col">{{l('نام کاربری')}}</th>
            <th class="text-center" scope="col"> {{l('نقش')}} </th>

        </tr>
    </thead>
    <tbody>

@foreach($modelUser as $item)
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
                {{ l($role->title) }}
                @if(!$loop->last)<br><hr style="margin: 5px;"/>@endif
            @endforeach
        </label>
    </td>
</tr>
@endforeach
</tbody>
</table>
<hr>
@endif
