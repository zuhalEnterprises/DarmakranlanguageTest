<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends BaseModel {
	protected $table = 'project';
	protected $fillable = [
	    'manufacturer_id',
        'name',
        'post_id',
        'city_id',
        'district_id',
        'estate_id'
    ];

	public function manufacturer() {
		return $this->belongsTo( Manufacturer::class, 'manufacturer_id' );
	}

    public function post() {
		return $this->belongsTo( Post::class, 'post_id' );
	}

    /**
     * شهری که ملک در آن ثبت شده است
     *
     * @return object
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    /**
     * محله ای که ملک در آن ثبت شده است
     *
     * @return object
     */
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
}
