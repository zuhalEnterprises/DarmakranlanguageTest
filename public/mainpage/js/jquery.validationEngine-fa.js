(function ($) {
    $.fn.validationEngineLanguage = function () {
    };
    $.validationEngineLanguage = {
        newLang: function () {
            $.validationEngineLanguage.allRules = {
                "required": { // Add your regex rules here, you can take telephone as an example
                    "regex": "none",
                    "alertText": "کامل کردن این فیلد ضروری است",
                    "alertTextCheckboxMultiple": "* لطفا یک گزینه را انتخاب کنید",
                    "alertTextCheckboxe": "* این چک باکس ضروری است",
                    "alertTextDateRange": "* هر دو فیلد‌های بازه‌ی تاریخی ضروری هستند"
                },
                "dateRange": {
                    "regex": "none",
                    "alertText": "* بازه‌ی تاریخی ",
                    "alertText2": "نامعتبر"
                },
                "dateTimeRange": {
                    "regex": "none",
                    "alertText": "* بازه‌ی زمانی",
                    "alertText2": "نامعتبر"
                },
                "minSize": {
                    "regex": "none",
                    "alertText": "* حداقل ",
                    "alertText2": " حرف ضروری است"
                },
                "maxSize": {
                    "regex": "none",
                    "alertText": "* حداکثر ",
                    "alertText2": " حرف وارد کنید"
                },
                "groupRequired": {
                    "regex": "none",
                    "alertText": "* شما باید یکی از فیلد‌های زیر را پر کنید"
                },
                "min": {
                    "regex": "none",
                    "alertText": "* کمترین مقدار معتبر ",
                    "alertText2": " است"
                },
                "max": {
                    "regex": "none",
                    "alertText": "* بیش‌ترین مقدار معتبر ",
                    "alertText2": "است"
                },
                "past": {
                    "regex": "none",
                    "alertText": "* تاریخ‌های قبل از "
                },
                "future": {
                    "regex": "none",
                    "alertText": "* تاریخ‌های بعد از "
                },
                "maxCheckbox": {
                    "regex": "none",
                    "alertText": "* بیش‌ترین گزینه‌ی قابل انتخاب ",
                    "alertText2": " است"
                },
                "minCheckbox": {
                    "regex": "none",
                    "alertText": "* لطفا ",
                    "alertText2": " مورد انتخاب کنید"
                },
                "equals": {
                    "regex": "none",
                    "alertText": "* فیلد نامعتبر است"
                },
                "creditCard": {
                    "regex": "none",
                    "alertText": "شماره کارت اعتباری اشتباه"
                },
                "phone": {
                    // credit: jquery.h5validate.js / orefalo
                    "regex": /^([\+][0-9]{1,3}[ \.\-])?([\(]{1}[0-9]{2,6}[\)])?([0-9 \.\-\/]{3,20})((x|ext|extension)[ ]?[0-9]{1,4})?$/,
                    "alertText": "شماره تلفن معتبر وارد کنید"
                },
                "email": {
                    // Shamelessly lifted from Scott Gonzalez via the Bassistance Validation plugin http://projects.scottsplayground.com/email_address_validation/
                    "regex": /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i,
                    "alertText": "نشانی الکترونیکی معتبر وارد کنید"
                },
                "integer": {
                    "regex": /^[\-\+]?\d+$/,
                    "alertText": "* عدد معتبر وارد کنید"
                },

                "number": {
                    // Number, including positive, negative, and floating decimal. credit: orefalo
                    "regex": /^[\-\+]?(([0-9]+)([\.,]([0-9]+))?|([\.,]([0-9]+))?)$/,
                    "alertText": "* عدد معتبر وارد کنید"
                },
                "date": {
                    "regex": /^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/,
                    "alertText": "* تاریخ باید به شکل سال/ماه/روز"
                },
                "ipv4": {
                    "regex": /^((([01]?[0-9]{1,2})|(2[0-4][0-9])|(25[0-5]))[.]){3}(([0-1]?[0-9]{1,2})|(2[0-4][0-9])|(25[0-5]))$/,
                    "alertText": "* IP معتبر وارد کنید"
                },
                "url": {
                    "regex": /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i,
                    "alertText": "* نشانی معتبر وارد کنید"
                },
                "money": {
                    "regex": /^[0-9\ ]+$/,
                    "alertText": "مبلغ را بطور صحیح وارد نمائید"
                },
                "sepratedmoney": {
                    "regex": /^[0-9\, ]+$/,
                    "alertText": "مبلغ را بطور صحیح وارد نمائید"
                },
                "codeposti": {
                    "regex": /^[1-9][0-9\ ]{9}$/,
                    "alertText": "کد پستی را صحیح وارد کنید"
                },
                "tel_StudentProject": {
                    "regex": /^0[0-9\ ]{10}$/,
                    "alertText": "لطفا تلفن خود را صحیح وارد نمایید"
                },
                "onlyNumberSp": {
                    "regex": /^[0-9\ ]+$/,
                    "alertText": " فقط اعداد"
                },
                "onlyLetterSp": {
                    "regex": /^[a-zA-Z\ \']+$/,
                    "alertText": "* فقط حروف انگلیسی"
                },
                "onlyLetterNumber": {
                    "regex": /^[0-9a-zA-Z]+$/,
                    "alertText": "* فقط اعداد و حروف انگلیسی وارد کنید"
                },
                // --- CUSTOM RULES -- Those are specific to the demos, they can be removed or changed to your likings
                "ajaxUserCall": {
                    "url": "ajaxValidateFieldUser",
                    // you may want to pass extra data on the ajax call
                    "extraData": "name=eric",
                    "alertText": "* این نام‌کاربری تکراری است",
                    "alertTextLoad": "* درحال اعتبار سنجی، لطفا صبر کنید"
                },
                "ajaxUserCallPhp": {
                    "url": "phpajax/ajaxValidateFieldUser.php",
                    // you may want to pass extra data on the ajax call
                    "extraData": "name=eric",
                    // if you provide an "alertTextOk", it will show as a green prompt when the field validates
                    "alertTextOk": "* این نام کاربری آزاد است",
                    "alertText": "* این نام‌کاربری تکراری است",
                    "alertTextLoad": "* درحال اعتبار سنجی، لطفا صبر کنید"
                },
                "ajaxNameCall": {
                    // remote json service location
                    "url": "ajaxValidateFieldName",
                    // error
                    "alertText": "* این نام پیش‌تر ثبت شده است",
                    // if you provide an "alertTextOk", it will show as a green prompt when the field validates
                    "alertTextOk": "* این نام آزاد است",
                    // speaks by itself
                    "alertTextLoad": "* درحال اعتبار سنجی، لطفا صبر کنید"
                },
                "ajaxNameCallPhp": {
                    // remote json service location
                    "url": "phpajax/ajaxValidateFieldName.php",
                    // error
                    "alertText": "* این نام تکراری است",
                    // speaks by itself
                    "alertTextLoad": "* درحال اعتبار سنجی، لطفا صبر کنید"
                },
                "validate2fields": {
                    "alertText": "* لطفا مقدار HELLO را وارد کنید"
                },
                //tls warning:homegrown not fielded
                "dateFormat": {
                    "regex": /^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$|^(?:(?:(?:0?[13578]|1[02])(\/|-)31)|(?:(?:0?[1,3-9]|1[0-2])(\/|-)(?:29|30)))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^(?:(?:0?[1-9]|1[0-2])(\/|-)(?:0?[1-9]|1\d|2[0-8]))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^(0?2(\/|-)29)(\/|-)(?:(?:0[48]00|[13579][26]00|[2468][048]00)|(?:\d\d)?(?:0[48]|[2468][048]|[13579][26]))$/,
                    "alertText": "* تاریخ نامعتبر"
                },
                //tls warning:homegrown not fielded
                "dateTimeFormat": {
                    "regex": /^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])\s+(1[012]|0?[1-9]){1}:(0?[1-5]|[0-6][0-9]){1}:(0?[0-6]|[0-6][0-9]){1}\s+(am|pm|AM|PM){1}$|^(?:(?:(?:0?[13578]|1[02])(\/|-)31)|(?:(?:0?[1,3-9]|1[0-2])(\/|-)(?:29|30)))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^((1[012]|0?[1-9]){1}\/(0?[1-9]|[12][0-9]|3[01]){1}\/\d{2,4}\s+(1[012]|0?[1-9]){1}:(0?[1-5]|[0-6][0-9]){1}:(0?[0-6]|[0-6][0-9]){1}\s+(am|pm|AM|PM){1})$/,
                    "alertText": "* تاریخ نامعتبر است یا شکل معتبری ندارد",
                    "alertText2": "شکل‌های مورد معتبر: ",
                    "alertText3": "mm/dd/yyyy hh:mm:ss AM|PM or ",
                    "alertText4": "yyyy-mm-dd hh:mm:ss AM|PM"
                }
                , "codeTahsili": {
                    "regex": /^[0-9]{5,6}$/,
                    "alertText": "عددی 5 یا 6 رقمی وارد کنید"
                },
                "farsiText": {
                    "regex": /^[ ,\)\(\-پچجحخهعغفقثصضشسیبلاتنمکگوئدذرزطظژؤإآژأءًٌٍَُِّ1234567890\s]+$/,
                    "alertText": "لطفا فقط از حروف فارسی, اعداد, خط تیره, میهن ملک و پرانتز استفاده نمایید"
                },
                "farsiLetter": {
                    "regex": /^[پچجحخهعغفقثصضشسیبلاتنمکگوئدذرزطظژؤإآژأءًٌٍَُِّ \s]+$/,
                    "alertText": "لطفا فقط از حروف فارسی استفاده نمایید"
                },
                "shsh": {
                    "regex": /^[0-9]+$/,
                    "alertText": "مقدار معتبر وارد کنید"
                },
                "mobile": {
                    "regex": /^09\d{9}$/,
                    //"regex": /^(09|9)[13][0-9]\\d{7}$/,
                    "alertText": "تلفن همراه معتبر وارد کنید"
                }, "codephone": {
                    "regex": /^0\d{2,5}$/,
                    "alertText": "کد معتبر وارد کنید"
                }, "phone": {
                    "regex": /^[0-9]{1}\d{4,12}$/,
                    "alertText": "شماره تلفن معتبر وارد کنید"
                }
            };

        }
    };

    $.validationEngineLanguage.newLang();

})(jQuery);

