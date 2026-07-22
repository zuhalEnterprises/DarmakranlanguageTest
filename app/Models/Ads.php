<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ads extends BaseModel
{
    /**
     *  تبلیغات بنری و متنی درون سایت
     *
     * این جدول برای آگهی های تبلیغاتی درون سایت استفاده میشود
     *
     * @var string
     */
    protected $table = 'ads';

    /**
     * فیلدهای قابل پذیرش در جدول
     *
     * لیست فیلدهای قابل پذیرش در زمان ثبت یا ویرایش
     *
     * @var array
     */
    protected $fillable = [
        # شناسه شهر هدف برای نمایش آگهی
        'city_id',
        # شناسه صفحه قالب جهت نمایش اگهی
        'template_page_id',
        # نوع ملک
        'estate_type',
        # نوع آگهی: [1 => تصویری, 2 => متنی]
        'type',
        # دستگاه نمایش: [ desktop=> دسکتاپ, tablet => تبلت, mobile => گوشی]
        'device',
        # محل نمایش در صفحه [1 => بالا, 2 => راست, 3 => پایین, 4 => چپ]
        'show_place',
        # تصویر آگهی
        'image',
        # عنوان آگهی
        'title',
        # توضیحات آگهی : زمانی که اگهی از نوع متنی است این متن نمایش داده میشود
        'description',
        # مسیری که کاربر بعد از کلیک رو آگهی به آنجا هدایت میشود
        'url',
        # جایگاه نمایش
        'position',
        # وضعیت نمایش آگهی [0 => غیرفعال, 1 => فعال]
        'active'
    ];

    /**
     * لیست فیلدهایی که در زمان نمایش نمایش داده نمیشوند
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     *  تصویر اصلی آگهی
     *
     * در صورتی که آگهی از نوع تصویری باشد این متد لینک تصویر نهایی را برمیگرداند
     *
     * @return string
     */
    public function image()
    {
        $img = !empty($this->image) ? 'ads/' . $this->image : $this->image;
        return getImage($img);
    }

    /**
     *  شهر هدف برای نمایش آگهی
     *
     * ریلیشن city که با کلید خارجی city_id به آگهی مرتبط است و خروجی آن بصورت یک نمونه از مدل City میباشد
     *
     * @return object
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    /**
     *  صفحه قالب برای نمایش آگهی
     *
     * این صفحات در بخش تنظیمات سیستم در قسمت مدیریت قابل ایجاد یا ویرایش است
     * ریلیشن templatePage که با کلید خارجی template_page_id به آگهی مرتبط است و خروجی آن بصورت یک نمونه از مدل TemplatePage میباشد
     *
     * @return object
     */
    public function templatePage()
    {
        return $this->belongsTo(TemplatePage::class, 'template_page_id');
    }
}
