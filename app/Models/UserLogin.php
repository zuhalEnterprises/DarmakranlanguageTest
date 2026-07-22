<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLogin extends Model
{
    /**
     * کدهای ورود پیامکی
     */
    protected $table = 'user_logins';
    public $fillable = [
        'user_id',
        'code',
        'used',
        'ip',
        'agent',
        'device'
    ];

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