function fprofile(obj) {
    var value1=obj.val();
    if(value1.length<6){
    return 'کاراکترها کمتر از 6 کاراکتر می باشد';
    }
    var letters = /^[0-9a-zA-Z-]+$/;
    if (!value1.match(letters)) {
        return 'نوع کاراکتر فقط حروف انگلیسی و عدد و - می باشد.';
    }


}
function fCodeMeli(obj) {
    var meli_code = obj.val();
    if (meli_code.length == 10) {
        if (meli_code == '1111111111' ||
			meli_code == '0000000000' ||
			meli_code == '2222222222' ||
			meli_code == '3333333333' ||
			meli_code == '4444444444' ||
			meli_code == '5555555555' ||
			meli_code == '6666666666' ||
			meli_code == '7777777777' ||
			meli_code == '8888888888' ||
			meli_code == '9999999999') {
            return 'کد ملی نامعتبر می باشد';
        }

        c = parseInt(meli_code.charAt(9));
        n = parseInt(meli_code.charAt(0)) * 10 +
			parseInt(meli_code.charAt(1)) * 9 +
			parseInt(meli_code.charAt(2)) * 8 +
			parseInt(meli_code.charAt(3)) * 7 +
			parseInt(meli_code.charAt(4)) * 6 +
			parseInt(meli_code.charAt(5)) * 5 +
			parseInt(meli_code.charAt(6)) * 4 +
			parseInt(meli_code.charAt(7)) * 3 +
			parseInt(meli_code.charAt(8)) * 2;
        r = n - parseInt(n / 11) * 11;

        if (!((r == 0 && r == c) || (r == 1 && c == 1) || (r > 1 && c == 11 - r))) {
            return 'کد ملی نامعتبر می باشد';
        }
    }
    else {
        return 'کد ملی نامعتبر می باشد';
    }
}

function  farsiText(e) {
   var keycode;
 if (window.event) keycode = window.event.keyCode;
  else if (e) keycode = e.which;
  if((keycode<13 ||keycode>13))
  if((keycode<32 || keycode >32))
  if((keycode<8 || keycode>8))
  if ((keycode < 1574 || keycode > 1711))
       return 'مقدار معتبر وارد کنید';

}
