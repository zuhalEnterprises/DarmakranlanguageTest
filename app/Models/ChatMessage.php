<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    /**
     *  پیام های گفتگو (پیام های چت)
     *
     * @var string
     */
    protected $table = 'chat_messages';

    /**
     * فیلدهای قابل پذیرش در زمان ثبت یا ویرایش
     *
     * @var array
     */
    protected $fillable = [
        # شناسه گفتگو
        'chat_id',
        # شناسه کاربر فرستنده
        'user_id',
        # نوع پیام: 1=متنی 2=غیرمتنی
        'type',
        # متن پیام
        'body',
        # وضعیت پیام: 0=خوانده نشده 1=خوانده شده
        'is_seen',
        # وضعیت حذف توسط فرستنده: 0=بله 1=خیر
        'deleted_from_sender',
        # وضعیت حذف توسط گیرنده: 0=بله 1=خیر
        'deleted_from_receiver',
    ];

    /**
     *  گفتگویی که این پیام به آن تعلق دارد
     *
     * ارتباط از طریق کلید خارجی chat_id
     *
     * @return object
     */
    public function chat()
    {
        return $this->belongsTo(Chat::class, 'chat_id');
    }

    /**
     * کاربر فرستنده
     *
     * ارتباط از طریق کلید خارجی user_id
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * وضعیت مشاهده پیام
     *
     * @return string
     */
    public function seen()
    {
        return $this->is_seen == 1 ? '<i class="far fa-check-double" style="color:green"></i>' : '<i class="fas fa-check text-muted"></i>';
    }
}
