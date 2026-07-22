
$(document).ready(function () {
    if ($.fn.owlCarousel) {
        /*
    ====================
    slider
    ====================
    */
    $(".heart .fill-none").click(function () {
        alert('ok');
    });
    
        $('#service_slider').owlCarousel({
            rtl: true,
            nav: false,
            items: 3,
            stagePadding: 10,
            margin: 30,
            responsive: {
                0: {
                    items: 2,
                    loop: true,
                    dots: false,
                },
                590: {
                    items: 3,
                    loop: true,
                    dots: true,
                },
                800: {
                    items: 3,
                    loop: false,
                    touchDrag: false,
                    mouseDrag: false
                },
                1025: {
                    loop: false,
                    items: 3,
                    touchDrag: false,
                    mouseDrag: false
                },
            }
        });

        /*
        ==============
        join us
        ==============
        */
        /*
        -------------------------
        slider_demo1
        -------------------------
        */
        $('#slider_demo1').owlCarousel({
            rtl: true,
            items: 1,
            loop: true,
            autoplay: true,
            autoplayTimeout: 7000,
            autoplayHoverPause: true,
            animateOut: 'fadeOut',
            animateIn: 'fadeIn',
            smartSpeed: 500
        });
        /*
              ==============
              slider in search page
              ==============
              */
        $('#property_thumbnail_slider').owlCarousel({
            rtl: true,
            items: 1,
            loop: true,
            // animateOut: 'fadeOut',
            // animateIn: 'fadeIn',
            smartSpeed: 500,
            nav: true,
            dots: false,
            navText: ["<img src='images/icon/arrow-r.png'>", "<img src='images/icon/arrow-l.png'>"]
        });

    }

    /*------------------------------------
    Heart in lis Page
    --------------------------------------*/
    $(".heart .fill-none").click(function () {
        alert('ok');
    });

    $(".sort-menu-direction").click(function () {
        $(this).find("svg").toggleClass("flip-vertical");
    });

    /*------------------------------------
        tooltip
        --------------------------------------*/
    $('[data-toggle="tooltip"]').tooltip();


    /*------------------------------------
     Radio in Search Form
     --------------------------------------*/
    $(document).on('click', ".dropdown-menu.block-radio .dropdown-item", function (e) {
        var index = $(".dropdown-menu.block-radio .dropdown-item").removeClass('active').index(this);
        $(this).addClass('active');
        $(this).find('input').prop('checked', true);
    });

    /*------------------------------------
     Single CheckBox
     --------------------------------------*/
    $(".single-checkbox input").on('click', function () {
        $(this).parent().toggleClass("active");
    });

    /*------------------------------------
   check box All
     --------------------------------------*/
    var $others = $('.filter-icon-list input[type="checkbox"][name="checkbox-proptype"]').not('#proptype-any-desktop')
    $('#proptype-any-desktop').change(function () {
        if (this.checked) {
            $others.prop('checked', false)
        }
    });
    $others.change(function () {
        if (this.checked) {
            $('#proptype-any-desktop').prop('checked', false)
        }
    })
    /*------------------------------------
 show range in price dropdown in search-form 
 --------------------------------------*/

    $("#min_price_ranges li").click(function () {

        $('#max_price_ranges li').each(function (i, obj) {
            // $(this).on("click");
            if ($(this).hasClass("disabled"))
                $(this).toggleClass("disabled");
        });


        var x = $(this).data("value");

        if (x == "clear-min-input") {
            $("#min_price_input").val("");
            $('#min_price_ranges li').each(function (i, obj) {
                // $(this).on("click");
                if ($(this).hasClass("disabled"))
                    $(this).toggleClass("disabled");
            });
        }

        else if ($("#max_price_input").val() == '' || $("#max_price_input").val() > x) {
            $("#min_price_input").val(x);
        }
        else if ($("#max_price_input").val() != '' && $("#max_price_input").val() < x) {
            $("#min_price_input").val(x);
            $("#max_price_input").val("");
        };

        $('#max_price_ranges li').each(function (i, obj) {
            if ($(this).data("value") != "clear-max-input" && $(this).data("value") < x) {
                // $(this).off("click");
                $(this).toggleClass("disabled");
            }
        });
    });

    // Max
    $("#max_price_ranges li").click(function () {
     
        
        $('#min_price_ranges li').each(function (i, obj) {
            // $(this).on("click");
            if ($(this).hasClass("disabled"))
                $(this).toggleClass("disabled");
        });
        
        y = $(this).data("value");

        if (y == "clear-max-input") {
            $("#max_price_input").val("");

            $('#max_price_ranges li').each(function (i, obj) {
                // alert($(this).data("value"));
                // $(this).on("click");
                if ($(this).hasClass("disabled"))
                    $(this).toggleClass("disabled");
            });

        } 
        
        else {
            $("#max_price_input").val(y);
            // console.log("بشتر");
            $('#min_price_ranges li').each(function (i, obj) {
                console.log($(this).data("value"));
                if ($(this).data("value") != "clear-min-input" && $(this).data("value") >= y) {
                    // $(this).off("click");
                    $(this).toggleClass("disabled");
                }
            });

        }
    });

    // Hide & Show
    $("#min_price_input").focus(function () {
        $('#min_price_ranges').show();
        if ($($('#max_price_ranges').is(":visible"))) {
            $('#max_price_ranges').hide();
        }
    });

    $("#max_price_input").focus(function () {
        $('#max_price_ranges').show();
        if ($($('#min_price_ranges').is(":visible"))) {
            $('#min_price_ranges').hide();
        }
    });


    /*------------------------------------
     Show Map
      --------------------------------------*/
    $("#show_map").click(function () {
        $('#desktop_map_wrapper').toggle();
        $(".pagination-type2").toggle();
        $(".search-pill-wrapper").toggleClass("mb-md-0");
        // $(".search-pill-wrapper").toggleClass("mb-3");
    });

});


/*------------------------------------
  SideBar
  --------------------------------------*/

//فانکشن باز و بسته شدن منو
function Sidebar(name) {
    var ele = $("body");
    var menu = $("#" + name);
    if (!($(ele).hasClass("open_" + name))) {
        $(ele).addClass("open_" + name);
        $(menu).addClass("is-open");
    } else {
        $(ele).removeClass("open_" + name);
        $(menu).removeClass("is-open");
    }
}

/*------------------------------------
  قیمت ها
  --------------------------------------*/

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}


