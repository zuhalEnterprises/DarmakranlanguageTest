<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerDistrict extends Model
{
    /**
     * محله های درخواست ملک برای مشتری
     *
     * @return string
     */
    protected $table = 'customer_districts';
    protected $fillable = [ 'customer_id', 'district_id' ];
    protected $hidden = [ 'created_at', 'updated_at' ];

    /**
     * مشتری
     *
     * @return object
     */
    public function customer() {
        return $this->belongsTo( Customer::class, 'customer_id' );
    }

    /**
     * محله
     *
     * @return object
     */
    public function district() {
        return $this->belongsTo( District::class, 'district_id' );
    }
}
