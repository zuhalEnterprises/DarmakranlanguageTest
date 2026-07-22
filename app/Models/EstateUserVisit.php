<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstateUserVisit extends Model
{
    /**
     * بازدیدهای ملک
     *
     * @return string
     */
    protected $table = 'estate_user_visits';
    protected $fillable = [
        'estate_id',
        'user_id'
    ];
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * ملک بازدید شده
     *
     * @return object
     */
    public function estate()
    {
        return $this->belongsTo(Estate::class, 'estate_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
