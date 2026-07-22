<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Spatie\Permission\Traits\HasRoles;

/**
 * جایگزین کردن namespace کلاس مدل با نام مدل
 */
Relation::morphMap( [
	'ticket'  => 'App\Model\Ticket',
	'ticket_message'  => 'App\Model\TicketMessage',
] );

class Attachment extends Model {
    /**
     * این جدول برای نگه داری فایل های ضمیمه در جاهای مختلف مثل تیکت پشتیبانی یا گفتگو و یا هرجایی که نیاز به اضافه کردن فایل ضمیمه باشد قابل استفاده است
     *  در این جدول از رابطه پلی‌مورفیک یک به چند استفاده شده است
     *
     * @var string
     */
	protected $table = 'attachments';

    /**
     * لیست فیلدهای قابل پذیرش در زمان ثبت یا ویرایش
     *
     * @var array
     */
	protected $fillable = [
	    # نام کلاس مدل (در خط های ابتدایی همین فایل توضیح داده شده است)
	    'model_type',
        # شناسه مدل هدف
        'model_id',
        # عنوان فایل ضمیمه
        'file_name',
        # نام فایل
        'file_url',
        # نوع فرمت یا پسوند فایل
        'file_type',
        # اندازه فایل به مگابایت
        'file_size'
    ];


    /**
     * لیست فیلدهایی که در زمان نمایش نمایش داده نمیشوند
     *
     * @var array
     */
	protected $hidden = [ 'created_at', 'updated_at', 'pivot' ];


    /**
     * فیلدهایی که باید به تاریخ تبدیل شوند
     *
     * @var array
     */
	protected $dates = [ 'created_at', 'updated_at' ];

    /**
     * ریلیشن model مدل هدفی که این فایل ضمیمه به آن مرتبط شده است را برمیگرداند
     *
     * @return object
     */
	public function model() {
		return $this->morphTo();
	}
}
