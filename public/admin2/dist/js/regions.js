function getCities(){
    $('select#province_id').on('change', function () {
        var provinceId = this.value;
        removeSelectOptions("city_id");
        city_request(provinceId);
    });
}

function getAreas(){
    $('select#city_id').on('change', function () {
        var cityId = this.value;
        removeSelectOptions("area_id");
        area_request(cityId);
    });
}

function getAreaDistrict(){
    $('select#area_id').on('change', function () {

        var selectElement = document.getElementById("area_id");
        var selectedValues = [];

        for (var i = 0; i < selectElement.options.length; i++) {
            var option = selectElement.options[i];

            if (option.selected) {
                selectedValues.push(option.value);

            }
          }
          areastreet_request(selectedValues);
      //  removeSelectOptions("district_id");

    });
}

function getDistricts(){
    $('select#city_id').on('change', function () {
        var cityId = this.value;
        removeSelectOptions("district_id");
        console.log(cityId);
        district_request(cityId);
    });
}


function getStreets(){
    $('select#district_id').on('change', function () {
        var districtId = this.value;
        //removeSelectOptions("street_id");
        street_request(districtId);
    });
}

function getBranchAdmins(city_id,user_id,branch_id){
    $('select#province_id').on('change', function () {
        removeSelectOptions("user_id");
    });
    $('select#city_id').on('change', function () {
        removeSelectOptions("user_id");
        var cityId = this.value;
        branchAdmin_request(cityId,user_id,branch_id);
    });
}

function getCoaches(city_id,user_id){
    $('select#province_id').on('change', function () {
        removeSelectOptions("parent_id");
    });
    $('select#city_id').on('change', function () {
        removeSelectOptions("parent_id");
        var cityId = this.value;
        coaches_request(cityId,user_id);
    });
}

function city_request(province_id, city_id){
    $.get("/api/provinces/"+province_id+"/cities" , function (data, status) {
        if (data.status) {
            $('select#city_id').append('<option value="" selected disabled>انتخاب کنید</option>');
            $.each(data.result, function (i, item) {
                $('select#city_id').append($('<option>', {
                    value: i,
                    text: item
                }));
            });

            if(city_id) {
                $("select#city_id option[value='" + city_id + "']").prop('selected', true);
            }
        }
    });
}


function areastreet_request(city_id, district_id){

    $.get("/api/cities/"+city_id+"/AreaDistrict", function (data, status) {
        if (data.status) {
            $("select#district_id").select2({
                sorter: data => data.sort((a, b) => a.text.localeCompare(b.text)),
            }).val(data.result).trigger('change');
        }
        else
        {
            $("select#district_id").select2({
                sorter: data => data.sort((a, b) => a.text.localeCompare(b.text)),
            }).val('').trigger('change');
        }
        $("select#district_id").select2({closeOnSelect: false});
    });
}

function area_request(city_id, area_id){

    $.get("/api/cities/"+city_id+"/areas", function (data, status) {
        if (data) {
           for(var i=1;i<=data;i++){
                $('select#area_id').append($('<option>', {
                    value: i,
                    text: "منطقه "+i
                }));
           }
        }
        if( area_id !== '' ) {
            //$("select#district_id option[value='" + district_id + "']").prop('selected', true);
            $("select#area_id").select2({
                sorter: data => data.sort((a, b) => a.text.localeCompare(b.text)),
            }).val(area_id).trigger('change');
        }

    });
}

function branchAdmin_request(city_id,user_id,branch_id){

    var url = (user_id==undefined && branch_id==undefined) ?
        "/api/cities/"+city_id+"/branch_admins?city_id="+city_id :
        "/api/cities/"+city_id+"/branch_admins?city_id="+city_id+"&branch_id="+branch_id+"&user_id="+user_id;
    $.get("/api/cities/"+city_id+"/branch_admins?city_id="+city_id+"&branch_id="+branch_id+"&user_id="+user_id, function (data, status) {
        //console.log(data);
        if (data.status) {
            $.each(data.result, function (i, item) {
                $('select#user_id').append($('<option>', {
                    value: i,
                    text: item
                }));
            });

            if(user_id) {
                //$("select#user_id option[value='" + user_id + "']").prop('selected', true);
                $("select#user_id").select2().val(user_id).trigger('change');
            }
        }
    });
}

function coaches_request(city_id,user_id){
    $.get("/api/cities/"+city_id+"/coaches?city_id="+city_id+"&user_id="+user_id, function (data, status) {
        console.log(data);
        if (data.status) {
            //$('select#parent_id').append('<option value="" selected disabled>انتخاب کنید</option>');
            $.each(data.result, function (i, item) {
                $('select#parent_id').append($('<option>', {
                    value: i,
                    text: item
                }));
            });

            if(user_id) {
                $("select#parent_id").select2().val(user_id).trigger('change');
            }
        }
    });
}

function district_request(city_id, district_id){
    $.get("/api/cities/"+city_id+"/districts", function (data, status) {
        if (data.status) {
            //$('select#city_id').append('<option value="" disabled>انتخاب کنید</option>');
            $.each(data.result, function (i, item) {
                $('select#district_id').append($('<option>', {
                    value: i,
                    text: item
                }));
            });

            if( district_id !== '' ) {
                //$("select#district_id option[value='" + district_id + "']").prop('selected', true);
                $("select#district_id").select2().val(district_id).trigger('change');
                $("#district_id").select2({closeOnSelect: false});
            }
        }
    });
}

function street_request(district_id, street_id){
    $.get("/api/districts/"+district_id+"/streets", function (data, status) {
        if (data.status) {
            $.each(data.result, function (i, item) {
                $('select#street_id').append($('<option>', {
                    value: i,
                    text: item
                }));
            });

            if( street_id !== '' ) {
                $("select#street_id").select2().val(street_id).trigger('change');
            }
        }
    });
}

function removeSelectOptions(elmID){
    console.log(elmID);
    var i;
    var selectElm = document.getElementById(elmID);
    if(selectElm != null){
        for (i = selectElm.options.length - 1; i >= 0; i--) {
            selectElm.remove(i);
        }

        selectElm.append('<option value="" disabled>انتخاب کنید</option>');
    }
}

function removeSelectOptionsByClass(className){
    $('select.'+className).each(function(index, elm) {
        var i;
        for (i = elm.options.length - 1; i >= 0; i--) {
            elm.remove(i);
        }

        elm.append('<option value="" disabled>انتخاب کنید</option>');
    });
}
