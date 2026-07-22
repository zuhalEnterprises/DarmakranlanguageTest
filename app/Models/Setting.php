<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends BaseModel
{
    /**
     * تنظیمات عمومی سیستم
     *
     * @return string
     */
    protected $table = 'settings';
    protected $fillable = [
        # گروه بندی تنظیمات
        'group',
        # نام کلید
        'name',
        # مقدار
        'value',
        'comment',
        'count'
    ];
}
