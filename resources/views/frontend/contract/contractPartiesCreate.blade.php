<div class="row">
    @if(!empty($model))
    <input type="hidden" id="id" name="id" value="{{$model->id}}"/>
    @endif
    <input type="hidden"  class="form-control" name="contract_id" value="{{$contractid}}"/>

    <div class="col-md-6 col-sm-12">
        <label class="form-label fw-bold">
            {{ l('نام کاربر') }}
             <span class="text-danger">*</span>
        </label>
        <input type="text" class="form-control" name="name" value="{{!empty($model)?$model->name:''}}" required/></div>
    <div class="col-md-6 col-sm-12"><label class="form-label fw-bold">{{ l('نوع کاربر') }}</label><select name="type" class="form-control" style="width: 100%"><option {{!empty($model)?($model->type==1?'selected':''):''}} value="1">{{ l('فروشنده') }}</option><option {{!empty($model)?($model->type==2?'selected':''):''}} value="2">{{ l('خریدار') }}</option></select></div>
    <div class="col-md-6 col-sm-12">
        <label class="form-label fw-bold">{{ l('مبلغ کمیسیون دریافتی') }}<span class="text-danger">*</span></label>
        <input type="text" value="{{!empty($model)?toPersianNumbers($model->commission):''}}"   onkeypress="OnlyNumber(event,false)" onkeyup="SplitNumber($(this));" class="js_number form-control" name="commission" required/>
    </div>
    <div class="col-md-6 col-sm-12"<label class="form-label fw-bold">{{ l('شماره رسید') }}</label><input type="text" class="form-control" name="receipt_number"  value="{{!empty($model)?$model->receipt_number:''}}" /></div>
    <div class="col-md-6 col-sm-12"><label class="form-label fw-bold">{{ l('سند رسید') }}</label><input type="text" class="form-control" name="receipt_doc" value="{{!empty($model)?$model->receipt_doc:''}}"/></div>
    <div class="col-md-12 col-sm-12"><label class="form-label fw-bold">{{ l('توضیحات') }}</label><textarea class="form-control" name="description">{{!empty($model)?$model->description:''}}</textarea></div>
</div>
<section class="d-sm-flex justify-content-between pt-2">
    <input type="submit" class="btn btn-primary btn-lg d-block mb-2" value="{{ l('ثبت پرداخت کمیسیون') }}"/></div>

</section>

