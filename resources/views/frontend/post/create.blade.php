@php($text = $post_type == 'post' ? l('مطلب') : l('صفحه'))
@php($page_title = l('ایجاد').$text)
@section('title', $page_title)
@extends('admin.layouts.content')
@section('head')
    <!--CKEditor-->
    <script src="{{asset('/vendor/tinymce/tinymce.min.js') }}"></script>
{{--    <link href="{{asset('admin/css/treeview.css')}}" rel="stylesheet">--}}
@endsection
@section('main_content')

        <div class="row">
            <div class="col-lg-12">
                @if ($errors->any())
                    <div class="alert alert-block alert-danger fade in">
                        <button data-dismiss="alert" class="close close-sm" type="button">
                            <i class="fa fa-close"></i>
                        </button>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form role="form" method="POST" action="{{url('/admin/posts')}}"
                      enctype="multipart/form-data" onsubmit="return getTags()">
                    {{csrf_field()}}
                    <input type="hidden" name="type" value="{{$post_type}}">
                <section class="box">
                    <header class="box-header with-border clearfix">{{$page_title}}</header>
                    <div class="box-body" style="padding: 15px !important">

                        <div class="form-group row">
                            <label for="cat_name" class="control-label col-lg-3">
                                <span>{{ l('تصویر') }}</span>
                            </label>

                            <div class="col-lg-9">
                                <div class="col-sm-9">
                                    <div class="input-group m-bot15">
                                            <span class="input-group-addon">
                                                <i class="icon-file"></i>
                                            </span>
                                        <input type="text" class="form-control input-lg" id="upload-file-info" readonly>
                                            <span class="input-group-addon select-image">
                                                <span class="btn btn-white btn-file btn-image">
                                                <input type="file" name="image" id="image" onchange="$('input#upload-file-info').val(this.files[0].name)">
                                                <i class="icon-folder-open"></i>{{ l('انتخاب تصویر') }}
                                                </span>
                                            </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($post_type == 'post' && 0)
                        <div class="form-group row">
                            <label class="control-label col-lg-3">{{ l('دسته بندی') }}</label>
                            <div class="control-label col-lg-9">

                                <div class="custom-panel">
                                    <div class="tree-panel-heading-controls clearfix" style="display:none">
                                        <div class="tree-actions pull-left">
                                            <a href="#" id="collapse-tree" class="btn btn-white"
                                               style="display: none;">
                                                <i class="icon-collapse-alt"></i>{{ l('بستن همه') }}
                                            </a>
                                            <a href="#" id="expand-tree" class="btn btn-white"
                                               style="display: inline-block;">
                                                <i class="icon-expand-alt"></i>{{ l('باز کردن همه') }}
                                            </a>
                                        </div>
                                    </div>
                                    <ul id="tree" class="noselect">
                                        @foreach($categories as $category)
                                            @if(count($category->childes) == 0)
                                                <li class="tree-item ">
                                                    <input type="checkbox" name="cat_id[]" id="cat_id"
                                                           value="{{$category->id}}">
                                                                    <span class="tree-item-name" id="id-{{$category->id}}">
                                                                        <i class="tree-dot"></i>
                                                                        {{ $category->name }}
                                                                    </span>
                                                </li>
                                            @else
                                                <li class="tree-folder ">
                                                    <input type="checkbox" name="cat_id[]" id="cat_id"
                                                           value="{{$category->id}}">
                                                                    <span class="tree-folder-name"
                                                                          id="id-{{$category->id}}">
                                                                        <i class=""></i>
                                                                        {{ $category->name }}
                                                                    </span>
                                                    @if(count($category->childes))
                                                        @include('admin.category.manage_child',[
                                                        'childes' => $category->childes,
                                                        'input' => [
                                                            'type'=>'checkbox',
                                                            'name' => 'cat_id[]',
                                                            'id' => 'cat_id',
                                                            'class' => 'parent'
                                                            ]
                                                        ])
                                                    @endif
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>

                                </div>

                            </div>
                        </div>
                        @endif
                        <div class="form-group row">
                            <label class="control-label col-lg-3 required">
                                <span class="label-tooltip" data-toggle="tooltip" data-html="true" title="" data-original-title="{{ l('کاراکترهای نامعتبر: <>;=#{}') }}">{{ l('عنوان') }}</span>
                            </label>

                            <div class="col-lg-9">
                                <input type="text" class="form-control" name="title" id="title" value="" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-lg-3 required">
                                <span class="label-tooltip" data-toggle="tooltip" data-html="true" title="" data-original-title="{{ l('کاراکترهای نامعتبر: <>;=#{}') }}">{{ l('خلاصه مطلب') }}</span>
                            </label>

                            <div class="col-lg-9">
                                <textarea type="text" class="form-control" name="description" id="description" style="height:100px" ></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-3 control-label">{{ l('توضیحات') }}</label>
                            <div class="col-md-9">
                                            <textarea class="form-control" name="body" id="editor1"
                                                      autofocus  rows="30"></textarea>
                                        <script type="text/javascript">
                                        tinymce.init({
                                            selector: "#editor1",
                                            relative_urls: false,
                                            remove_script_host: false,
                                            /*theme: "inlite",*/
                                            directionality : "rtl",
                                            plugins: [
                                                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                                                "searchreplace wordcount visualblocks visualchars code fullscreen",
                                                "insertdatetime media nonbreaking save table contextmenu directionality",
                                                "emoticons template paste textcolor colorpicker textpattern"
                                            ],
                                            toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image|print preview media | forecolor backcolor emoticons",
                                            image_advtab: true,
                                            templates: [
                                                {title: 'Test template 1', content: 'Test 1'},
                                                {title: 'Test template 2', content: 'Test 2'}
                                            ],
                                            // without images_upload_url set, Upload tab won't show up
                                            images_upload_url: '/upload.php',

                                            // override default upload handler to simulate successful upload
                                            images_upload_handler: function (blobInfo, success, failure) {
                                                var xhr, formData;

                                                xhr = new XMLHttpRequest();
                                                xhr.withCredentials = false;
                                                xhr.open('POST', '/upload.php');

                                                xhr.onload = function() {
                                                    var json;

                                                    if (xhr.status != 200) {
                                                        failure('HTTP Error: ' + xhr.status);
                                                        return;
                                                    }

                                                    json = JSON.parse(xhr.responseText);

                                                    if (!json || typeof json.location != 'string') {
                                                        failure('Invalid JSON: ' + xhr.responseText);
                                                        return;
                                                    }

                                                    success(json.location);
                                                };

                                                formData = new FormData();
                                                formData.append('file', blobInfo.blob(), blobInfo.filename());

                                                xhr.send(formData);
                                            }
                                        });
                                    </script>
                            </div>
                        </div>


                        <?php
                        $new = $all = [];
                        if ( $tags != null ) {
                            $all = $tags->map( function ( $item ) {
                                $new['id']   = $item->id;
                                $new['name'] = $item->name;

                                return $new;
                            } );
                        }

                        ?>
                        <!--
                        @if($post_type == 'post')
                        <div class="form-group row">
                            <label class="control-label col-lg-3">{{ l('برچسب ها') }}</label>
                            <div class="col-lg-9">
                                <input name="tags" id="tagsinput" class="tagsinput" value=""/>
                                <input type="hidden" id="result_tags" name="result_tags" value="">
                                <div id="tag_suggestion"></div>
                            </div>

                            <div class="clear"></div>
                        </div>
                        @endif

                        <div class="form-group row">
                            <label class="control-label col-lg-3">
                                <span>{{ l('عنوان متا') }}</span>
                            </label>

                            <div class="col-lg-9">
                                <input class="form-control" name="meta_title" id="meta_title" value=""/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-lg-3">
                                <span>{{ l('توضیحات متا') }}</span>
                            </label>

                            <div class="col-lg-9">
                                <textarea class="form-control" name="meta_description" id="meta_description"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-lg-3">
                                <span class="label-tooltip" data-toggle="tooltip" data-html="true" title="" data-original-title="{{ l('فقط حروف،اعداد، ـ و - مجاز هستند.') }}">{{ l('URL آشنا') }}</span>
                            </label>

                            <div class="col-lg-9">
                                <input class="form-control" name="link_rewrite" id="link_rewrite" value=""/>
                            </div>
                        </div>-->

                    </div>
                    <div class="panel-footer clearfix">
                        <button type="submit" class="btn btn-success pull-right">
                            <i class="fa fa-save"></i> {{ l('ذخیره') }}
                        </button>
                        <button type="button" onclick="window.history.back();" class="btn btn-danger pull-left">
                            <i class="fa fa-close"></i> {{ l('انصراف') }}
                        </button>
                    </div>
                </section>

                </form>
            </div>
        </div>

