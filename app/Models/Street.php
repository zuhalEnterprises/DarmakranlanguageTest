<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Street extends BaseModel {
    /**
     * زیر محله ها
     *
     * @return string
     */
	protected $table = 'streets';
	protected $fillable = [ 'province_id',  'city_id','district_id', 'name', 'posx', 'posy', 'active' ,'divar','balad',
   'post_id','avgLand','avgApartment','avgApartment5','avgApartment10'];
	protected $hidden = [ 'created_at', 'updated_at' ];

    /**
     * استانی که خیابان موردنظر به آن وابسته است
     *
     * @return object
     */
	public function province() {
		return $this->belongsTo( Province::class, 'province_id' );
	}

    /**
     * شهری که خیابان موردنظر به آن وابسته است
     *
     * @return object
     */
	public function city() {
		return $this->belongsTo( City::class, 'city_id' );
	}

    /**
     * محلی که خیابان موردنظر به آن وابسته است
     *
     * @return object
     */
	public function district() {
		return $this->belongsTo( District::class, 'district_id' );
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
    public function adjacentStreets()
    {
        return $this->hasMany( AdjacentStreet::class, 'street_id' );
    }
    public function post() {
		return $this->belongsTo( Post::class, 'post_id' );
	}
}
