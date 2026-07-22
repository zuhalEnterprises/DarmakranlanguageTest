<div class="modal fade" id="modalCity" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel"
     aria-hidden="true" style="z-index: 99999;top:0%;bottom:0% !important;height:auto">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div style="width:100%">
                    <div style="width:100%" class="d-flex justify-content-between">
                        <h5 class="modal-title" id="exampleModalPreviewLabel">{{ l('انتخاب استان') }}</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div style="width:100%;clear:both" class="mt-2">
                        <input class="form-control" id="cityListSearch" type="text" placeholder="{{ l('جستجوی سریع نام استان...') }}">

                    </div>
                </div>
            </div>
            <div class="modal-body city-search" style="overflow:auto;height: 420px;">
                <!--<select class="mdb-select md-form colorful-select dropdown-primary visible-xs" searchable=l("نام شهر")>-->
                <input id="cit" type="hidden" value=''>

                <!--div id="returnpr" class="d-none">
                    <div style="cursor:pointer" class="d-flex justify-content-first align-items-center name pb-3">

                        <i class="fa fa-arrow-right"></i>
                        {{ l('&nbsp;&nbsp;&nbsp;بازگشت به استان ها') }}
                    </div>
                    <hr/>
                </div-->
                <div id="province1" class="mt-2">

                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal City -->

