<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class AdjacentStreet extends Model
{
    /**
     * جدول محله های همجوار
     *
     * از این جدول برای نگه داری محل های همجوار یک محله استفاده میشود
     *
     * @var string
     */
    protected $table = 'adjacent_streets';

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
    protected $fillable = [ 'street_id', 'adjacent_street_id','adjacent_district_id' ];


    public function streets() {
        return $this->belongsTo( Street::class, 'adjacent_street_id');
    }

    public function districts() {
        return $this->belongsTo( District::class, 'adjacent_district_id');
    }
}
