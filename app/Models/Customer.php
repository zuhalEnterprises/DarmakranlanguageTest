<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Customer extends BaseModel
{
    use SoftDeletes, HasRoles;
    /**
     * نوع محافظت برای دسترسی نقش ها : web || api
     *
     * @return string
     */
    protected $guard_name = 'web';
    /**
     * مشتریان
     *
     * @var string
     */
    protected $table = 'customers';

    protected $fillable = [
        'title',
        'user_id',
        'referrer_id',
        'guid',
        'city_id',
        'name',
        'gender',
        'country_id',
        'mobile',
        'mobile2',
        'phone',
        'description',
        'job',
        'residence_type',
        'education',
        'estate_type',
        'request_type',
        'price_min',
        'price_max',
        'mortgage_min',
        'mortgage_max',
        'rent_min',
        'rent_max',
        'area_min',
        'area_max',
        'purchase_reason',
        'purchase_priority',
        'financial_liquidity_type',
        'acquaintance_type',
        'acquaintance',
        'label',
        'status',
        'active',
        'note',
        'max_room_count',
        'max_unit_in_floor',
        'max_building_age',
        'conditions',
        'facilities',
        'usage_type',
        'floor_count',
        'min_floor_count',
        'floor_start',
        'min_floor_area',
        'min_front_area',
        'min_street_width',
        'min_built_area',
        'min_density',
        'floor_min',
        'geography',
        'build_license',
        'build_date',
        'create_id',
        //'confirmation',
        'datereconfirm',
        'compensation',
        'document_type',
        'resenddate',
        'special',
        'lastdateSms',
        'countSms',
        'completion_date',
        'country_id',
        'language_id',
        'unit_in_complex',
        'existing_document',
        'grade'
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
    public function Referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    public function get_acquaintance_type()
    {
        return $this->belongsTo(Acquaintance::class, 'acquaintance_type');
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'create_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    /**
     * لیست محله هایی که مشتری درخواست ملک کرده است
     *
     * @return object
     */
    public function districts()
    {
        return $this->belongsToMany(District::class, 'customer_districts', 'customer_id', 'district_id')->withTimestamps();
    }

    /**
     * گفتگوهایی که در رابطه با مشتری وجود دارد
     *
     * @return object
     */
    public function chats()
    {
        return $this->hasMany(Chat::class, 'customer_id');
    }

    /**
     * یادداشت هایی که در رابطه با این مشتری توسط کاربران ثبت شده است
     *
     * @return object
     */
    public function notes()
    {
        return $this->hasMany(CustomerNote::class, 'customer_id');
    }


    /**
     * لیست یورزهایی که این ملک در لیست علاقه مندی ها وجود دارد
     *
     * @return object
     */
    public function favorites()
    {
        return $this->belongsToMany(User::class,'customer_favorites','customer_id','user_id')->withTimestamps();
    }

    public function url()
    {
        return "/customer/".$this->id;
    }
}
