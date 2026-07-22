<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends BaseModel
{
    /**
     * وظایف کاربران
     *
     * @return string
     */
    protected $table = 'tasks';
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'color',
        'time_of_do',
        'done'
    ];
    protected $dates = ['time_of_do', 'created_at', 'updated_at'];
    protected $hidden = ['created_at', 'updated_at'];

    // این آرایه بعد از بررسی حذف شود
    public $fields = [
        'user_id',
        'title',
        'description',
        'color',
        'time_of_do',
        'done'
    ];

    /**
     * کاربر ثبت کننده تسک
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
