<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class AdjacentDistrict extends Model
{
    /**
     * جدول محله های همجوار
     *
     * از این جدول برای نگه داری محل های همجوار یک محله استفاده میشود
     *
     * @var string
     */
    protected $table = 'adjacent_districts';

    /**
     * غیرفعال کردن فیلدهای تاریخ ایجاد و اپدیت برای جدول
     *
     * @var bool $timestamps
     */
    public $timestamps = false;

    /**
     * فیلدهای قابل پذیرش در جدول
     *
     * لیست فیلدهای قابل پذیرش در زمان ثبت یا ویرایش
     *
     * @var array
     */
    protected $fillable = [ 'district_id', 'adjacent_district_id' ];

    /**
     *  محله ی هدفی که این (محل یا AdjacentDistrict) با آن همجوار است
     *
     * این قابلیت در بخش مدیریت محله ها (ایجاد و ویرایش) قابل دسترس است
     * ریلیشن district که با کلید خارجی district_id به (محله یا district) مرتبط است و خروجی آن بصورت یک نمونه از مدل District میباشد
     *
     * @return object
     */
    public function district() {
        return $this->belongsTo( District::class, 'adjacent_district_id');
    }
}
