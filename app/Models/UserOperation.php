<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOperation extends Model
{
    /**
     * یادداشت های ملک
     *
     * @return string
     */
    protected $table = 'user_operations';
    protected $fillable = [
        'expert_id',
        'comment',
        'type',
        'score'
    ];
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * کاربری که برای ملک یادداشت ثبت کرده است
     *
     * @return object
     */
    public function expert()
    {
        return $this->belongsTo(User::class, 'expert_id');
    }


    public function typeName()
    {
        switch($this->type){
            case 1: $name='کت و شلوار'; break;
            case 2: $name='تاخیر'; break;
            case 3: $name='عدم فعالیت در سایت'; break;
            case 4: $name='جلسه مذاکره حضوری'; break;
            case 5: $name='امتیاز مدیریت'; break;
        }
        return $name;
    }
}

