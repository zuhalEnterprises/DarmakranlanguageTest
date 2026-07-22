if ($.fn.owlCarousel) {
    /*
====================
slider
====================
*/

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
}
/*------------------------------------
SideBar
--------------------------------------*/

//فانکشن باز و بسته شدن منو
/*
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
*/


jQuery(document).ready(function($) {
    var open = false;

    var openSidebar = function() {
        $('#sidebar_menu').addClass('is-open');
        $('.overlay').show();
        open = true;
    }
    var closeSidebar = function() {
        $('#sidebar_menu').removeClass('is-open');
        // $('body').removeClass('active');
        $('.overlay').hide();
        open = false;
    }

    $('#navbar-toggler, #close_sidebar').click(function(event) {
        event.stopPropagation();
        var toggle = open ? closeSidebar : openSidebar;
        toggle();
    });

    $(document).click(function(event) {
        if (!$(event.target).closest('#sidebar_menu').length) {
            closeSidebar();
        }
    });
});




//menu
hide = true;
$('body').on("click", function() {
    if (hide) {
        $('.indicator--trigger--click').removeClass('indicator--open');
        $('.header-notif').removeClass('d-none');
        $('.indicator-singup-el').removeClass('d-none');
        $('.overlay2').hide()
    }
    hide = true;
});

// add and remove .active
$('body').on('click', '.indicator--trigger--click', function(e) {

    var self = $(".indicator--trigger--click");

    if (self.hasClass('indicator--open')) {
        $('.indicator--trigger--click').removeClass('indicator--open');
        $('.header-notif').removeClass('d-none');
        $('.indicator-singup-el').removeClass('d-none');
        $('.overlay2').hide()
        return false;
    }

    $('.indicator--trigger--click').removeClass('indicator--open');
    $('.header-notif').addClass('d-none');
    $('.indicator-singup-el').addClass('d-none');
    $('.overlay2').show()

    self.toggleClass('indicator--open');
    hide = false;
});

$(".indicator--trigger--click .account-menu").click(function(e) {
    e.stopPropagation();
});

///Sign Up


$(document).ready(function($) {
    $('.indicator-singup').on('click', function() {
        // alert('ttt')
        $('.indicator-singup-click').toggleClass('show');
    })
    $(document).click(function(e) {
        if (!$(e.target).closest(".indicator-singup").length) {
            $('.indicator-singup-click').removeClass('show');
        }



    });
    /*        if (!$(e.target).closest(".indicator-singup-click").length) {
                if($(".indicator-singup-click").hasClass("show"))
                {
                    alert(11);
                }

            }
        });*/
});