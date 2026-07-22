$(document).ready(function () {

    $('.menu-icon').click(function () {
        if ($('#navigator').css("right") == "-250px") {
            $('#navigator').animate({right: '0px'}, 350);
            $('.menu-icon').animate({right: '0px'}, 350);
            $('.menu-text').animate({right: '50px'}, 350).empty().text("close");
            $('header .navbar').addClass('shadow-sm');
        }
        else  {
            $('#navigator').animate({right: '-250px'}, 350);
            $(this).animate({right: '0px'}, 350);
            $('.menu-text').animate({right: '50px'}, 350).empty().text('open');
            $('header .navbar').removeClass('shadow-sm');
        }
    });

    $('.menu-icon').click(function () {
        $(this).toggleClass("on");
    });

});