<script>
    function OnlyNumber(event,HasBullet){
        if(HasBullet){
            var blockSpecialRegex = /[a-zA-Zآ-ی~`!@#$%*'"^&()_={}[\]:;,<>+\/?-]/;
        }
        else{
            var blockSpecialRegex = /[a-zA-Zآ-ی~`!@#$%*'"^&()_={}[\]:;,.<>+\\/?-]/; } var key = String.fromCharCode(!event.charCode ? event.which : event.charCode); if (blockSpecialRegex.test(key)) { event.preventDefault(); } } "use strict";var delimiter=l("و"),zero=l("صفر"),negative=l("منفی"),letters=[["",l("یک"),l("دو"),l("سه"),l("چهار"),l("پنج"),l("شش"),l("هفت"),l("هشت"),l("نه")],["ده",l("یازده"),l("دوازده"),l("سیزده"),l("چهارده"),l("پانزده"),l("شانزده"),l("هفده"),l("هجده"),l("نوزده"),l("بیست")],["","",l("بیست"),l("سی"),l("چهل"),l("پنجاه"),l("شصت"),l("هفتاد"),l("هشتاد"),l("نود")],["",l("یکصد"),l("دویست"),l("سیصد"),l("چهارصد"),l("پانصد"),l("ششصد"),l("هفتصد"),l("هشتصد"),l("نهصد")],["",l("هزار"),l("میلیون"),l("میلیارد"),l("بیلیون"),l("بیلیارد"),l("تریلیون"),l("تریلیارد"),l("کوآدریلیون"),l("کادریلیارد"),l("کوینتیلیون"),l("کوانتینیارد"),l("سکستیلیون"),l("سکستیلیارد"),l("سپتیلیون"),l("سپتیلیارد"),l("اکتیلیون"),l("اکتیلیارد"),l("نانیلیون"),l("نانیلیارد"),l("دسیلیون"),l("دسیلیارد")]],decimalSuffixes=["",l("دهم"),l("صدم"),l("هزارم"),l("ده‌هزارم"),l("صد‌هزارم"),l("میلیونوم"),l("ده‌میلیونوم"),l("صدمیلیونوم"),l("میلیاردم"),l("ده‌میلیاردم"),l("صد‌‌میلیاردم")],prepareNumber=function(e){var t=e;return"number"==typeof t&&(t=t.toString()),t.length%3==1?t="00".concat(t):t.length%3==2&&(t="0".concat(t)),t.replace(/\\d{3}(?=\\d)/g,"$&*").split("*")},tinyNumToWord=function(e){if(0===parseInt(e,0))return"";var t=parseInt(e,0);if(t<10)return letters[0][t];if(t<=20)return letters[1][t-10];if(t<100){var r=t%10,n=(t-r)/10;return r>0?letters[2][n]+delimiter+letters[0][r]:letters[2][n]}var i=t%10,u=(t-t%100)/100,s=(t-(100*u+i))/10,a=[letters[3][u]],o=10*s+i;return 0===o?a.join(delimiter):(o<10?a.push(letters[0][o]):o<=20?a.push(letters[1][o-10]):(a.push(letters[2][s]),i>0&&a.push(letters[0][i])),a.join(delimiter))},convertDecimalPart=function(e){return""===(e=e.replace(/0*$/,""))?"":(e.length>11&&(e=e.substr(0,11)),l("ممیز")+Num2persian(e)+" "+decimalSuffixes[e.length])},Num2persian=function(e){e=e.toString().replace(/[^0-9.-]/g,"");var t=!1,r=parseFloat(e);if(isNaN(r))return zero;if(0===r)return zero;r<0&&(t=!0,e=e.replace(/-/g,""));var n="",i=e,u=e.indexOf(".");if(u>-1&&(i=e.substring(0,u),n=e.substring(u+1,e.length)),i.length>66)return"خارج از محدوده";for(var s=prepareNumber(i),a=[],o=0;o<s.length;o+=1){var l=tinyNumToWord(s[o]);""!==l&&a.push(l+letters[4][s.length-(o+1)])}return n.length>0&&(n=convertDecimalPart(n)),(t?negative:"")+a.join(delimiter)+n};String.prototype.toPersianLetter=function(){return Num2persian(this)},Number.prototype.toPersianLetter=function(){return Num2persian(parseFloat(this).toString())},String.prototype.num2persian=function(){return Num2persian(this)},Number.prototype.num2persian=function(){return Num2persian(parseFloat(this).toString())}; function toEnglishNumber(strNum) { var pn = ["۰", l("۱"), l("۲"), l("۳"), l("۴"), l("۵"), l("۶"), l("۷"), l("۸"), l("۹")]; // Persian var an = ["٠", l("١"), l("٢"), l("٣"), l("٤"), l("٥"), l("٦"), l("٧"), l("٨"), l("٩")]; // Arabic var en = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"]; var cache = strNum; for (var i = 0; i < 10; i++) {
            cache = cache.replace(new RegExp(pn[i], 'g'), en[i]); // Persian digits
            cache = cache.replace(new RegExp(an[i], 'g'), en[i]); // Arabic digits
        }
        return cache;
    }
    function SplitNumber(obj){
        var Getnumber= toEnglishNumber(obj.val()).replace(/,/g,'');
        obj.val(Getnumber.split("").reverse().join("").replace(/(.{3}\B)/g, "$1,").split("").reverse().join(""));
        @if(env('COUNTRY') != 'UAE')
        obj.parent().find(".divprice").html(obj.val().num2persian()+" تومان");
        @endif
    }
    window.SplitNumber=SplitNumber;
</script>