@endsection
@section('js')
    <script src="{{asset('admin/js/treeview.js')}}"></script>
{{--    <script src="{{asset('admin/js/form-component.js')}}"></script>--}}
{{--    <script src="{{asset('admin/js/common-scripts.js')}}"></script>--}}
{{--    <script src="{{asset('admin/js/jquery.tagsinput.js')}}"></script>--}}
    <script type="text/javascript">
        var CSRF_TOKEN = $('input[name="csrf-token"]').attr('value');
        var tags = <?php echo json_encode( $all ); ?>;

        function getTags() {
            //first object from php
            str = JSON.stringify(tags);

            // tagsinput entry
            var entry = document.getElementById("tagsinput").value;
            entry = entry.split(',');

            var exist_result = [];
            var new_tags = [];
            for (var i = 0; i < entry.length; i++) {
                for (var j = 0; j < tags.length; j++) {
                    if (tags[j].name === entry[i]) {
                        exist_result.push(tags[j].id);
                    }
                }
            }

            document.getElementById('result_tags').value = exist_result;
        }

        // make unique array
        function onlyUnique(value, index, self) {
            return self.indexOf(value) === index;
        }

        // suggestion list of tags
        function makeUL(data) {
            var a = '<ul id="suggestion">';
            var b = '</ul>';
            var m = [];

            for (var i = 0; i < data.length; i++) {
                m += '<li ><a>' + data[i] + '</a></li>';
            }

            document.getElementById('tag_suggestion').innerHTML = a + m + b;
        }


        $(document).on('keyup', "#tagsinput_addTag input[id='tagsinput_tag']", function () {
            if (this.value.length < 3) {
                document.getElementById('tag_suggestion').style["display"] = "none";
            } else {

                var suggestion = [];
                for (var i = 0; i < tags.length; i++) {
                    if (tags[i].name.includes(this.value)) {
                        document.getElementById('tag_suggestion').style["display"] = "block";
                        suggestion.push(tags[i].name);
                        var unique = suggestion.filter(onlyUnique);
                    }
                }

                if (unique != null) {
                    makeUL(unique);
                }

            }
        });

        $(document).on('mousedown', "ul#suggestion li", function () {
            var tag_input = $("#tagsinput_addTag input[id='tagsinput_tag']");
            tag_input.val($(this).text());
            e = jQuery.Event("keypress")
            e.which = 13 //choose the one you want
            tag_input.keypress(function () {

            }).trigger(e)
            //alert($(this).text());
        });
        $(document).on('mouseup', "ul#suggestion li a", function () {
            document.getElementById('tag_suggestion').style["display"] = "none";
        });

        function addRow(tableID) {
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);
            var colCount = table.rows[0].cells.length;
            for (var i = 0; i < colCount; i++) {
                var newcell = row.insertCell(i);
                newcell.innerHTML = table.rows[0].cells[i].innerHTML;
            }
        }

        function getId(element) {
            rowNumber = element.parentNode.parentNode.rowIndex;
            cellNumber = element.parentNode.cellIndex;
            return rowNumber;
        }

        function deleteRow(tableID, rowNum) {
            var target_row = getId(rowNum);
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;
            if (rowCount > 1) {
                table.deleteRow(target_row);
            }
        }
    </script>
@endsection
