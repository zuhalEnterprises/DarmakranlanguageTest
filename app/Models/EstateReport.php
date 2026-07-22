<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstateReport extends Model
{
    /**
     * گزارشات مشکل ملک
     *
     * @return string
     */
    protected $table = 'estate_reports';
    protected $fillable = [
        'user_id',
        'estate_id',
        'reason_group',
        'reason_subgroup',
        'description',
        'ip',
        'agent',
        'device',
        'status'
    ];
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * کاربری که برای ملک گزارش مشکل ثبت کرده است
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * ملک ای که به برای آن گزارش مشکل ثبت شده است
     *
     * @return object
     */
    public function estate()
    {
        return $this->belongsTo(Estate::class, 'estate_id');
    }
}
