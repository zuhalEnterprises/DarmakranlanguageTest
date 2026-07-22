<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLanguage extends Model
{
    public $timestamps = false;

    /**
     * زبان هایی که به کاربران اختصاص داده شده است
     */
    protected $table = 'user_languages';
    public $fillable=['user_id','language_id'];

    /**
     * کاربری که این زبان به او اختصاص داده شده است
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    /**
     * زبان اختصاص یافته به کاربر
     *
     * @return object
     */
    public function language()
    {
        return $this->belongsTo(Language::class,'language_id');
    }
}
