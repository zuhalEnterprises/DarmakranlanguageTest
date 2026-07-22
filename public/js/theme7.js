var totalCount=0;
var flagcheck=false;
$(document).ready(function() {
    var cdis="";
    searched();

});

//golab

//golab

function filter()
{
    var title=""
    var countdis = 0;
    var sr = "";
    sr += $('#type').val() > 0 ? "type=" + $('#type').val() + "&" : "";
    sr += $('#kind').val() > 0 ? "kind=" + $('#kind').val() + "&" : "";
    sr += $('#estateTypes').val() != '' ? "estateTypes=" + $('#estateTypes').val() + "&" : "";
    window.history.pushState("object or string", "Title", "?"+sr);

    //sr+="title="+$("#title").val();
    if ($('#map').length > 0) {
        let points = $('#js_HiddenMapDrawPoints').val();
        if (!isNullOrEmpty(points)) {
            sr += '&eslistflag=true&eslist=' + points;
            //            alert(sr);
        }
    }
    type2 = sr;
    $(".js_Neighbourhood_count").html(countdis);
    return sr;
}
function search(id)
{
    switch(id) {
        case 0:
            $('#kind').val('');
            $('#type').val('');
            $('#estateTypes').val('');
            break;
        case 11:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('');
            break;
        case 111:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('1,2,4,6,7');
            break;
        case 1111:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('1');
            break;
        case 1112:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('2');
            break;
        case 1114:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('4');
            break;
        case 1116:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('6');
            break;
        case 1117:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('7');
            break;
        case 112:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('8,9,10,11,12,13');
            break;
        case 1128:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('8');
            break;
        case 1129:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('9');
        case 11210:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('10');
        case 11211:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('11');
        case 11212:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('12');
        case 11213:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('13');
            break;
        case 113:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('14,15');
            break;
        case 11314:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('14');
            break;
        case 11315:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('15');
            break;
        case 12:
            $('#kind').val(1);
            $('#type').val(2);
            $('#estateTypes').val('');
            break;
        case 121:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('1,2,4,7');
            break;
        case 1211:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('1');
            break;
        case 1212:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('2');
            break;
        case 1214:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('2');
            break;
        case 1217:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('7');
            break;
        case 122:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('8,9,10,11,12,13');
            break;
        case 1228:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('8');
            break;
        case 1229:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('9');
            break;
        case 12210:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('10');
            break;
        case 12211:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('11');
            break;
        case 12212:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('12');
            break;
        case 12213:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('13');
            break;
        case 123:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('1,2,4,6,7');
            break;
        case 1231:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('1');
            break;
        case 1232:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('2');
            break;
        case 1234:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('4');
            break;
        case 1236:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('6');
            break;
        case 1237:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('7');
            break;
        /////////////////
        case 21:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('');
            break;
        case 211:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('1,2,4,6,7');
            break;
        case 2111:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('1');
            break;
        case 2112:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('2');
            break;
        case 2114:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('4');
            break;
        case 2116:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('6');
            break;
        case 2117:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('7');
            break;
        case 212:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('8,9,10,11,12,13');
            break;
        case 2128:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('8');
            break;
        case 2129:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('9');
        case 21210:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('10');
        case 21211:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('11');
        case 21212:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('12');
        case 21213:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('13');
            break;
        case 213:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('14,15');
            break;
        case 21314:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('14');
            break;
        case 21315:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('15');
            break;
        case 22:
            $('#kind').val(1);
            $('#type').val(2);
            $('#estateTypes').val('');
            break;
        case 221:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('1,2,4,7');
            break;
        case 2211:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('1');
            break;
        case 2212:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('2');
            break;
        case 2214:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('2');
            break;
        case 2217:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('7');
            break;
        case 222:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('8,9,10,11,12,13');
            break;
        case 2228:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('8');
            break;
        case 2229:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('9');
            break;
        case 22210:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('10');
            break;
        case 22211:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('11');
            break;
        case 22212:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('12');
            break;
        case 22213:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('13');
            break;
        case 223:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('1,2,4,6,7');
            break;
        case 2231:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('1');
            break;
        case 2232:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('2');
            break;
        case 2234:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('4');
            break;
        case 2236:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('6');
            break;
        case 2237:
            $('#kind').val(1);
            $('#type').val(1);
            $('#estateTypes').val('7');
            break;
        default:
            // code block
    }
    searched();
}
function checkSend()
{
    sr = filter();
}
function searched(){
    sr = filter();
    jQuery('.btn-close').click();
    loadMoreData(1, sr);
}
//golab
var type2 = "";
$(document).ready(function() {
    $(".sel2").select2({
        language: "fa",
        closeOnSelect: false
        //placeholder: "انتخاب",
    });
})
var page = 1;
var pagin = 1;
var currentpage = 1;
$(window).scroll(function() {
    if ($(window).scrollTop() + $(window).height() >= $(document).height() - 500) {
            if(flagcheck==false)
            {
                if(parseInt(totalCount)>=parseInt(pagin)+1)
                {
                    pagin=pagin+1;
                    sr = filter();
                    currentpage = pagin;
                    loadMoreData(pagin, sr)
                }
            };
        };
});
function loadMoreData(page, type2) {
    if(1 || $('#kind').val()>0)
    {
        //return;
        //$("#loadingdiv").show();
        $("#loadingdiv").removeClass("d-none");
        //return;
        if (page == 1) {
            $("#estate-wrapper").empty();
        }
        $.ajax({
                url: `?page=${page}&&${type2}`,
                type: "get",
                beforeSend: function() {
                    //$("#loadingdiv").removeClass("d-none");
                }
            }).done(function(data) {
                if (data.totalCount < 9)
                    hasPage = false;
                else
                    hasPage = data.hasPage;
                //$("#loadingdiv").addClass("d-none");
                if (data.length == 0) {
                    $("#loadingdiv").addClass("d-none");
                    return;
                }
            // console.log(data.totalCount);
                var htmlpage = data.html;
                $("#estate-wrapper").append(htmlpage);
                if (data.totalCount == 0) {
                    $(".js_stateCount2").addClass("d-none").removeClass("d-block");
                    $(".js_stateCount1").addClass("d-block").removeClass("d-none");
                    //$(".js_stateCount1").html(data.totalCount);
                } else {
                    $(".js_stateCount2").addClass("d-block").removeClass("d-none");
                    $(".js_stateCount1").addClass("d-none").removeClass("d-block");
                    $(".js_stateCount").html(data.totalCount);
                }
                pageflag = true;
                totalCount=data.totalCount;
                $("#totalCount").html(data.totalCount)
                $("#loadingdiv").addClass("d-none");
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                $("#spiner").addClass("d-none");
                //alert('مشکلی در دریافت اطلاعات بوجود آمده است...');
            });
        }
};
const swiper = new Swiper('.swiper', {
    freeMode: true,
    loop: false,
    spaceBetween: 50,
    slidesPerView: 1.5,
    spaceBetween: 17,
    // Responsive breakpoints
    breakpoints: {
        // when window width is >= 320px
        320: {
            slidesPerView: 2.5,
            spaceBetween: 30
        },
        // when window width is >= 480px
        480: {
            slidesPerView: 3.5,
            spaceBetween: 35
        },
        // when window width is >= 640px
        640: {
            slidesPerView: 4.5,
            spaceBetween: 40
        },
        // when window width is >= 640px
        820: {
            slidesPerView: 7,
            spaceBetween: 50
        },
        1100: {
            slidesPerView: 11,
            spaceBetween: 60
        }
    }
});
const swiper2 = new Swiper('.swiper2', {
    freeMode: true,
    loop: false,
    spaceBetween: 50,
    slidesPerView: 2.5,
    spaceBetween: 17,
    wrapper: ".swiper-wrapper1",
    // Responsive breakpoints
    breakpoints: {
        // when window width is >= 320px
        320: {
            slidesPerView: 4.5,
            spaceBetween: 0
        },
        // when window width is >= 480px
        480: {
            slidesPerView: 3.5,
            // spaceBetween: 35
        },
        // when window width is >= 640px
        640: {
            slidesPerView: 4.5,
            // spaceBetween: 40
        },
        // when window width is >= 640px
        820: {
            slidesPerView: 7,
            spaceBetween: 10
        },
        1100: {
            slidesPerView: 15,
            spaceBetween: 10
        }
    }
});
$(document).click(function(event) {
    if ($(event.target).is('a.collapse-estate *')) {
        /// Collapse every *collapse-estate*
        $('.collapse-estate').collapse('hide');
    }
});
// Sidebar desktop
$(document).ready(function () {
    // @if((int)app('request')->input('kind') == 0 && app('request')->input('type') == 0)
    // $(".sub-items, .sub-sub-items").hide();
    // @endif
    $(".item").click(function () {
        $('.filter_sidebar').hide()
        if ($(this).children(".sub-items").is(":visible")) {
        $(this).children(".sub-items").hide();
        $(".item").show();
        } else {
        $(".item").not(this).hide();
        $(this).children(".sub-items").show();
        $(this).siblings().hide();
        }
        $(".sub-item").show();
        $(".sub-sub-items").hide();
    });
    $(".sub-item").click(function (e) {
        e.stopPropagation();
        $('.filter_sidebar').show()
        if ($(this).children(".sub-sub-items").is(":visible")) {
        $(this).children(".sub-sub-items").hide();
        $(".sub-item").show();
        } else {
        $(this).siblings().hide();
        $(this).children(".sub-sub-items").show();
        }
    });
    $(".sub-sub-items li").click(function (e) {
        e.stopPropagation();
    });
});

