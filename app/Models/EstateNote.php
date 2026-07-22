<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstateNote extends Model
{
    /**
     * یادداشت های ملک
     *
     * @return string
     */
    protected $table = 'estate_notes';
    protected $fillable = [
        'user_id',
        'estate_id',
        'note',
        'ip',
        'agent',
        'device'
    ];
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * کاربری که برای ملک یادداشت ثبت کرده است
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * ملک ای که به بروی آن یادداشت ثبت شده است
     *
     * @return object
     */
    public function estate()
    {
        return $this->belongsTo(Estate::class, 'estate_id');
    }
}
