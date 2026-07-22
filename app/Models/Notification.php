<?php

namespace App\Models;

use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Notification extends BaseModel
{
    /**
     * اعلان ها
     *
     * @return object
     */
    protected $table = 'notifications';
    protected $fillable = [
        'city_id',
        'user_id',
        'role_id',
        'image',
        'title',
        'body',
        'url',
        'validity',
        'systemic',
        'send_to_all',
        'is_expired',
        'send_at',
        'expired_at'
    ];
    protected $dates = ['send_at', 'expired_at', 'created_at', 'updated_at'];
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * شهر هدف که اعلان بروی آن ارسال شده است
     *
     * @return object
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    /**
     * کاربر هدف که اعلان بروی آن ارسال شده است
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * نقش کاربری هدف که اعلان بروی آن ارسال شده است
     *
     * @return object
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * آدرس نهایی تصویر بکار برده شده در اعلان
     *
     * @return object
     */
    public function image()
    {
        $img = !empty($this->image) ? 'notification/' . $this->image : $this->image;
        return getImage($img);
    }

    /**
     * فیلتر براساس تاریخ ثبت قولنامه : برای نمونه در لیست قولنامه های بخش مدیریت انجام شده است
     *
     * @param $query
     * @param $date
     *
     * @return Builder
     */
    // filters scope
    // start date
    public function scopeStartsBefore(Builder $query, $date): Builder
    {
        $datetime = Verta::parse($date)->DateTime()->format('Y-m-d H:i:s');

        return $query->whereDate('created_at', $datetime);
    }
    // end date
    public function scopeCreateDate(Builder $query, $date): Builder
    {
        $datetime = Verta::parse($date)->DateTime()->format('Y-m-d H:i:s');

        return $query->whereDate('created_at', $datetime);
    }
}
