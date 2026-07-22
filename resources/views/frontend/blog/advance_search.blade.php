@foreach( $model as $item)
    <article class="col pb-2 pb-md-1">
        <a class="d-block position-relative mb-3" href="{{$item->url()}}">
            <img class="d-block rounded-3 img-fluid img-thumbnail" style="width:100%;height:300px;object-fit: cover;padding:5px" src="{{crop($item->img() , 416 , 416)}}" alt="{{$item->title}}">
        </a>
        <a class="fs-sm text-uppercase text-decoration-none" href="#"></a>
        <h3 class="h5 mb-2 pt-1">
            <a class="nav-link"   href="{{$item->url()}}">{{$item->title}}</a>
        </h3>
        <p class="mb-3">{!!$item->description!!}</p>
        <a
            class="d-flex align-items-center text-decoration-none" href="#">
            <div class="pe-2">
                <h6 class="fs-base text-nav lh-base mb-1"></h6>
                <div class="d-flex text-body fs-sm">
                    <span class="me-2 pe-1">
                        <i class="fi-calendar-alt opacity-70 mt-n1 ms-1 align-middle"></i>
                        {{$item->publish_date}}
                    </span>
                </div>
            </div>
        </a>
    </article>
@endforeach
