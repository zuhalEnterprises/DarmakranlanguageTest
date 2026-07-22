<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstateEdit extends Model
{
    /**
     * بازدیدهای ملک
     *
     * @return string
     */
    protected $table = 'estate_edits';
    protected $fillable = [
        'estate_id',
        'user_id',
        'changefrom',
        'changeto',
        'type',
        'confirm'
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
