<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Sms extends BaseModel
{
    protected $table = 'sms';
    protected $fillable = [
        'type',
        'mobile',
        'user_id',
        'text',
        'udh'
    ];
    protected $hidden = ['created_at'];

    /**
     * کاربر ثبت کننده ملک
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
