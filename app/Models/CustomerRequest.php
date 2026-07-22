<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerRequest extends Model {

    /**
     * این مدل به همراه جدول نیاز به بحث و گفتگو دارد
     *
     */

	use SoftDeletes;
	protected $table = 'customer_requests';
	protected $fillable = [
		'customer_id',
		'province_id',
		'city_id',
		'district_id',
		'request_type',
		'estate_type',
		'price_min',
		'price_max',
		'mortgage_min',
		'mortgage_max',
		'rent_min',
		'rent_max',
		'area_min',
		'area_max',
		'rooms_min',
		'loan_min',
		'loan_max',
		'floor_min',
		'floor_max',
		'max_unit_per_floor',
		'document_type',
		'free_document',
		'clergy_special',
		'date_from',
		'date_to',
		'address',
	];

	protected $hidden = [ 'created_at', 'updated_at', 'deleted_at' ];
	protected $dates = ['date_from', 'date_to', 'created_at', 'updated_at', 'deleted_at'];
	protected $casts = [ 'district_id' => 'array', 'estate_type' => 'array' ];

	public function customer() {
		return $this->belongsTo( Customer::class, 'customer_id' );
	}

	public function province() {
		return $this->belongsTo( Province::class, 'province_id' );
	}

	public function city() {
		return $this->belongsTo( City::class, 'city_id' );
	}
}
