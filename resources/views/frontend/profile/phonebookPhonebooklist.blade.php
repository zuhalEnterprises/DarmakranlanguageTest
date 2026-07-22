@if(count($modelPhonebook)>0)
<div class="border rounded p-3 bg-secondary mb-2">
    <div class="d-flex align-items-center gap-3 flex-wrap">
        <p class="m-0">
           {{ l('تلفن های خصوصی') }}
        </p>

    </div>
</div>
<table class="table table-bordered table-striped table-hover">
    <thead class="table-primary">
        <tr>

            <th valign="middle" style="text-align:center" scope="col">{{l('نام')}}</th>
            <th valign="middle" style="text-align:center" scope="col">{{ l('تلفن') }}</th>
            <th class="text-center" scope="col">{{ l('توضیحات') }}</th>
            <th class="text-center" scope="col"> {{l('ابزار')}}</th>
        </tr>
    </thead>
    <tbody>

@foreach($modelPhonebook as $item)
<tr>

    <td  valign="middle" align="center">{{$item->name}} </td>
    <td valign="middle" align="center">
        {{$item->phone}}
    </td>
    <td valign="middle" align="center">
        {{$item->description}}
    </td>
    <td valign="middle" align="center">
        <button class="btn btn-icon btn-light btn-xs rounded-circle shadow-sm" type="button" id="contextMenu2" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fi-dots-vertical"></i>
        </button>
        <ul class="dropdown-menu my-1" aria-labelledby="contextMenu2">
            <li>
                <a class="dropdown-item"  href="/profile/phonebook/edit/{{$item->id}}">
                    <i class="fa-light fa-edit opacity-60 me-2"></i> {{ l('ویرایش') }}
                </a>
            </li>
            <li>
                <a class="dropdown-item del" href="javascript:void(0)" onclick="deleteTodoItem({{$item->id}})">
                    <i class="fa-light fa-trash-can opacity-60 me-2"></i> {{ l('حذف') }}
                </a>
            </li>
        </ul>
    </td>
</tr>
@endforeach
</tbody>
</table>

@endif
