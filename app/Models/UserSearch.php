<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSearch extends BaseModel
{
    /**
     * جستجوهای کاربران
     */
    protected $table = 'user_searches';
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'description',
        'url',
        'filters',
        'ip',
        'agent',
        'device'
    ];
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * کاربر ثبت کننده جستجو
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
