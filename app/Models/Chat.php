<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    /**
     *  گفتگوها (چت)
     *
     * @var string
     */
    protected $table = 'chats';

    /**
     * فیلدهای قابل پذیرش در زمان ثبت یا ویرایش
     *
     * @var array
     */
    protected $fillable = [
        # شناسه ملک هدف گفتگو : ملک
        'estate_id',
        # شناسه مشتری هدف گفتگو: مشتری
        'customer_id',
        # شناسه کارشناس هدف گفتگو: کارشناس
        'expert_id',
        # شناسه کاربر فرستنده
        'sender_id',
        # شناسه کاربر گیرنده
        'receiver_id',
        # موضوع گفتگو
        'subject'
    ];

    /**
     *  ملک هدف در گفتگو
     *
     * ارتباط از طریق کلید خارجی estate_id
     *
     * @return object
     */
    public function estate()
    {
        return $this->belongsTo(Estate::class, 'estate_id');
    }

    /**
     *  مشتری هدف در گفتگو
     *
     * ارتباط از طریق کلید خارجی customer_id
     *
     * @return object
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     *  کاربر فرستنده: کاربری که گفتگو رو شروع کرده است
     *
     * ارتباط از طریق کلید خارجی sender_id
     *
     * @return object
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     *  کاربر گیرنده
     *
     * ارتباط از طریق کلید خارجی receiver_id
     *
     * @return object
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /**
     *  پیام های گفتگو
     *
     * ارتباط از طریق کلید خارجی chat_id
     *
     * @return object
     */
    public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'chat_id');
    }
}
