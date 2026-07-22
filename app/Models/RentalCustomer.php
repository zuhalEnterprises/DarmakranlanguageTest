<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class RentalCustomer extends BaseModel
{
    use SoftDeletes, HasRoles;
    /**
     * نوع محافظت برای دسترسی نقش ها : web || api
     *
     * @return string
     */
    protected $guard_name = 'web';

    protected $table = 'rental_customers';

    protected $fillable = [
        'user_id',
        'guid',
        'name',
        'gender',
        'mobile',
        'description',
        'stay_from',
        'stay_to',
        'with_family',
        'person_count',
        'estate_id',
        'status',
        'price'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * کارشناسی که مشتری را ثبت کرده است
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function statusname()
    {
        switch($this->status){
            case 1: $name='در انتظار تائید'; break;
            case 2: $name='تائید شده مالک'; break;
            case 3: $name='تائید'; break;
            case 4: $name='آرشیو'; break;
        }
        return $name;
    }
}
