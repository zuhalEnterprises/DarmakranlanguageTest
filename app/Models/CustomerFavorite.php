<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerFavorite extends Model
{
    /**
     * لیست مشتریان علاقه مند شده
     *
     * @return string
     */
    protected $table = 'customer_favorites';
    protected $fillable = [ 'user_id', 'customer_id' ];
    protected $hidden = [ 'created_at', 'updated_at' ];

    /**
     * کاربری که مشتری را به لیست علاقه مندی ها اضافه کرده است
     *
     * @return object
     */
    public function user() {
        return $this->belongsTo( User::class, 'user_id' );
    }

    /**
     * مشتری ای که به لیست علاقه مندی ها اضافه شده است
     *
     * @return object
     */
    public function customer() {
        return $this->hasMany( Customer::class, 'customer_id' );
    }
}
