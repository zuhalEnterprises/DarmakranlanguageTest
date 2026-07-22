<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends \Spatie\Activitylog\Models\Activity
{
    /**
     *  نام جدول
     *
     * این جدول برای نگه داری لاگ ها استفاده میشود
     *
     * @var string
     */
    protected $table = 'activity_log';

    /**
     * فیلدهای قابل پذیرش در جدول
     *
     * لیست فیلدهای قابل پذیرش در زمان ثبت یا ویرایش
     *
     * @var array
     */
    protected $fillable = [
        # نام کلاس مدل
        'log_name',
        # توضیحات
        'description',
        # (نوع موضوع) مدل هدفی که بابت آن لاگ ثبت میشود
        'subject_type',
        # (شناسه موضوع) شناسه مدل هدفی که بابت آن لاگ ثبت میشود
        'subject_id',
        # مدل کاربر ثبت کننده
        'causer_type',
        # شناسه کاربر ثبت کننده
        'causer_id',
        # فیلدهای که دچار تغییر شده اند را بصورت جیسون در آن ذخیره میکنیم
        'properties'
    ];
}
