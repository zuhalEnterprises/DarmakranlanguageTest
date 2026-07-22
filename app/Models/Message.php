<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * جایگزین کردن namespace کلاس مدل با نام مدل
 */
Relation::morphMap([
    'estate' => 'App\Model\Estate',
    'branch' => 'App\Model\Branch'
]);

class Message extends Model
{
    /**
     * پیام های مربوط به تغییروضعیت یا ویرایش و ثبت : توجه داشته باشید که این مدل با لاگ متفاوت است
     *  در این جدول از رابطه پلی‌مورفیک یک به چند استفاده شده است
     *
     * @var string
     */
    protected $table = 'messages';

    /**
     * لیست فیلدهای قابل پذیرش در زمان ثبت یا ویرایش
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'model_type',
        'model_id',
        'model_status',
        'message',
        'seen',
    ];
    protected $hidden = ['updated_at'];

    /**
     * کاربر هدف که پیام برای او قابل مشاهده است
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * مدل هدفی که پیام به برای آن ثبت شده است
     *
     * @return object
     */
    public function model() {
        return $this->morphTo();
    }
}
