$(function () {
    $(document).on("click", '*[clickfn]', function (e) {
        if ($(this).attr('clickfn').indexOf('(') > -1) {
            eval('$(this).' + $(this).attr('clickfn'));
        }
        else
            eval('$(this).' + $(this).attr('clickfn') + '(e)');
    });
    $(document).on("change", '*[changefn]', function (e) {
        if ($(this).attr('changefn').indexOf('(') > -1) {
            eval('$(this).' + $(this).attr('changefn'));
        }
        else
            eval('$(this).' + $(this).attr('changefn') + '(e)');
    });
});