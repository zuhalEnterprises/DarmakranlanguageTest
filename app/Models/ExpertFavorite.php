<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpertFavorite extends Model
{
    /**
     * لیست کارشناسان علاقه مند شده
     *
     * @return string
     */
    protected $table = 'expert_favorites';
    protected $fillable = ['user_id', 'expert_id', 'pin'];
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * کاربری که کارشناس مورد نظر را به لیست علاقه مندی ها اضافه کرده است
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * کارشناسی که به لیست علاقه مندی ها اضافه شده است
     *
     * @return object
     */
    public function expert()
    {
        return $this->belongsTo(User::class, 'expert_id');
    }
}
