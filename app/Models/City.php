<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends BaseModel {
    /**
     *  شهرها
     *
     * @var string
     */
	protected $table = 'cities';

    /**
     * فیلدهای قابل پذیرش در زمان ثبت یا ویرایش
     *
     * @var array
     */
	protected $fillable = [
	    # شناسه استان
	    'province_id',
        # کد شهر
        'code',
        # نام فارسی شهر
        'name',
        # نام لاتین شهر
        'name_en',
        'count_area',
        # عرض جغرافیایی
        'posx',
        # طول جغرافیایی
        'posy',
        # چند ضلعی
        'boundary',
        # محدودیت انتخاب تعداد محله فعالیت برای کارشناس در شهر موردنظر
        'district_selection_count',
        # حداقل امتیاز جهت ارتقا به سطح کارشناس
        'expert_required_points',
        # وضعیت فعال: 0=غیرفعال 1=فعال
        'active',
        'count_area',
        'post_id'
    ];

    public function getNameAttribute($value)
    {
        return (app()->getLocale() === 'en' && !empty($this->attributes['name_en']))
            ? $this->attributes['name_en']
            : $value;
    }

    public function getOriginalName()
    {
        return $this->getAttributes()['name'];
    }
    public function getOriginalNameEn()
    {
        return $this->getAttributes()['name_en'];
    }
    /**
     * استان
     *
     * ارتباط از طریق کلید خارجی province_id
     *
     * @return object
     */
	public function province() {
		return $this->belongsTo( Province::class, 'province_id' );
	}

    public function post() {
		return $this->belongsTo( Post::class, 'post_id' );
	}

	/**
     * لیست محله های وابسته به این شهر
     *
     * ارتباط از طریق کلید خارجی city_id
     *
     * @return object
     */
	public function districts() {
		return $this->hasMany( District::class, 'city_id' );
	}

}
