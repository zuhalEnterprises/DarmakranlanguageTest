<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CustomerNote extends Model
{
    /**
     * یادداشت های مشتری
     *
     * @return string
     */
    protected $table = 'customer_notes';
    protected $fillable = [
        'user_id',
        'customer_id',
        'note',
        'ip',
        'agent',
        'device'
    ];
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * کاربری که برای مشتری یادداشت ثبت کرده است
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * مشتری ای که به بروی آن یادداشت ثبت شده است
     *
     * @return object
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
