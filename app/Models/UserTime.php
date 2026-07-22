<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTime extends Model
{
    /**
     * کدهای ورود پیامکی
     */
    protected $table = 'user_time';
    public $fillable = [
        'user_id',
        'archived',
        'time'
    ];
    protected $hidden = ['created_at', 'updated_at'];
    /**
     * کاربر دریافت کننده کد تایید ورود از طریق پیامک
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
