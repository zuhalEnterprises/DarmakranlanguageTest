<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class District extends BaseModel {
    /**
     * محله ها
     *
     * @return string
     */
	protected $table = 'districts';
	protected $fillable = [ 'province_id', 'city_id', 'area', 'name','name_en', 'posx', 'posy', 'active' ,'divar','village','balad',
    'post_id','avgLand','avgApartment','avgApartment5','avgApartment10'];
	protected $hidden = [ 'created_at', 'updated_at' ];

    public function getNameAttribute($value)
    {
        if (app()->getLocale() === 'en') {
            return $this->attributes['name_en'];
        }
        return $value;
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
     * استانی که محله موردنظر به آن وابسته است
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
     * شهری که محله موردنظر به آن وابسته است
     *
     * @return object
     */
	public function city() {
		return $this->belongsTo( City::class, 'city_id' );
	}

    /**
     * کاربرانی که در این محله موردنظر وجود دارند
     *
     * @return object
     */
	public function users() {
		return $this->hasMany( User::class );
	}

    /**
     * محله های مجاور با محله موردنظر
     *
     * @return object
     */
    public function adjacentDistricts()
    {
        return $this->hasMany( AdjacentDistrict::class, 'district_id' );
    }
}
