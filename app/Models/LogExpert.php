<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogExpert extends \Spatie\Activitylog\Models\Activity
{
    /**
     *  نام جدول
     *
     * این جدول برای نگه داری لاگ ها استفاده میشود
     *
     * @var string
     */
    protected $table = 'logexpert';

    /**
     * فیلدهای قابل پذیرش در جدول
     *
     * لیست فیلدهای قابل پذیرش در زمان ثبت یا ویرایش
     *
     * @var array
     */
    protected $fillable = [
        'userId',
        'type',
        'date',
        'page',    
    ];

    
}
