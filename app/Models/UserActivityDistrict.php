<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserActivityDistrict extends Model
{
    /**
     * محل های فعالیت کارشناس
     */
    protected $table = 'user_activity_districts';
    public $fillable = [
        'user_id',
        'district_id',
        'selection_count',
        'selection_count',
        'ratio'
    ];
    protected $casts = ['selection_count' => 'integer'];

    /**
     * کاربر ثبت کننده محل فعالیت
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * محلی که کاربر انتخاب کرده است
     *
     * @return object
     */
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
}
