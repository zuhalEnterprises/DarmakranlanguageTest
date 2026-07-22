<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SiteSetting extends Model
{
    /**
     * تنظیمات عمومی سیستم
     *
     * @return string
     */
    protected $table = 'site_setting';
    protected $fillable = [
        # نام کلید
        'name',
        # مقدار
        'value',
        'title'
    ];
}
