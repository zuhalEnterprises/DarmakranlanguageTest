<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends BaseModel {
    /**
     * استان ها
     *
     * @return string
     */
	protected $table = 'provinces';
	protected $fillable = [ 'name', 'active' ];
	protected $hidden = [ 'created_at', 'updated_at' ];

    /**
     * لیست شهرهای یک استان
     *
     * @return object
     */
	public function cities() {
		return $this->hasMany( City::class, 'province_id' );
	}

}