// Nav mobile
$(document).ready(function () {
    var dataNav = [];
    $(".item2, .sub-item2 , .sub-sub-item2").click(function (e) {
        var getId = $(this).attr("codeid");
        var parent = $(this).attr("parentEl");
        var getNameEl = $(this).attr("nameEl");
        var getLink = $(this).attr("link");
        var getValue = $(this).attr("valueEl");
        var newData = { name: getNameEl, link: getLink, value: getValue };
        dataNav.push(newData);
        $(this).parent().addClass("d-none");
        $(`[nameEl = "${getNameEl}"]`).removeClass("d-none");
        $(".breadcrumb").empty();
        $('.btn'+parent).remove();
        $('.breadcrumb'+parent).remove();
        var newBreadcrumbItem = $(
            `<li class="breadcrumb-item"><div onclick="search(0)">خانه</a></li> <li class="breadcrumb-item breadcrumb${getId}"><a class="" codeid="${getId}" parentEl="${parent}">${getValue}</a></li>`
        );
        var newButtonFilter = $(
            `<a class="btn btn-primary btn-sm text-dark btn-light-primary fs-xs swiper-slide rounded-4 me-2 py-1" data-bs-toggle="offcanvas" data-title="t17" href="#offcanvasExample" role="button" aria-controls="offcanvasExample" style="width: auto !important; border: 2px solid #c3c3c3;"><i class="fi-filter-alt-horizontal"></i>فیلتر</a> <button class="btn btn-primary btn-sm text-dark btn-light-primary fs-xs swiper-slide rounded-4 me-2 py-1 btn-close-el btn${getId}" codeid="${getId}" parentEl="${parent}" nameBtn="${getNameEl}" style="width: auto !important; border: 2px solid #c3c3c3;">${getValue} <i class="fi-x" onclick="search(${parent})"></i> </button>`
        );
        $(".breadcrumb").html(newBreadcrumbItem);
        $("#filter").html(newButtonFilter);
        if ($("#item2").hasClass("d-none")) {
            $(".breadcrumb-box, .filter-box").removeClass("d-none");
        }
    });
    $(".sub-sub-item2 ").click(function (e) {
         //e.preventDefault()
        //  var getNameEl = $(this).attr("nameEl");
        // var getLink = $(this).attr("link");
        // var getValue = $(this).attr("valueEl");
        // var newData = { name: getNameEl, link: getLink, value: getValue };
        // dataNav.push(newData);
        // $(this).parent().addClass("d-none");
        // $(`[nameEl = "${getNameEl}"]`).removeClass("d-none");
        // var newBreadcrumbItem = $(
        //     `<li class="breadcrumb-item"><a href="${getLink}">${getValue}</a></li>`
        // );
        // var newButtonFilter = $(
        //     `<button class="btn btn-primary btn-sm text-dark btn-light-primary fs-xs swiper-slide rounded-4 me-2 py-1 btn-close-el" nameBtn="${getNameEl}" style="width: auto !important; border: 2px solid #c3c3c3;">${getValue} <i class="fi-x"></i> </button>`
        // );
        // $(".breadcrumb").append(newBreadcrumbItem);
        // $("#filter").append(newButtonFilter);
        // if ($("#item2").hasClass("d-none")) {
        //     $(".breadcrumb-box, .filter-box").removeClass("d-none");
        // }
    })
    $(document).on("click", ".btn-close-el", function (e) {
        var p = $(this).attr("parentEl");
        var getValueBtn = $('*[codeid="'+p+'"]').attr("nameBtn");
        var parent = $('*[codeid="'+p+'"]').attr("parentEl");
        var getId = $('*[codeid="'+p+'"]').attr("codeid");
        var name = $('*[codeid="'+parent+'"]').attr("nameEl");
        var getNameEl = $('*[codeid="'+parent+'"]').attr("valueEl");
        //alert(getNameEl);
        var indexDataNav = dataNav.findIndex((i) => i.name === getValueBtn);
        if ($("#item2").is(":visible")) {
            $(".filter-box, .breadcrumb-box").addClass("d-none");
        }
        // if (indexDataNav === 0) {
        //     dataNav = [];
        // } else
        // {
        //     dataNav = dataNav.filter(function (item) {
        //         return item.name !== getValueBtn;
        //     });
        // }
        $(".item2, .sub-item2 ,.sub-sub-item2").parent().addClass("d-none");
        $(`[codeid = "${getId}"]`).removeClass("d-none");
        $(".breadcrumb").empty();
        // $(".breadcrumb").append(
        //     '<li class="breadcrumb-item"><div onclick="search(0)">خانه</a></li>'
        // );
        $('.btn'+parent).remove();
        $('.breadcrumb'+parent).remove();
        $("#filter").empty();
        //$("#filter").append('<a class="btn btn-primary btn-sm text-dark btn-light-primary fs-xs swiper-slide rounded-4 me-2 py-1" data-bs-toggle="offcanvas" data-title="t17" href="#offcanvasExample" role="button" aria-controls="offcanvasExample" style="width: auto !important; border: 2px solid #c3c3c3;"><i class="fi-filter-alt-horizontal"></i>فیلتر</a>');
        //dataNav.forEach(function (item)
        //{
            var newBreadcrumbItem = $(
                `<li class="breadcrumb-item"><div onclick="search(0)">خانه</a></li> <li class="breadcrumb-item breadcrumb${getId}"><a class="" parentEl="${parent}">${getNameEl}</a></li>`
            );
            var newButtonFilter = $(
                `<a class="btn btn-primary btn-sm text-dark btn-light-primary fs-xs swiper-slide rounded-4 me-2 py-1" data-bs-toggle="offcanvas" data-title="t17" href="#offcanvasExample" role="button" aria-controls="offcanvasExample" style="width: auto !important; border: 2px solid #c3c3c3;"><i class="fi-filter-alt-horizontal"></i>فیلتر</a> <button class="btn btn-primary btn-sm text-dark btn-light-primary fs-xs swiper-slide rounded-4 me-2 py-1 btn-close-el  btn${getId}" codeid="${getId}" parentEl="${parent}" nameBtn="${name}" style="width: auto !important; border: 2px solid #c3c3c3;">${getNameEl} <i class="fi-x"  onclick="search(${parent})"></i> </button>`
            );
            $(".breadcrumb").html(newBreadcrumbItem);
            $("#filter").html(newButtonFilter);
        //});
        if (!$("#item2").hasClass("d-none")) {
            $(".breadcrumb-box, .filter-box").addClass("d-none");
        }
    });
});
// $(document).ready(function(event) {
//     $("#est-suc").on("click", function() {
//         swal({
//             text: "ملک کد 2564 برای مشتری شما با کد 1213 تایید گردید",
//             confirmButtonColor: '#13CB90',
//             confirmButtonText: 'باشه',
//             type: "success",
//             timer: 3000
//         });
//     });
//     $("#est-rej").on("click", function() {
//         swal({
//             text: "ملک کد 2564 برای مشتری شما با کد 1213 رد گردید",
//             confirmButtonColor: '#F24552',
//             confirmButtonText: 'باشه',
//             type: "error",
//             timer: 3000
//         });
//     });
//     $("#est-share").on("click", function() {
//         swal({
//             text: "ملک کد 2564 برای مشتری شما با کد 1213 ارسال گردید",
//             confirmButtonColor: '#0257a3',
//             confirmButtonText: 'باشه',
//             type: "info",
//             timer: 3000
//         });
//     });
//     $(".swiper-wrapper a").on("click", function() {
//         const target = $(this).data("title");
//         showSidebar(target);
//     });
// });
function showSidebar(target) {
    const $sidebar = $("#sidebar");
    const $sidebarItem = $(".sidebar-item[data-title='" + target + "']");
    // $sidebar.fadeIn();
    $sidebarItem.addClass("active").siblings().removeClass("active");
    const sidebarTop = $sidebarItem.offset().top;
    const sidebarHeight = $sidebarItem.outerHeight();
    const viewportHeight = $(window).height();
    const currentScroll = $sidebar.scrollTop();
    $sidebar.animate({
        scrollTop: sidebarTop - $sidebar.offset().top + currentScroll
    }, 500);
    $sidebarItem.addClass("highlight");
    setTimeout(() => {
        $sidebarItem.removeClass("highlight");
    }, 2000);
}
