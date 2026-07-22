yekanFa = [" یک ", " دو ", " سه ", " چهار ", " پنج ", " شش ", " هفت ", " هشت ", " نه "];
yekanEn = [" one ", " two ", " three ", " four ", " five ", " six ", " seven ", " eight ", " nine "];



var separateNum = function(value, input) {
    'use strict';
    var nStr = value + '';
    nStr = nStr.replace(/\,/g, "");
    let x = nStr.split('.');
    let x1 = x[0];
    let x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;

    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    if (input !== undefined) {
        input.value = x1 + x2;
    } else {
        return x1 + x2;
    }
}

var numberToWordFa = function(num, level) {
    'use strict';
    if (num === null) {
        return "";
    }

    if (num < 0) {
        num = num * -1;
        return "منفی " + numberToWordFa(num, level);
    }
    if (num === 0) {
        return "";
    }
    var result = "",
        yekan = [" یک ", " دو ", " سه ", " چهار ", " پنج ", " شش ", " هفت ", " هشت ", " نه "],
        dahgan = [" بیست ", " سی ", " چهل ", " پنجاه ", " شصت ", " هفتاد ", " هشتاد ", " نود "],
        sadgan = [" یکصد ", " دویست ", " سیصد ", " چهارصد ", " پانصد ", " ششصد ", " هفتصد ", " هشتصد ", " نهصد "],
        dah = [" ده ", " یازده ", " دوازده ", " سیزده ", " چهارده ", " پانزده ", " شانزده ", " هفده ", " هیجده ", " نوزده "];
    if (level > 0) {
        result += " و ";
        level -= 1;
    }

    if (num < 10) {
        result += yekan[num - 1];
    } else if (num < 20) {
        result += dah[num - 10];
    } else if (num < 100) {
        result += dahgan[parseInt(num / 10, 10) - 2] + numberToWordFa(num % 10, level + 1);
    } else if (num < 1000) {
        result += sadgan[parseInt(num / 100, 10) - 1] + numberToWordFa(num % 100, level + 1);
    } else if (num < 1000000) {
        result += numberToWordFa(parseInt(num / 1000, 10), level) + " هزار " + numberToWordFa(num % 1000, level + 1);
    } else if (num < 1000000000) {
        result += numberToWordFa(parseInt(num / 1000000, 10), level) + " میلیون " + numberToWordFa(num % 1000000, level + 1);
    } else if (num < 1000000000000) {
        result += numberToWordFa(parseInt(num / 1000000000, 10), level) + " میلیارد " + numberToWordFa(num % 1000000000, level + 1);
    } else if (num < 1000000000000000) {
        result += numberToWordFa(parseInt(num / 1000000000000, 10), level) + " تریلیارد " + numberToWordFa(num % 1000000000000, level + 1);
    }
    return result;

};



var numberToWordEn = function(num, level) {
    'use strict';
    if (num === null) {
        return "";
    }

    if (num < 0) {
        num = num * -1;
        return "Minues " + numberToWordEn(num, level);
    }
    if (num === 0) {
        return "";
    }
    var result = "",
        yekan = [" one ", " two ", " three ", " four ", " five ", " six ", " seven ", " eight ", " nine "],
        dahgan = [" twenty ", " thirty ", " forty ", " fifty ", " sixty ", " seventy ", " eighty ", " ninety "],
        sadgan = [" one hundred ", " two hundred ", " three hundred ", " four hundred ", " five hundred ", " six hundred ", " seven hundred ", " eight hundred ", " nine hundred "],
        dah = [" ten ", " eleven ", " twelve ", " thirteen ", " fourteen ", " fifteen ", " sixteen ", " seventeen ", " eighteen ", " nineteen "];
    if (level > 0) {
        result += " , ";
        level -= 1;
    }

    if (num < 10) {
        result += yekan[num - 1];
    } else if (num < 20) {
        result += dah[num - 10];
    } else if (num < 100) {
        result += dahgan[parseInt(num / 10, 10) - 2] + numberToWordEn(num % 10, level + 1);
    } else if (num < 1000) {
        result += sadgan[parseInt(num / 100, 10) - 1] + numberToWordEn(num % 100, level + 1);
    } else if (num < 1000000) {
        result += numberToWordEn(parseInt(num / 1000, 10), level) + " thousand " + numberToWordEn(num % 1000, level + 1);
    } else if (num < 1000000000) {
        result += numberToWordEn(parseInt(num / 1000000, 10), level) + " million " + numberToWordEn(num % 1000000, level + 1);
    } else if (num < 1000000000000) {
        result += numberToWordEn(parseInt(num / 1000000000, 10), level) + " Milliard " + numberToWordEn(num % 1000000000, level + 1);
    } else if (num < 1000000000000000) {
        result += numberToWordEn(parseInt(num / 1000000000000, 10), level) + " Billion " + numberToWordEn(num % 1000000000000, level + 1);
    }
    return result;

};


var convertRialsInTomans = function(num, lang) {
    'use strict';
    var reminder;

    num = num.replace(/,/g, '');
    num = num * 10;
    if (num >= 10) {
        reminder = (num % 10)
        num = parseInt(num / 10, 10);
    } else if (num <= -10) {
        num = parseInt(num / 10, 10);
    } else {
        var reminder = num;
        num = 0;
    }

    if (lang == 'fa') {
        var result = numberToWordFa(num, 0);

        if (reminder == 0 && result == "") {
            return "";
        } else if (reminder == 0 && result != "") {
            return result + "تومان";
        } else if (reminder != 0 && result == "") {
            return yekanFa[reminder - 1] + " ریال ";
        } else if (reminder != 0 && result != "") {
            return result + "تومان و " + yekanFa[reminder - 1] + " ریال ";
        }

    } else {
        var result = numberToWordEn(num, 0);
        if (reminder == 0 && result == "") {
            return "";
        } else if (reminder == 0 && result != "") {
            return result + "toman";
        } else if (reminder != 0 && result == "") {
            return yekanEn[reminder - 1] + "rial ";
        } else if (reminder != 0 && result != "") {
            return result + "toman and " + yekanEn[reminder - 1] + "rial ";
        }

    }

};

$(function() {

    var reg = /^\d+$/;



    $(document).on('keypress keyup blur', '.jsnumber', function(event) {
        var a = $(this).val();
        a = a.replace(/,/g, "")

        if (event.which < 48 || event.which > 57) {
            //return false;
            event.preventDefault();
        }

    })
    $(document).on('keyup', '.js_price', function(event) {
        $("#" + $(this).attr('aria-describedby')).show();


        //$('.').show();
        let strVal = $(this).val();
        separateNum(strVal, this);

        var myPopover = bootstrap.Popover.getInstance($(this).get(0));
        if (myPopover == null) {
            new bootstrap.Popover($(this))
        }
        $(this).attr('data-bs-content', convertRialsInTomans(strVal, 'fa'));
        let str = strVal;
        str = str.replace(/,/g, '');

        if (reg.test(str)) {
            $(this).attr('data-bs-content', convertRialsInTomans(strVal, 'fa'));
            $(this).removeClass('text-danger')
        } else {
            $(this).attr('data-bs-content', 'فقط مقادیر عددی وارد کنید', 'fa');
            $(this).addClass('text-danger');
        }
        var myPopover = bootstrap.Popover.getInstance($(this).get(0));
        myPopover.update();
        myPopover.show();
    });
});

$(document).ready(function($) {

    $(document).click(function(e) {
        if (!$(e.target).closest(".popover").length) {
            $('.popover').hide();
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