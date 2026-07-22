if($.fn.owlCarousel){
  
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
